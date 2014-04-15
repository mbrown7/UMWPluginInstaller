<?php include 'dbconnect.php'; ?>

<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<?php
if($_POST['install']) {
	// CODE GOES HERE TO FETCH AND INSTALL
	$plugins_dir = plugins_url();
	//$theme_dir = get_theme_root_uri();
	//$site_dir = site_url();	

	$package_name = $_POST['package'];

	//Add plugins
	$query = "SELECT pl.name as name, pl.address as url FROM packages as pk INNER JOIN packages_plugins as pp ON pp.package_id = pk.id INNER JOIN plugins as pl ON pl.id = pp.plugin_id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));

	while($row = mysqli_fetch_array($result)){
		$plugin_name = $row['name'];
		$plugin_url = $row['url'];
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		$downloader = new Plugin_Upgrader();
		$downloader->install($plugin_url);
		
		/*
		$activated = activate_plugin($plugins_dir . '/' . $plugin_name . '.php');
		if ($activated) { echo 'Error activating plugin.'; }
		*/            

       	/*if ($downloader->plugin_info()){
			echo '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $downloader->plugin_info(), 'activate-plugin_' . $plugin_name . 'php') . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>';
	 	}*/
	}
	
	//Add posts
	$query = "SELECT po.title as title, po.content as content FROM posts as po INNER JOIN packages as pk ON po.package_id = pk.id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	
	global $user_ID;
	while($row = mysqli_fetch_array($result)){
		$new_post = array(
			'post_title' => $row['title'],
			'post_content' => $row['content'],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_type' => 'post',
			'post_category' => array(0)
		);
		$post_id = wp_insert_post($new_post);
		if ($post_id == 0){ echo 'Failed to add post.'; }
	}
	
	//Add pages
	$query = "SELECT pa.title as title, pa.description as content, pa.slug as slug FROM pages as pa INNER JOIN packages as pk ON pa.package_id = pk.id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	
	while($row = mysqli_fetch_array($result)){
		$new_post = array(
			'post_title' => $row['title'],
			'post_name' => $row['slug'],
			'post_content' => $row['content'],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_parent' => 0,
			'post_author' => $user_ID,
			'post_type' => 'page',
			'post_category' => array(0)
		);
		$page_id = wp_insert_post($new_post);
		if ($page_id == 0){ echo 'Failed to add page.'; }
	}
	
	//Add categories
	$query = "SELECT c.name as name, c.description as description, c.slug as slug FROM categories as c INNER JOIN packages as pk ON c.package_id = pk.id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	
	while($row = mysqli_fetch_array($result)){
		$cat_defaults = array(
			'cat_name' => $row['name'],
			'category_description' => $row['description'],
			'category_nicename' => $row['slug'],
			'category_parent' => '',
			'taxonomy' => 'category' );
		$cat_id = wp_insert_category($cat_defaults);
		if ($cat_id == 0){ echo 'Failed to add category.'; }
	}
	
	//Add tags
	$query = "SELECT t.name as name, t.description as description, t.slug as slug FROM tags as t INNER JOIN packages as pk ON t.package_id = pk.id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	while($row = mysqli_fetch_array($result)){
		$tag_defaults = array (
			'description' => $row['description'],
			'slug' => $row['slug']
		);
		$tag_id = wp_insert_term( $row['name'], 'post_tag', $tag_defaults );
		if ($tag_id == 0) { echo 'Failed to create tag.'; }
	}
	
	//Add theme
	$query = "SELECT th.name as name, th.address as url FROM themes as th INNER JOIN packages as pk ON pk.theme_id = th.id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));
	while($row = mysqli_fetch_array($result)){
		$theme_name = $row['name'];
		$theme_url = $row['url'];
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		$downloader = new Theme_Upgrader();
		$downloader->install($theme_url);
	}
} else { ?>
	<table><tr>
	<form id="install" action="" method="post"> 
	<td>
		<select name="package">
			<option selected disabled>Choose a package</option>
			<?php
			$sql = "SELECT name, course, professor, semester FROM `packages` WHERE 1 GROUP BY `course`";
			$result = mysqli_query($db, $sql);
			while($row = mysqli_fetch_assoc($result)){echo '<option value="'.$row['name'].'">'.$row['course'].' '.$row['professor'].' '.$row['semester'].'</option>';}
			?>
		</select></td>
	<td><?php submit_button('Install', 'primary', 'install') ?></td>
	</form></tr></table>
<?php } ?>
</div>