<?php

session_start();
// Connect to mysql
$mysqli = new mysqli('localhost', 'Opa', 'y9zdxd66', 'map_places') or die(mysqli_error($mysqli));

$update = false;
$id = 0;
$name = '';
$address = '';
$latitude = '';
$longitude = '';
$type = '';


// Insert query
if (isset($_POST['save'])){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $type = $_POST['type'];

    $mysqli->query("INSERT INTO markers (name, address, latitude, longitude, type) VALUES('$name', '$address', '$latitude', '$longitude', '$type')") or die($mysqli->error);
    
    $_SESSION['message'] = "Location saved to map!";
    $_SESSION['msg_type'] = "success";
    
    header("location: index.php");        
}
// Delete query
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM markers WHERE id=$id") or die($mysqli->error);
    
    $_SESSION['message'] = "Marker deleted!";
    $_SESSION['msg_type'] = "danger";
    
    header("location: index.php");
}

if (isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM markers WHERE id=$id") or die($mysqli->error());
    if (count($result)==1){
        $row = $result->fetch_array();
        $name = $row['name'];
        $address = $row['address'];
        $latitude = $row['latitude'];
        $longitude = $row['longitude'];
        $type = $row['type'];
    }
}

if (isset ($_POST['update'])){
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $type = $_POST['type'];
    
    $mysqli->query("UPDATE markers SET name='$name', address='$address', latitude='$latitude', longitude='$longitude', type='$type' WHERE id=$id") or die ($mysqli->error);
    
    $_SESSION['message'] = "Location has been updated!";
    
    header('location: index.php');
}