# -*- coding: utf-8 -*-
from __future__ import print_function

import os
import argparse
import json
import pprint
import requests
import sys
import math
import googlemaps
import csv
import xlsxwriter
import time
import unicodecsv as csv

import mysql.connector
from mysql.connector import Error

import urllib
# This client code can run on Python 2.x or 3.x.  Your imports can be
# simpler if you only need one of those.
try:
    # For Python 3.0 and later
    from urllib.error import HTTPError
    from urllib.parse import quote
    from urllib.parse import urlencode
except ImportError:
    # Fall back to Python 2's urllib2 and urllib
    from urllib2 import HTTPError
    from urllib import quote
    from urllib import urlencode

path = os.path.dirname(os.path.realpath(__file__))
file_name = '/config.json'
path_config = os.path.dirname(path)+file_name

# sql connection
host = json.load(open(path_config))['db_host']
database = json.load(open(path_config))['db_database']
user = json.load(open(path_config))['db_user']
password = json.load(open(path_config))['db_password']

# Google API key and token
API_KEY_google = json.load(open(path_config))['API_KEY_google_maps']
my_token = json.load(open(path_config))['API_Token_google_maps']

# Yelp API constants (you shouldn't have to change these)
API_HOST = 'https://api.yelp.com'
API_KEY = 'YNdYUZIv_vhxrK2fY2K2JdI5FNmW9ESOOK4w8kpGeJv_qvmP74bjg2iqla_XlZJSF2qbwLaMqwH6oWU_GV6dE8hRyYpbX5UqpF9ne7q_6q1peS17TZ3LQNRcoCSBXnYx'

SEARCH_PATH = '/v3/businesses/search'
BUSINESS_PATH = '/v3/businesses/'  # Business ID will come after slash.
yelp_dict = {}

DEFAULT_TERM = ''
DEFAULT_LOCATION = 'Portland, OR'
SEARCH_LIMIT = 3

# export google photos (True = export photos; False = do not export photos)
getphotos = False
export_path = 'output/img'

# export data to .cvs or .xlsx
write_to_csv = False
write_to_xlsx = False

# import and export tables
table_names = [
                ["list_eatSF","eatSF"],
                ["list_breweriesSF","breweriesSF"],
                ["list_barsSF","barsSF"],
                ["list_eatPDX","eatPDX"],
                ["list_breweriesPDX","breweriesPDX"],
                ["list_barsPDX","barsPDX"],
                ["list_golfPDX","golfPDX"],
                ["list_wineriesSF","wineriesSF"],
                ["list_eatCDMX","eatCDMX"]
            ]

# import and export table selection
list_table_name = table_names[0][0]
table_name = table_names[0][1]

# SQL - if table does not exist create it ==========================
try:
    connection = mysql.connector.connect(host=host,
                                         database=database,
                                         user=user,
                                         password=password)

    sql = "Select * from " + table_name+";"

    cursor = connection.cursor()
    cursor.execute(sql)

except Error as e:
    print("Table not found - creating table now", e)
    
    sql = "CREATE TABLE "+ table_name +" (col1 int, name longtext, address text, zipcode text, category text, website text, photo text, photo_credit mediumtext, google_maps_link_ text, google_maps_link text, lat text, lng text, price_range text, price_range_grey text, yelp_rating text, yelp_stars text, yelp_review_count text, google_rating text, google_stars text, google_stars_grey text, google_review_count text, PRIMARY KEY (col1));"
    cursor = connection.cursor()
    cursor.execute(sql)

finally:
    if (connection.is_connected()):
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
# =================================================================

# SQL - clear table ===============================================
try:
    connection = mysql.connector.connect(host='192.254.251.13',
                                         database='brandonb_places',
                                         user='brandonb_brandon',
                                         password='testing123')

    sql_select_Query = "Truncate TABLE "+table_name+";"

    cursor = connection.cursor()
    cursor.execute(sql_select_Query)

except Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if (connection.is_connected()):
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
# =================================================================

# SQL - get field names from table ================================
try:
    connection = mysql.connector.connect(host='192.254.251.13',
                                         database='brandonb_places',
                                         user='brandonb_brandon',
                                         password='testing123')
    
    col_list = ""    
    value_list = "'1','2','3','4','5','6','7','8','9','10','11','12','13','14'"

    sql_select_Query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '"+table_name+"';"

    cursor = connection.cursor()
    cursor.execute(sql_select_Query)
    columns_list = cursor.fetchall()
    for column in columns_list:
        col_list = col_list+","+column[0]

    col_list = col_list[1:]

except Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if (connection.is_connected()):
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
# =================================================================

# SQL - get list of places ========================================
try:
    connection = mysql.connector.connect(host='192.254.251.13',
                                         database='brandonb_places',
                                         user='brandonb_brandon',
                                         password='testing123')

    sql_select_Query = "SELECT place FROM "+list_table_name+";"
    
    cursor = connection.cursor()
    cursor.execute(sql_select_Query)
    sql_output = cursor.fetchall()
    
    place_list = []
    
    for row in sql_output:
        place_list.append(row[0])

except Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if (connection.is_connected()):
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
# =========================================================

place_entries = place_list

# Yelp API  ===============================================
print("Yelp:")

def get_business(api_key, business_id):
    """Query the Business API by a business ID.
    Args:
        business_id (str): The ID of the business to query.
    Returns:
        dict: The JSON response from the request.
    """
    business_path = BUSINESS_PATH + business_id

    return request(API_HOST, business_path, api_key)

def request(host, path, api_key, url_params=None):
    """Given your API_KEY, send a GET request to the API.
    Args:
        host (str): The domain host of the API.
        path (str): The path of the API after the domain.
        API_KEY (str): Your API Key.
        url_params (dict): An optional set of query parameters in the request.
    Returns:
        dict: The JSON response from the request.
    Raises:
        HTTPError: An error occurs from the HTTP request.
    """
    url_params = url_params or {}
    url = '{0}{1}'.format(host, quote(path.encode('utf8')))
    headers = {
        'Authorization': 'Bearer %s' % api_key,
    }

    print(u'Querying {0} ...'.format(url))

    response = requests.request('GET', url, headers=headers, params=url_params)
    return response.json()

def search(api_key, term, location):
    """Query the Search API by a search term and location.
    Args:
        term (str): The search term passed to the API.
        location (str): The search location passed to the API.
    Returns:
        dict: The JSON response from the request.
    """

    url_params = {
        'term': term.replace(' ', '+'),
        'location': location.replace(' ', '+'),
        'limit': SEARCH_LIMIT
    }
    return request(API_HOST, SEARCH_PATH, api_key, url_params=url_params)

def query_api(term, location):
    """Queries the API by the input values from the user.
    Args:
        term (str): The search term to query.
        location (str): The location of the business to query.
    """
    response = search(API_KEY, term, location)

    if 'error' in response:
        response = search(API_KEY, term, location)
    
    if 'error' in response:
        response = search(API_KEY, term, location)

    businesses = response.get('businesses')

    if not businesses:
        print(u'No businesses for {0} in {1} found.'.format(term, location))
        return

    business_id = businesses[0]['id']
    print(u'{0} businesses found, querying business info for the top result "{1}" ...'.format(len(businesses), business_id))
    response = get_business(API_KEY, business_id)
    
    if 'error' in response:
        response = get_business(API_KEY, business_id)
    
    if 'error' in response:
        response = get_business(API_KEY, business_id)

    if 'error' in response:
        print(response['error'])
    
    if response is 'error':
        print('null----------')
        print('Key error')

    print(u'Result for business "{0}" found:'.format(business_id))

    yelp_dict['rating'] = response['rating']
    yelp_dict['name'] = response['name']
    yelp_dict['review_count'] = response['review_count']
    
    yelp_categories = ''
    ctr = 0
    for cat in response['categories']:        
        yelp_categories = yelp_categories +', ' + cat['title']
        ctr = ctr + 1
    yelp_categories = yelp_categories[2:len(yelp_categories)]

    yelp_dict['categories']=yelp_categories

    return yelp_dict

from time import sleep

yelp_results = []

for place in place_entries:
    parser = argparse.ArgumentParser()    
    parser.add_argument('-q', '--term', dest='term', default=place,
                        type=str, help='Search term (default: %(default)s)')
    parser.add_argument('-l', '--location', dest='location',
                        default=DEFAULT_LOCATION, type=str,
                        help='Search location (default: %(default)s)')

    input_values = parser.parse_args()

    try:
        query_api(input_values.term, input_values.location)

    except HTTPError as error:
        sys.exit(
            'Encountered HTTP error {0} on {1}:\n {2}\nAbort program.'.format(
                error.code,
                error.url,
                error.read(),
            )
        )

    print("yelp_result: ")
    print(yelp_dict.copy())

    yelp_results.append(yelp_dict.copy())

print('===================================================')
print(' ')
# =======================================================

