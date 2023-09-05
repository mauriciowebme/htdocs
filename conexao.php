<?php
$host = "localhost";
$username = "root";
$password = "erickcls";
$db = "judiciario";
// Create connection
$mysqli = new mysqli($host, $username, $password, $db);
// Check connection
if($mysqli->connect_errno)
    echo "Falha na conexão: (".$mysqli->connect_errno.") ".$mysqli->connect_error;
?>