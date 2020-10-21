# import os

# host = os.environ.get('db_host')
# database = os.environ.get('db_database')
# user = os.environ.get('db_user')
# password = os.environ.get('db_password')

# print('Start')

# print(host)
# print(database)
# print(user)
# print(password)


# fetch credentials
import json
host = json.load(open('config.json'))['db_host']
database = json.load(open('config.json'))['db_database']
user = json.load(open('config.json'))['db_user']
password = json.load(open('config.json'))['db_password']


print(host)
print(database)
print(user)
print(password)