# Define the Client
gmaps = googlemaps.Client(key = API_KEY_google)

stored_results = []

print('===================================================')
print('Google:')

c = 0

for my_place_id in place_entries:
    place_fields = ['address_component','photo','name','price_level','geometry/location/lat','geometry/location/lng','rating','place_id','website','formatted_address','type','vicinity','review','user_ratings_total','url']
    print(str(c)+': '+str(my_place_id))

    c = c + 1

    placeSearch = gmaps.places_autocomplete(my_place_id, session_token=my_token,  types='establishment')
    
    if len(placeSearch) == 0:
        print('Google could not autocomplete for location entry. placeSearch'+ str(c) +' is empty')

    if not len(placeSearch) == 0:
        placeSearch = placeSearch[0]
        pid = placeSearch['place_id']
        places_details  = gmaps.place(place_id= pid , fields= place_fields)
        result = places_details['result']
        
        next = False

        if places_details['result']['address_components'][5]['types'][0] == 'postal_code':
            zipcode = places_details['result']['address_components'][5]['short_name']
            next = True

        if next == False:
            if places_details['result']['address_components'][6]['types'][0] == 'postal_code':
                zipcode = places_details['result']['address_components'][6]['short_name']
                next = True

        if next == False:
            if places_details['result']['address_components'][7]['types'][0] == 'postal_code':
                zipcode = places_details['result']['address_components'][7]['short_name']

        name = places_details['result']['name']

        if 'price_level' in places_details['result']:
            price = int(places_details['result']['price_level'])*"$"
            price_none = str((4-int(places_details['result']['price_level']))*'$')
        else:
            print('Price level is not availble from Google for this location. Default pricing assigned.')
            price = "$"
            price_none = "$$$"
        
        # print(places_details['result'].keys())

        if 'photos' in places_details['result']:
            photo_reference = places_details['result']['photos'][0]['photo_reference']
            raw_image_data = gmaps.places_photo(photo_reference = photo_reference, max_width=1000, max_height=1000)
            places_details['result']['photo_credit'] = places_details['result']['photos'][0]['html_attributions'][0]
        else:
            # print('photos not in result')
            places_details['result']['photo_credit'] = ''

        if 'rating' in places_details['result']:
            print('1rating: ')
            print(places_details['result']['rating'])
        else:
            print('rating not in result')
            places_details['result']['rating'] = 0

        if 'user_ratings_total' in places_details['result']:
            print('user_ratings_total: ')
            print(places_details['result']['user_ratings_total'])
        else:
            print('user rating total not in result')
            places_details['result']['user_ratings_total'] = 0

        # ======================================================================================================
        # ======================================================================================================
        # export google photos =================================================================================
        if getphotos == True:
            if not os.path.exists(export_path+table_name):
                os.makedirs(export_path+table_name)

            # Open and write photo data chunks to file
            f = open(export_path+table_name+'/'+name+'.jpg','wb')
            
            print("raw image data:")
            print(raw_image_data)
            for chunk in raw_image_data:
                if chunk:
                    f.write(chunk)
            f.close()
        # ======================================================================================================
        # ======================================================================================================
        # ======================================================================================================

        # Manually assign vars
        places_details['result']['lat']=str(places_details['result']['geometry']['location']['lat'])
        places_details['result']['lng']=str(places_details['result']['geometry']['location']['lng'])
        places_details['result']['photo']='img/'+table_name+'/'+name+'.jpg'
        places_details['result']['counter']=str(c)
        places_details['result']['description']=''
        places_details['result']['category']=places_details['result']['types'][0]
        places_details['result']['gmap_link']='https://www.google.com/maps/search/?api=1&query=45.5051,-122.6750&query_place_id=' + pid
        places_details['result']['instagram_link']='https://www.instagram.com/'
        places_details['result']['price_point']=price
        places_details['result']['price_none']=price_none
        places_details['result']['break']='x'
        places_details['result']['name']=places_details['result']['name']
        
        formatted_address = places_details['result']['formatted_address']
        zipcode = formatted_address[(len(formatted_address)-10):(len(formatted_address)-5)]

        places_details['result']['zipcode']=zipcode
        places_details['result']['google_rating']=places_details['result']['rating']

        x = places_details['result']['rating']
        xf = math.floor(x)
        xr = round(x)
        y = x - xf
        r = ''
        rg = ''
        if y < .25:
            r = xf*'star_border '
            rg = (5-xf)*'star_border '
        if y >= .25 and y <.75:
            r = xf*'star '+'star_half'
            rg = (4-xf)*'star_border '
        if y >= .75:
            r = xr*'star '
            rg = (5-xr)*'star_border '

        places_details['result']['google_stars'] = str(r)
        places_details['result']['google_stars_grey'] = str(rg)
        places_details['result']['google_review_count']=places_details['result']['user_ratings_total']
        
        if len(yelp_results[c-1]) == 0:
            print("yelp rating not found")
            yelp_results[c-1]['rating'] = 0
            yelp_results[c-1]['review_count']= 0

        places_details['result']['yelp_rating']=yelp_results[c-1]['rating']

        x = yelp_results[c-1]['rating']
        xf = math.floor(x)
        xr = round(x)
        y = x - xf

        r = ''
        if y < .25:
            r = str(xf)
        if y >= .25 and y <.75:
            r= str(xf)+'_half'
        if y >= .75:
            r = str(xr)
        places_details['result']['yelp_stars'] = str(r)
        places_details['result']['yelp_review_count']=yelp_results[c-1]['review_count']

        reordered_dict = ['counter','name','formatted_address','zipcode','category','website','photo','photo_credit','gmap_link','url','lat','lng','price_point','price_none','yelp_rating','yelp_stars','yelp_review_count','google_rating','google_stars','google_stars_grey','google_review_count']
            
        i=0
        for k in reordered_dict:
            try:
                reordered_dict[i] = places_details['result'][reordered_dict[i]]
            except KeyError:
                reordered_dict[i] = ''
                # print('KeyError')
            i = i+1

        stored_results.append(reordered_dict)

