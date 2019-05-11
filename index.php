<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Places</title>
        <link rel="stylesheet" type="text/css" href="styles/styles.css">
    </head>
    <body>
        
        <?php require_once 'process.php'; ?>
        
        <?php if (isset($_SESSION['message'])): ?>
        
        <div class="alert">
        
            <?php 
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            ?>
        
        </div>
        <?php endif; ?>
        
                <div class="form-container">
            <h2>Add a marker</h2>
            <form action="process.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="form-items">
                    <input type="text" name="name" class="form-ctrl" value="<?php echo $name; ?>" placeholder="Location name">
                </div>
                <div class="form-items">
                    <input type="text" name="address" class="form-ctrl" value="<?php echo $address; ?>" placeholder="Address">
                </div>
                <div class="form-items">
                    <input type="number" name="latitude" class="form-ctrl" step="0.000001" value="<?php echo $latitude; ?>" placeholder="Latitude">
                </div>
                <div class="form-items">
                    <input type="number" name="longitude" class="form-ctrl" step="0.000001" value="<?php echo $longitude; ?>" placeholder="Longitude">
                </div>
                <div class="form-items">
                    <input type="text" name="type" class="form-ctrl" value="<?php echo $type; ?>" placeholder="Location type (E.g. Restaurant)">
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
            $mysqli = new mysqli('localhost', 'Opa', 'y9zdxd66', 'map_places') or die(mysqli_error($mysqli));
            $result = $mysqli->query("SELECT * FROM markers") or die($mysqli->error);
        ?>
            <h2>Added markers</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Type</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th colspan="2"></th>
                    </tr>
                </thead>
                <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['name'];?></td>
                    <td><?php echo $row['address'];?></td>
                    <td><?php echo $row['type'];?></td>
                    <td><?php echo $row['latitude'];?></td>
                    <td><?php echo $row['longitude'];?></td>
                    
                    <td>
                        <a href="index.php?edit=<?php echo $row['id'];?>" class="btn">Edit</a>
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
    </body>
</html>
