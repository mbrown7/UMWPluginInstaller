<?php include 'dbconnect.php'; ?>

<?php

mysqli_autocommit($db, false);
$flag = true;

# get package data
$packageName = mysqli_real_escape_string($db, $_POST['package_name']);
$professor = mysqli_real_escape_string($db, $_POST['professor']);
$course = mysqli_real_escape_string($db, $_POST['course']);
$semester = mysqli_real_escape_string($db, $_POST['semester']);

# get theme data
$themeName = mysqli_real_escape_string($db, $_POST['theme_name']);
$themeAddress = mysqli_real_escape_string($db, $_POST['theme_url']);

# only do if the theme does not already exist:
$query = "INSERT INTO themes (name, address) SELECT name, address FROM (SELECT '$themeName' AS name, '$themeAddress' AS address) t WHERE NOT EXISTS (SELECT * FROM themes WHERE name = '$themeName')";
$result = mysqli_query($db, $query);
if(!$result){
$flag = false;
echo "Error with theme";
}

# then, get the theme ID number (we do this whether we just created the theme now or not)
$query = "SELECT id FROM themes WHERE name = '$themeName'";
$result = mysqli_query($db, $query);
if(!$result){
$flag = false;
echo "Error with theme";
}
$tida = mysqli_fetch_array($result);
$tid = $tida['id'];

# add package info to DB
$query = "INSERT INTO packages (name, professor, course, semester, theme_id) VALUES ('$packageName', '$professor', '$course', '$semester', $tid)";
$result = mysqli_query($db, $query);
if(!$result){
$flag = false;
echo "Error with package description";
}

# get package ID
$query = "SELECT id FROM packages WHERE name = '$packageName'";
$result = mysqli_query($db, $query);
if(!$result){
$flag = false;
echo "Error with package description";
}
$pida = mysqli_fetch_array($result);
$pid = $pida['id'];

# get the number of plugins there will be
$numberOfPlugins = mysqli_real_escape_string($db, $_POST['num_plug']);
$numberOfPluginsInt = $numberOfPlugins + 1; #type casting
for ($x = 1; $x < $numberOfPluginsInt; $x++) { # might cause issues <=
	$string1 = "plugin_name" . "$x";
	$string2 = "plugin_url" . "$x";
	
	# get the plugin data
	$pluginName = mysqli_real_escape_string($db, $_POST[$string1]);
	$pluginAddress = mysqli_real_escape_string($db, $_POST[$string2]);

	# only do if the plugin doesn't exist already
	$query = "INSERT INTO plugins (name, address) SELECT name, address FROM (SELECT '$pluginName' AS name,'$pluginAddress' AS address) t WHERE NOT EXISTS (SELECT * FROM plugins WHERE name = '$pluginName')";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with plugin ".$x;
        }
	
	# then, get the plugin ID number (we do this whether we just created the plugin now or not)
	$query = "SELECT id FROM plugins WHERE name = '$pluginName'";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with plugin ".$x;
        }
	$plida = mysqli_fetch_array($result);
	$plid = $plida['id'];
	
	# put this plugin and the package into the juncture table
	$query = "INSERT INTO packages_plugins (package_id, plugin_id) VALUES ($pid, $plid)";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with plugin ".$x;
        }
}

# get the number of posts there will be
$numberOfPosts = mysqli_real_escape_string($db, $_POST['num_posts']);
$numberOfPostsInt = $numberOfPosts + 1;
for ($x = 1; $x < $numberOfPostsInt; $x++) {
	$string1 = "post_title" . "$x";
	$string2 = "post_content" . "$x";

	# get the post data
	$postTitle = mysqli_real_escape_string($db, $_POST[$string1]);
	$postContent = mysqli_real_escape_string($db, $_POST[$string2]);

	# put the post into the DB
	$query = "INSERT INTO posts (title, content, package_id) VALUES ('$postTitle','$postContent', $pid)";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with post ".$x;
        }
}

# get the number of pages there will be
$numberOfPages = mysqli_real_escape_string($db, $_POST['num_pages']);
$numberOfPagesInt = $numberOfPages + 1;
for ($x = 1; $x < $numberOfPagesInt; $x++) {
	$string1 = "page_name" . "$x";
	$string2 = "page_desc" . "$x";
	$string3 = "page_slug" . "$x";

	# get page information
	$pageTitle = mysqli_real_escape_string($db, $_POST[$string1]);
	$pageDesc = mysqli_real_escape_string($db, $_POST[$string2]);
	$pageSlug = mysqli_real_escape_string($db, $_POST[$string3]);

	# put this page into the DB
	$query = "INSERT INTO pages (title, description, slug, package_id) VALUES ('$pageTitle','$pageDesc','$pageSlug', $pid)";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with page ".$x;
        }
}

#Categories and tags don't necessarily work correctly yet
#This is because I dunno if they apply to the whole blog or just pages or just posts or whatever
#So they aren't synced the right way

# get the number of categories
$numberOfCategories = mysqli_real_escape_string($db, $_POST['num_cats']);
$numberOfCategoriesInt = $numberOfCategories + 1;
for ($x = 1; $x < $numberOfCategoriesInt; $x++) {
	$string1 = "category_name" . "$x";
	$string2 = "category_desc" . "$x";
	$string3 = "category_slug" . "$x";

	# get category information
	$catName = mysqli_real_escape_string($db, $_POST[$string1]);
	$catDesc = mysqli_real_escape_string($db, $_POST[$string2]);
	$catSlug = mysqli_real_escape_string($db, $_POST[$string3]);
	
	#Put this category into the DB
	$query = "INSERT INTO categories (name, description, slug, package_id) VALUES ('$catName','$catDesc','$catSlug', $pid)"; 
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with category ".$x;
        }
}

#Get number of tags
$numberOfTags = mysqli_real_escape_string($db, $_POST['num_tags']);
$numberOfTagsInt = $numberOfTags + 1;
for ($x = 1; $x < $numberOfTagsInt; $x++) {
	$string1 = "tag_name" . "$x";
	$string2 = "tag_slug" . "$x";
        $string3 = "tag_desc" . "$x";
	
	#Get tag information
	$tagName = mysqli_real_escape_string($db, $_POST[$string1]);
	$tagSlug = mysqli_real_escape_string($db, $_POST[$string2]);
        $tagDesc = mysqli_real_escape_string($db, $_POST[$string3]);
      
	#Put this tag into the DB
	$query = "INSERT INTO tags (name, slug, description, package_id) VALUES ('$tagName','$tagSlug', '$tagDesc', $pid)";
	$result = mysqli_query($db, $query);
        if(!$result){
        $flag = false;
        echo "Error with tag ".$x;
        }
}

if($flag){
        mysqli_commit($db);
        echo "Package added";
}else{
        mysqli_rollback($db);
        echo "Package not created";
}

mysqli_close($db);

?>
