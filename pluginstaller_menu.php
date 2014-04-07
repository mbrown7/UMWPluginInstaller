<?php include 'dbconnect.php'; ?>

<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<?php
  if($_POST['install']) {
	// CODE GOES HERE TO FETCH AND INSTALL
	//$plugins_dir = plugins_url();
	//$theme_dir = get_theme_root_uri();
	//$site_dir = site_url();	

	$package_name = $_POST['package'];

	$query = "SELECT pl.name as name, pl.address as url FROM packages as pk INNER JOIN packages_plugins as pp ON pp.package_id = pk.id INNER JOIN plugins as pl ON pl.id = pp.plugin_id WHERE pk.name = '";
	$query .= $package_name ."'";
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));

	while($row = mysqli_fetch_array($result)){
		$plugin_name = $row['name'];
		$plugin_url = $row['url'];
		include_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';  
		$downloader = new Plugin_Upgrader();
		$downloader->install($plugin_url);
            
       	/*if ($downloader->plugin_info()){
			echo '<a href="' . wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $downloader->plugin_info(), 'activate-plugin_' . $plugin_name . 'php') . '" title="' . esc_attr__('Activate this plugin') . '" target="_parent">' . __('Activate Plugin') . '</a>';
	 	}*/
	}
	
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
		if (post_id == 0){ echo 'Failed to add post.'; }
	}
	
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
			'post_parent'  = 0;
			'post_author' => $user_ID,
			'post_type' => 'page',
			'post_category' => array(0)
		);
		$page_id = wp_insert_post($new_post);
		if (page_id == 0){ echo 'Failed to add page.'; }
	}
	
	//ADD THEME, CATEGORIES, TAGS HERE!
	
	if ($downloader->plugin_info()){
		echo 'Installation successfully complete. <a href="plugins.php" target="_parent">Go to Plugins page to activate!</a>';
	}
} else { ?>

	<table><tr>
	<form action="pluginstaller_search.php" method="post">
	<td>
	<input type="text" name="search_term" placeholder="Search by course or professor" size="30" /></td>
	<td><?php submit_button('Search', 'primary', 'search') ?></td>
	</form></tr>
	<tr><td>-or-</td></tr>
	<tr>
	<form id="install" action="" method="post"> 
	<td>
		<select name="package">
			<option selected disabled>Choose a package</option>
			<?php
				$sql = "SELECT name FROM `packages` WHERE 1 GROUP BY `name`";
				$result = mysqli_query($db, $sql);
				while($row = mysqli_fetch_assoc($result)){echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';}
			?>
		</select></td>
		<td><?php submit_button('Install', 'primary', 'install') ?></td>
	</form></tr></table>
<?php } ?>
</div>
