#!/usr/local/bin/php
<?php
require_once 'orcl_user_passwd.php';
$connection = oci_connect($username = $orcl_username,
                          $password = $orcl_password,
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
if(!$connection) {
	echo "oci_connect failure";
}
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

$statement = oci_parse($connection, 'SELECT * FROM tmp WHERE uname = :myusername and passwd = :mypassword');

oci_bind_by_name($statement, ':myusername', $myusername);
oci_bind_by_name($statement, ':mypassword', $mypassword);

oci_execute($statement);

if (($row = oci_fetch_object($statement))) {
	//var_dump($row);
	session_register("myusername"); //login successful
	session_register("mypassword");
	header("location:home.php");
 }
//
// VERY important to close Oracle Database Connections and free statements!
//
oci_free_statement($statement);
oci_close($connection);
?>
