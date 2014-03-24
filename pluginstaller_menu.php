<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<?php
//this reads the file into a string
//read in the file that contains package information for all packages
$package = file_get_contents('http://packages.umwdomains.com/wp-content/uploads/2014/03/testfile.txt');
//alternative we can say ('./file.txt', true); to get the file from our directory if needed
?>

<table cellpadding="0" cellspacing="0"><tr>
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
		<?php
		// Programmatically fill in option tags here.
		?>
	</select></td>

	<td><?php submit_button('Install') ?></td>
</form></tr></table>
</div>
