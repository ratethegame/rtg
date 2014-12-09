<?php
function get_list()
{
  	$dbhost = "db4free.net";
	$dbname = "rtgbase"; 
	$dbuser = "adminrtg";
	$dbpass = "ratethegame";

	$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
	
	$result = mysqli_query($con, "SELECT * FROM Platforma");
	
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) {
		$return_arr[] = $row['nazwa'];
	}
	return $return_arr;
}

$value = get_list();

//return JSON array
exit(json_encode($value));
?>