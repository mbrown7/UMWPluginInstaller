from flask import Flask, render_template, request, redirect, url_for, session
import MySQLdb, utils

app = Flask(__name__)
app.secret_key = 'Zq4oA4Dqq3'

@app.route('/')
def mainIndex():
	return redirect(url_for('createPkg'))

@app.route('/pkgCreate', methods=['GET', 'POST'])
def createPkg():
	db = utils.db_connect()
	cur = db.cursor(cursorclass=MySQLdb.cursors.DictCursor)

	if request.method =='POST':
		packageName = MySQLdb.escape_string(request.form['package_name'])
		professor = MySQLdb.escape_string(request.form['professor'])
		course = MySQLdb.escape_string(request.form['course'])
		semester = MySQLdb.escape_string(request.form['semester'])
		
		query = "INSERT INTO packages VALUES('%s', '%s', '%s', '%s')" % (packageName, professor, course, semester)
		cur.execute(query)
		db.commit()
		if cur.fetchone():
			return redirect(url_for('addPlugins'))
	
	return render_template('pkgCreator.html')

@app.route('/addPlugins', methods=['GET', 'POST']
def addPackages():
	db = utils.db_connect()
	cur = db.cursor(cursorclass=MySQLdb.cursors.DictCursor)

	if request.method =='POST':
	
	return render_template('addPlugins.html')

if __name__ == '__main__':
	app.debug=True
	app.run(host='0.0.0.0', port=3000)
 

