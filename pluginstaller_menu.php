<div class="wrap">
<h2>PlugInstaller</h2>
<h3>PlugInstaller Menu</h3>

<form action="pluginstaller_search.php" method="post">
<input type="text" name="search_term" value="Search by course or professor" />
<?php submit_button('Search') ?>
</form>

<form action="pluginstaller_download.php" method="post">
	<select name="package">
		<?php
		// Programmatically fill in option tags here.
		?>
	</select>
	<?php submit_button('Install') ?>
</form>

</div>
