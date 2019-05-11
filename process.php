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
    
    $mysqli->query("UPDATE markers SET name='$name', address='$address', latitude='$latitude', longitude='$longitude', type='$type' WHERE id=$id") or die ($mysqli->error);
    
    $_SESSION['message'] = "Location has been updated!";
    
    header('location: index.php');
}

/* $filename = "markers.xml";

$result = $mysqli->query("SELECT * FROM markers WHERE 1") or die($mysqli->error());

//Create new document 
$dom = new DOMDocument;
$dom->preserveWhiteSpace = FALSE;

//add table in document 
$table = $dom->appendChild($dom->createElement('table'));

//add row in document 
foreach($result as $row) {
    $data = $dom->createElement('markers');
    $table->appendChild($data);

    //add column in document 
    foreach($row as $name => $value) {

        $col = $dom->createElement('marker', $value);
        $data->appendChild($col);
        $colattribute = $dom->createAttribute('name');
        // Value for the created attribute
        $colattribute->value = $name;
        $col->appendChild($colattribute);           
    }
}

$dom->formatOutput = true; // set the formatOutput attribute of domDocument to true 
// save XML as string or file 
$finalstring = $dom->saveXML(); // put string in finalstring
$dom->save($filename); // save as file
$dom->save('xml/'.$filename);

$name = ''; */


// Set the active MySQL database
$db_selected = mysql_select_db($database, $mysqli) or die($mysqli->error());

// Select all the rows in the markers table
$query = "SELECT * FROM markers";
$result = mysqli_query($mysqli, $query) or die($mysqli->error());

header("Content-type: text/xml");

