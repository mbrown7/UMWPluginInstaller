# utils.py
import MySQLdb

DATABASE='packages'
DB_USER = 'dtlt'
DB_PASSWORD = 'package'
HOST = 'localhost'

def db_connect():
	return MySQLdb.connect(HOST, DB_USER, DB_PASSWORD, DATABASE)
