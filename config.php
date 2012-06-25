<?php
//TODO: Move config to somewhere outside the web root
$databases = array(
    array('localhost','root','','fmk'),
	array('nas.emilnygaard.com','fmk','fmk','fmk'),
    array('mydb13.surftown.dk','rasmu11_fmk','fmkode','rasmu11_fmk')
);
$database = $databases[1];

mysql_connect($database[0],$database[1],$database[2]);
mysql_select_db($database[3]);

?>