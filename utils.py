# utils.py
import MySQLdb

DATABASE='packages'
DB_USER = 'assist'
DB_PASSWORD = 'assist'
HOST = 'localhost'

def db_connect():
	return MySQLdb.connect(HOST, DB_USER, DB_PASSWORD, DATABASE)
