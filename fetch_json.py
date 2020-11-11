import json

path = '/Users/brandonbooth/projects/python/'
file_name = 'config.json'

host = json.load(open(path+file_name))['db_host']
database = json.load(open(path+file_name))['db_database']
user = json.load(open(path+file_name))['db_user']
password = json.load(open(path+file_name))['db_password']
API_KEY = json.load(open(path+file_name))['API_KEY_google_maps']
API_Token = json.load(open(path+file_name))['API_Token_google_maps']

print(json.load(open(path+file_name)))
print(host)
print(database)
print(user)
print(password)
print(API_KEY)
print(API_Token)