print('---------------------------------------------------------------------------')
print('Data fetch complete!!!')
print('---------------------------------------------------------------------------')

# write values to SQL DB =========================
import mysql.connector
from mysql.connector import Error

try:
    connection = mysql.connector.connect(host='192.254.251.13',
                                         database='brandonb_places',
                                         user='brandonb_brandon',
                                         password='testing123')

    col_list = ""
    
    value_list = "'1','2','3','4','5','6','7','8','9','10','11','12','13','14'"

    sql_select_Query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '"+table_name+"';"

    cursor = connection.cursor()
    cursor.execute(sql_select_Query)
    columns_list = cursor.fetchall()
    for column in columns_list:
        col_list = col_list+","+column[0]

    col_list = col_list[1:]

    def sortLat(e):
        return e[10]

    def sortLng(e):
        return e[11]

    def sortzipcode(e):
        return e[3]
    
    stored_results.sort(key=sortLat)
    stored_results.sort(key=sortLng)
    stored_results.sort(key=sortzipcode)

    i = 0
    for row in stored_results:
        i = i + 1
        row[0] = i

    value_table = ""
    for row in stored_results:
        value_list=""
        for item in row:
            value_list = value_list+",'"+str(item).replace("'","''")+"'"
        
        value_list = "("+value_list[1:]+")"

        value_table = value_table+","+value_list        

    value_table = value_table[1:]
    sql_Query = "INSERT INTO "+table_name+" ("+col_list+") VALUES "+value_table+";"
    
    print('Sql Query:')
    print(sql_Query)
    cursor = connection.cursor()
    cursor.execute(sql_Query)

except Error as e:
    print("Error reading data from MySQL table", e)
finally:
    if (connection.is_connected()):
        connection.commit()
        connection.close()
        cursor.close()
        print("MySQL connection is closed")
# =========================================================

# write values to CSV =====================================
if write_to_csv == True:
    with open(path+'/output/'+table_name+'.csv','wb') as fout:
        writer=csv.writer(fout,encoding='UTF-8') #excel uses windows cp1252
        for row in stored_results:
            writer.writerow(row)

# write values to EXCEL ===================================
if write_to_xlsx == True:
    # define the headers, that is just the key of each result dictionary
    row_headers = reordered_dict

    # create a new workbook and a new worksheet
    workbook = xlsxwriter.Workbook(r''+path+'/output/'+table_name+'.xlsx')
    worksheet = workbook.add_worksheet()

    # write header row
    col = 0
    for header in row_headers:
        worksheet.write(0, col, header)
        col += 1

    row = 1
    col = 0

    # write each results
    for result in stored_results:

        # get the values from each result
        result_values = result

        # loop through each value in the values component
        for value in result_values:
            worksheet.write(row, col, value)

            col += 1
        
        # go to the next row & reset the column
        row += 1
        col = 0

    # close the workbook
    workbook.close()

print('End ============================================================')