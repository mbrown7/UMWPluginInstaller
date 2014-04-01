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
	#Get package data
		packageName = MySQLdb.escape_string(request.form['package_name'])
		professor = MySQLdb.escape_string(request.form['professor'])
		course = MySQLdb.escape_string(request.form['course'])
		semester = MySQLdb.escape_string(request.form['semester'])
	#Get theme data
		themeName = MySQLdb.escape_string(request.form['theme_name'])
		themeAddress = MySQLdb.escape_string(request.form['theme_url'])
	#Only do if the theme does not already exist:
		query = "INSERT INTO themes (name, address) VALUES ('%s','%s')" % (themeName, themeAddress)
		cur.execute(query)
		db.commit()
	#Then, get the theme ID number (we do this whether we just created the theme now or not)
		query = "SELECT id FROM themes WHERE name = '%s'" % (themeName)
		cur.execute(query)
		tida = cur.fetchall()
		tid = tida[0]['id']
	#Add package info to DB
		query = "INSERT INTO packages (name, professor, course, semester, theme_id) VALUES ('%s', '%s', '%s', '%s', %d)" % (packageName, professor, course, semester, tid)
		cur.execute(query)
		db.commit()
	#Get package ID
		query = "SELECT id FROM packages WHERE name = '%s'" % (packageName)
		cur.execute(query)
		pida = cur.fetchall()
		pid = pida[0]['id']
	#Get the number of plugins there will be
		numberOfPlugins = MySQLdb.escape_string(request.form['num_plug'])
		numberOfPluginsInt = int(numberOfPlugins)
		for x in range(1, numberOfPluginsInt+1)
			string1 = 'plugin_name' + str(x)
			string2 = 'plugin_url' + str(x)
			#Get the plugin data
			pluginName = MySQLdb.escape_string(request.form[string1])
			pluginAddress = MySQLdb.escape_string(request.form[string2])
			#Only do if the plugin does not already exist:
			query = "INSERT INTO plugins (name, address) SELECT name, address FROM (SELECT '%s' AS name,'%s' AS address) t WHERE NOT EXISTS (SELECT * FROM plugins WHERE name = '%s')" % (pluginName, pluginAddress, pluginName)
			cur.execute(query)
			db.commit()
			#Then, get the plugin ID number (we do this whether we just created the plugin now or not)
			query = "SELECT id FROM plugins WHERE name = '%s'" % (pluginName)
			cur.execute(query)
			plida = cur.fetchall()
			plid = plida[0]['id']
			#Put this plugin and the package into the juncture table
			query = "INSERT INTO packages_plugins (package_id, plugin_id) VALUES (%d, %d)" % (pid, plid)
			cur.execute(query)
			db.commit()
	#Get the number of posts there will be
		numberOfPosts = MySQLdb.escape_string(request.form['num_posts'])
		numberOfPostsInt = int(numberOfPosts)
		for x in range(1, numberOfPostsInt+1)
			string1 = 'post_title' + str(x)
			string2 = 'post_content' + str(x)
			#Get the post data
			postTitle = MySQLdb.escape_string(request.form[string1])
			postContent = MySQLdb.escape_string(request.form[string2])
			#Put this post into the DB
			query = "INSERT INTO posts (title, content, package_id) VALUES ('%s','%s',%d)" % (postTitle, postContent, pid)
			cur.execute(query)
			db.commit()
	#Get the number of pages there will be
		numberOfPages = MySQLdb.escape_string(request.form['num_pages'])
		numberOfPagesInt = int(numberOfPages)
		for x in range(1, numberOfPagesInt+1)
			string1 = 'page_name' + str(x)
			string2 = 'page_desc' + str(x)
			string3 = 'page_slug' + str(x)
			#Get page information
			pageTitle = MySQLdb.escape_string(request.form[string1])
			pageDesc = MySQLdb.escape_string(request.form[string2])
			pageSlug = MySQLdb.escape_string(request.form[string3])
			#Put this page into the DB
			query = "INSERT INTO pages (title, description, package_id) VALUES ('%s','%s','%s',%d)" % (pageTitle, pageDesc, pageSlug, pid)
			cur.execute(query)
			db.commit()
			
			#Categories and tags don't necessarily work correctly yet
			#This is because I dunno if they apply to the whole blog or just pages or just posts or whatever
			#So they aren't synced the right way
			
	#Get number of categories
		numberOfCategories = MySQLdb.escape_string(request.form['num_cats'])
		numberOfCategoriesInt = int(numberOfCategories)
		for x in range(1, numberOfCategoriesInt+1)
			string1 = 'category_name' + str(x)
			string2 = 'category_desc' + str(x)
			string3 = 'category_slug' + str(x)
			#Get category information
			catName = MySQLdb.escape_string(request.form[string1])
			catDesc = MySQLdb.escape_string(request.form[string2])
			catSlug = MySQLdb.escape_string(request.form[string3])
			#Put this category into the DB
			query = "INSERT INTO categories (name, description, slug, package_id) VALUES ('%s','%s','%s',%d)" % (catName, catDesc, catSlug, pid)
			cur.execute(query)
			db.commit()
	#Get number of tags
		numberOfTags = MySQLdb.escape_string(request.form['num_tags'])
		numberOfTagsInt = int(numberOfTags)
		for x in range(1, numberOfTagsInt+1)
			string1 = 'tag_name' + str(x)
			string2 = 'tag_slug' + str(x)
			#Get tag information
			tagName = MySQLdb.escape_string(request.form[string1])
			tagSlug = MySQLdb.escape_string(request.form[string2])
			#Put this tag into the DB
			query = "INSERT INTO tags (name, slug, package_id) VALUES ('%s','%s',%d)" % (tagName, tagSlug, pid)

	return render_template('pkgCreator.html')

if __name__ == '__main__':
	app.debug=True
	app.run(host='0.0.0.0', port=3000)
