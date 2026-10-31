<?php

$severname="localhost";
$username="root";
$password="";
$database="library_management_system";

$conn = new mysqli($severname,$username,$password,$database);

if($conn->connect_error){
    die("Fonnection Failed" .$conn->connect_error);
}

//echo "Connected Successfully";

?>