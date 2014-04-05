<?php
	$db = mysqli_connect('installer.umwcsprojects.com', 'installe_admin', '20pslpurgiinng14', 'installe_packages')
		or die(mysqli_connect_error($db));
		
	$db_selected = mysqli_select_db($db, 'installe_packages');

	if (!$db_selected) {
		die ("Can't Connect :" .mysql_error());
	}
?>
