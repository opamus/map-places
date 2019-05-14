<?php

require("phpsqlajax_dbinfo.php");

session_start();
// Connect to mysql
$mysqli = new mysqli('localhost', $username, $password, $database) or die(mysqli_error($mysqli));

$update = false;
$id = 0;
$address = '';
$latitude = '';
$longitude = '';
$name = '';
$type = '';
$hours = '';

// Insert query
if (isset($_POST['save'])){
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $type = $_POST['type'];
    $hours = $_POST['hours'];

    $mysqli->query("INSERT INTO markers (name, address, latitude, longitude, type, hours) VALUES('$name', '$address', '$latitude', '$longitude', '$type', '$hours')") or die($mysqli->error);
    $_SESSION['message'] = "Location saved to map!";
    $_SESSION['msg_type'] = "success";
    header("location: map.php");      
}
// Delete query
if (isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM markers WHERE id=$id") or die($mysqli->error);
    
    $_SESSION['message'] = "Marker deleted!";
    $_SESSION['msg_type'] = "danger";
    header("location: map.php");

}
// Edit query
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
        $hours = $row['hours'];
    }
}
// Update query
if (isset ($_POST['update'])){
    
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $type = $_POST['type'];
    $hours = $_POST['hours'];
    
    $mysqli->query("UPDATE markers SET name='$name', address='$address', latitude='$latitude', longitude='$longitude', type='$type', hours='$hours' WHERE id=$id") or die ($mysqli->error);
    
    $_SESSION['message'] = "Location has been updated!";
    header('location: map.php');
}

$dom = new DOMDocument;
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);
$filename = "markers.xml";

// Select all the rows in the markers table
$result = $mysqli->query("SELECT * FROM markers") or die($mysqli->error());

while ($row = @mysqli_fetch_assoc($result)){
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("latitude", $row['latitude']);
  $newnode->setAttribute("longitude", $row['longitude']);
  $newnode->setAttribute("type", $row['type']);
  $newnode->setAttribute("hours", $row['hours']);
  
}

$dom->formatOutput = true;
$finalstring = $dom->saveXML();
$dom->save($filename); // save as file
$dom->save('xml/'.$filename);


// Search query
$output = '';
if(isset($_POST['search'])) {
    $searchq = $_POST['search'];
    
    
    $result = $mysqli->query("SELECT * FROM markers WHERE type LIKE '%$searchq%' OR name LIKE'%$searchq%'") or die($mysqli->error());
    $count = $result->num_rows;
    if ($count == 0){
        $output = '<div class="output"> There was no search results! </div>';
    } else if($searchq == "") {
        $output = "";
    } else {
        while($row = @mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $address = $row['address'];
            $type = $row['type'];
            $hours = $row['hours'];
            
            $output .= '<div class="output"> '.$name.', '.$address.', '.$type.', '.$hours.' </div>';
        }
    }
    
    $name = "";
    $address = "";
    $type = "";
    $hours = "";
}