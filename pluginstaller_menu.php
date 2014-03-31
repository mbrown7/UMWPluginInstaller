<?php
	$db = mysqli_connect('localhost', 'dtlt', 'dtlt', 'umwpluginstaller')
		or die(mysqli_error($db));
		
	$db_selected = mysql_select_db ('packages', $db);

	if (!$db_selected) {
		die ("Can't Connect :" .mysql_error());
	}
?>

<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<table><tr>
<form action="pluginstaller_search.php" method="post">
<td>
<input type="text" name="search_term" placeholder="Search by course or professor" size="30" /></td>
<td><?php submit_button('Search') ?></td>
</form></tr>
<tr><td>-or-</td></tr>
<tr>
<form action="pluginstaller_download.php" method="post">
<td>
	<select name="package">
		<option selected disabled>Choose a package</option>
		<?php // SQL QUERY TO RETRIEVE EVERY TYPE OF CUSTOMER
			$sql = "SELECT name FROM `package` GROUP BY `name`";
			$result = mysql_query($sql);
			while($row = mysql_fetch_assoc($result)){echo '<option value="'.$row['name'].'">'.$row['name'].'</option>';}
        ?>
	</select></td>

	<td><?php submit_button('Install') ?></td>
</form></tr></table>
</div>
