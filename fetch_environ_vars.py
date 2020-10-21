import os

host = os.environ.get('db_host')
database = os.environ.get('db_database')
user = os.environ.get('db_user')
password = os.environ.get('db_password')

print('Start')

print(host)
print(database)
print(user)
print(password)