# utils.py
import MySQLdb

DATABASE='installe_packages'
DB_USER = 'installe_admin'
DB_PASSWORD = '20pslpurgiinng14'
HOST = 'installer.umwcsprojects.com'

def db_connect():
	return MySQLdb.connect(HOST, DB_USER, DB_PASSWORD, DATABASE)
