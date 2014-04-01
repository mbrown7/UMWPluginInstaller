<?php
	$db = mysqli_connect('71.63.30.112', 'dtlt', 'package', 'packages', '3306')
		or die(mysqli_connect_error($db));
		
	$db_selected = mysqli_select_db($db, 'packages');

	if (!$db_selected) {
		die ("Can't Connect :" .mysql_error());
	}
?>