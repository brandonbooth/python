#script that will retrieve list of lat,lng coordinates from give list of places - helpful for looking up geo location for large number of entries
#uses opencage -->  https://opencagedata.com/tutorials/geocode-in-python
#pip3 install opencage --> to install packages

from opencage.geocoder import OpenCageGeocode
from pprint import pprint

key = 'your_key'

place_names = ['Mt Hood Meadows',
            'Timberline Lodge, Oregon',
            'Skibowl']
counter = 0
for place in place_names:
    counter = counter + 1
    geocoder = OpenCageGeocode(key)
    query = place  
    results = geocoder.geocode(query)	

    lat = results[0]['geometry']['lat']
    lng = results[0]['geometry']['lng']

    # print (results)
    print (counter ,';', place,';',lat,';', lng)
