import json

host = json.load(open('config.json'))['db_host']
database = json.load(open('config.json'))['db_database']
user = json.load(open('config.json'))['db_user']
password = json.load(open('config.json'))['db_password']

print(host)
print(database)
print(user)
print(password)
