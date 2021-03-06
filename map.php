<!DOCTYPE html>
<html>
  <head>
      <meta charset="UTF-8">
      <link rel="stylesheet" type="text/css" href="styles/styles.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  </head>
  <body>
      <div class="btn-markers">
        <a href="#" id="btn"> Markers </a>
      </div>
      
      <?php require_once 'process.php'; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
        
        <div class="alert-container">
            <div class="alert">

                <?php 
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);
                ?>

            </div>
        </div>
        <?php endif; ?>
      
      <div id="modal">
          <div class="modal-content">
            <span id="close">&times;</span>
        
                <div class="form-container">
            <h2>Add a marker</h2>
            <p>Necessary fields marked with *</p>
            <form action="process.php" method="POST" onsubmit="return validateForm()" name="inputform">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-items">
                    <input id="name" type="text" name="name" class="form-ctrl" value="<?php echo $name; ?>" placeholder="*Location name">
                </div>
                <div class="form-items">
                    <input id="address" type="text" name="address" class="form-ctrl" value="<?php echo $address; ?>" placeholder="*Address">
                </div>
                <div class="form-items">
                    <input id="latitude" type="number" name="latitude" class="form-ctrl" step="0.000001" value="<?php echo $latitude; ?>" placeholder="*Latitude">
                </div>
                <div class="form-items">
                    <input id="longitude" type="number" name="longitude" class="form-ctrl" step="0.000001" value="<?php echo $longitude; ?>" placeholder="*Longitude">
                </div>
                <div class="form-items">
                    <input id="keywords" type="text" name="type" class="form-ctrl" value="<?php echo $type; ?>" placeholder="*Location keywords (Separate with comma)">
                </div>
                <div class="form-items">
                    <input type="text" name="hours" class="form-ctrl" value="<?php echo $hours; ?>" placeholder="Opening hours (E.g. 6.00 - 22.00)">
                </div>
                <div class="form-items">
                    
                    <?php if($update == true):?>
                        <button type="submit" class="btn-update" name="update">Update</button>
                    <?php else: ?>
                    <button type="submit" class="btn-save" name="save">Save</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        
        <div class="center">
        <?php 
            require("phpsqlajax_dbinfo.php");
            $mysqli = new mysqli('localhost', $username, $password, $database) or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM markers") or die($mysqli->error);
        ?>
            <h2>Search for markers</h2>
            
            <div class="search">
                <form action="map.php" method="post">
                    <input type="text" name="search" autocomplete="off" placeholder="Search for names and keywords">
                    <button type="submit" id="submit">Search</button>
                </form>
            </div>
            
            <?php 
                print("$output");
            ?>
            <h2>All markers</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th class="hidemobile">Keywords</th>
                        <th class="hidelaptop">Latitude</th>
                        <th class="hidelaptop">Longitude</th>
                        <th class="hidemobile">Open hours</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr id="mobile-ctrl">
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['address'];?></td>
                    <td class="hidemobile"><?php echo $row['type'];?></td>
                    <td class="hidelaptop"><?php echo $row['latitude'];?></td>
                    <td class="hidelaptop"><?php echo $row['longitude'];?></td>
                    <td class="hidemobile"><?php echo $row['hours'];?></td>
                    
                    <td>
                        <a href="map.php?edit=<?php echo $row['id'];?>" class="btn">Edit</a>
                        <a href="process.php?delete=<?php echo $row['id'];?>" class="btn-delete">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
        
        <?php
            
            function pre_r( $array ) {
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            
        ?>
          </div>
      </div>
            
      
      <div class="open-places">
          <button id="open">Hide closed locations</button>
      </div>
      
     <div id="map-container">
        <div id="map"></div>
    </div>
      
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
    </script>

    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript" src="form.js"></script> 
  </body>
</html>