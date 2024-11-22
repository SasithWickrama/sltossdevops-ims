<?php
	$page = $_SERVER['PHP_SELF'];
	$sec = "10";
	header("Refresh: $sec; url=$page");

	$f = fopen("imslog.txt", "r");
	$a = array();
	$i=0;
	// Read line by line until end of file
	while(!feof($f)) { 
	    //echo fgets($f) . "<br />";
		$a[$i] =fgets($f);
		$i++;
	}
	fclose($f);
	
	for ($j=sizeof($a)-50;$j<sizeof($a);$j++)
	{
	echo $a[$j]. "<br />";
	}

	

	?>