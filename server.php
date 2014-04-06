<?php include 'dbconnect.php'; ?>

<?php

# get package data
$packageName = $_POST['package_name'];
$professor = $_POST['professor'];
$course = $_POST['course'];
$semester = $_POST['semester'];

# get theme data
$themeName = $_POST['theme_name'];
$themeAddress = $_POST['theme_url'];

# only do if the theme does not already exist:
$query = "INSERT INTO themes (name, address) SELECT name, address FROM (SELECT '$themeName' AS name, $themeAddress AS address) t WHERE NOT EXISTS (SELECT * FROM themes WHERE name = '$themeName')";
mysqli_query($db, $query) or die(mysqli_error($db);

# then, get the theme ID number (we do this whether we just created the theme now or not)
$query = "SELECT id FROM themes WHERE name = 'themeName'";
$result = mysqli_query($db, $query) or die(mysqli_error($db);
$tida = mysqli_fetch_array($result);
$tid = $tida['id'];

# add package info to DB
$query = "INSERT INTO packages (name, professor, course, semester, theme_id) VALUES ('$packageName', '$professor', '$course', '$semester', '$tid')";
mysqli_query($db, $query) or die(mysqli_error($db);

# get package ID
$query = "SELECT id FROM packages WHERE name = '$packageName'";
$result = mysqli_query($db, $query) or die(mysqli_error($db);
$pida = mysqli_fetch_array($result);
$pid = $pida['id'];

# get the number of plugins there will be
$numberOfPlugins = $_POST['num_plug'];
$numberOfPluginsInt = (int)$numberOfPlugins + 1; #type casting
for ($x = 1; $x <= $numberOfPluginsInt; $x++) { # might cause issues <=
	$string1 = 'plugin_name' + (string)$x;
	$string2 = 'plugin_url' + (string)$x;
	
	# get the plugin data
	$pluginName = $_POST[$string1];
	$pluginAddress = $_POST[$string2];

	# only do if the plugin doesn't exist already
	$query = "INSERT INTO plugins (name, address) SELECT name, address FROM (SELECT '$pluginName' AS name,'$pluginAddress' AS address) t WHERE NOT EXISTS (SELECT * FROM plugins WHERE name = '$pluginName')";
	mysqli_query($db, $query) or die(mysqli_error($db);
	
	# then, get the plugin ID number (we do this whether we just created the plugin now or not)
	$query = "SELECT id FROM plugins WHERE name = '$pluginName'";
	$result = mysqli_query($db, $query) or die(mysqli_error($db);
	$plida = mysqli_fetch_array($result);
	$plid = $plida['id'];
	
	# put this plugin and the package into the juncture table
	$query = "INSERT INTO packages_plugins (package_id, plugin_id) VALUES ($pid, $plid)";
	mysqli_query($db, $query) or die(mysqli_error($db);
}

# get the number of posts there will be
$numberOfPosts = $_POST['num_posts'];
$numberOfPostsInt = (int)numberOfPosts + 1;
for ($x = 1; $x <= $numberOfPostsInt; $x++) {
	$string1 = 'post_title' + (string)$x;
	$string2 = 'post_content' + (string)$x;

	# get the post data
	$postTitle = $_POST[$string1];
	$postContent = $_POST[$string2];

	# put the post into the DB
	$query = "INSERT INTO posts (title, content, package_id) VALUES ('$postTitle','$postContent', $pid)";
	mysqli_query($db, $query) or die(mysqli_error($db);
}

# get the number of pages there will be
$numberOfPages = $_POST['num_pages'];
$numberOfPagesInt = (int)$numberOfPages + 1;
for ($x = 1; $x <= $numberOfPagesInt; $x++) {
	$string1 = 'page_name' + (string)$x;
	$string2 = 'page_desc' + (string)$x;
	$string3 = 'page_slug' + (string)$x;

	# get page information
	$pageTitle = $_POST[$string1];
	$pageDesc = $_POST[$string2];
	$pageSlug = $_POST[$string3];

	# put this page into the DB
	$query = "INSERT INTO pages (title, description, slug, package_id) VALUES ('$pageTitle','$pageDesc','$pageSlug', $pid)";
	mysqli_query($db, $query) or die(mysqli_error($db);
}

#Categories and tags don't necessarily work correctly yet
#This is because I dunno if they apply to the whole blog or just pages or just posts or whatever
#So they aren't synced the right way

# get the number of categories
$numberOfCategories = $_POST['num_cats'];
$numberOfCategoriesInt = (int)$numberOfCategories + 1;
for ($x = 1; $x <= $numberOfCategoriesInt; $x++) {
	$string1 = 'category_name' + (string)$x;
	$string2 = 'category_desc' + (string)$x;
	$string3 = 'category_slug' + (string)$x;

	# get category information
	$catName = $_POST[$string1];
	$catDesc = $_POST[$string2];
	$catSlug = $_POST[$string3];
	
	#Put this category into the DB
	query = "INSERT INTO categories (name, description, slug, package_id) VALUES ('$catName','$catDesc','$catSlug', $pid)"; 
	mysqli_query($db, $query) or die(mysqli_error($db);
}

#Get number of tags
$numberOfTags = $_POST['num_tags'];
$numberOfTagsInt = (int)$numberOfTags + 1;
for ($x = 1; $x <= $numberOfTagsInt; $x++) {
	$string1 = 'tag_name' + (string)$x;
	$string2 = 'tag_slug' + (string)$x;
	
	#Get tag information
	$tagName = $_POST[$string1];
	$tagSlug = $_POST[$string2];
      
	#Put this tag into the DB
	$query = "INSERT INTO tags (name, slug, package_id) VALUES ('$tagName','$tagSlug', $pid)";
	mysqli_query($db, $query) or die(mysqli_error($db);
}
?>
