<?php include 'dbconnect.php'; ?>

<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<?php
  if($_POST['install']) {
	// CODE GOES HERE TO FETCH AND INSTALL
	$plugins_dir = plugins_url();
	$theme_dir = get_theme_root_uri();
	$site_dir = site_url();	
	echo $plugins_dir . "</br>";
	echo $theme_dir . "</br>";
	echo $site_dir . "</br>";	

	$package_name = $_POST['package'];

	$query = "SELECT pl.name as name FROM packages as pk INNER JOIN packages_plugins as pp ON pp.package_id = pk.id INNER JOIN plugins as pl ON pl.id = pp.plugin_id WHERE pk.name";
	$query .= $package_name; //change this to pl.url (or whatever) and change below to actually download from this url.
	
	$result = mysqli_query($db, $query) or die(mysqli_error($db));

	while($row = mysqli_fetch_array($result)){
		$plugin_name = $row['name'];

		echo "<tr>
		<th>$plugin_name</th>
		</tr>";
		echo "</table>";
	}	 
 	echo "HELLOOOO";
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
		<?php // SQL QUERY TO RETRIEVE EVERY TYPE OF CUSTOMER
			$sql = "SELECT name FROM `package` GROUP BY `name`";
			$result = mysql_query($sql);
			while($row = mysql_fetch_assoc($result)){echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';}
        ?>
	</select></td>
	<td><?php submit_button('Install', 'primary', 'install') ?></td>
</form></tr></table>
  <?php } 
?>
</div>