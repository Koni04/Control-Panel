<?php
$servername = "localhost";
$username = "id21799717_subsystemdb";
$password = "TheEncounter04&";
$datebaseName = "id21799717_subsystemdb";

$connect = mysqli_connect($servername, $username, $password, $datebaseName);

if(!$connect) {
    die("Connection Failed " + mysqli_connect_error());
}
// echo "Connected Successfully";