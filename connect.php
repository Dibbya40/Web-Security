<?php
	function connect()
	{
		// Connects to the Database 
		mysql_connect("127.0.0.1", "cs6324spring22", "3Q9Y5Asg8as8p5m4", false, 3306) or die(mysql_error());
		mysql_select_db("cs6324spring22") or die(mysql_error());
	}
?>
