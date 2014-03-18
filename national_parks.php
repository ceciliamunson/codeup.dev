<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;

}


if (!empty($_GET)) {
    $sortColumn = $_GET['sort_column'];
    $sortOrder = $_GET['sort_order'];
    // Retrieve a result set using SELECT
    $result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortColumn $sortOrder");  
}


if (!empty($_POST)) {
    try {
        if (empty($_POST['name'])) {
            throw new Exception("Field can't be empty!  ");
        } 
        elseif (empty($_POST['location'])) {
            throw new Exception("Field can't be empty!  ");
        }
        elseif (empty($_POST['description'])) {
            throw new Exception("Field can't be empty!  ");
        }
        elseif (empty($_POST['date_est'])) {
            throw new Exception("Field can't be empty!  ");
        }
        elseif (empty($_POST['area_acres'])) {
            throw new Exception("Field can't be empty!  ");
        }
        else {
            // Create the prepared statement
            $stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, description, date_est, area_acres) VALUES (?, ?, ?, ?, ?)");
            
            // bind parameters
            $stmt->bind_param("sssss", $_POST['name'], $_POST['location'], $_POST['description'], $_POST['date_est'], $_POST['area_acres']);
            
            // execute query, return result
            $stmt->execute();
        }
    } 
    catch (Exception $e) {
    
        $errorMessage = $e->getMessage();
    }
}

$result = $mysqli->query("SELECT * FROM national_parks");              

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Top 10 National Parks</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Top 10 National Parks</h1>
<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Add park
</button>
<?php if (!empty($errorMessage)) { ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
<?php } ?>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add new park/h4>
      </div>
      <div class="modal-body">
        <form method="POST" role="form" action="national_parks.php">
          <div class="form-group">
            <label for="name"></label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Park name">
          </div>
          <div class="form-group">
            <label for="location"></label>
            <input type="text" name="location" class="form-control" id="loacation" placeholder="Location">
          </div>
          <div class="form-group">
            <label for="description"></label>
            <textarea type="text" name="description" class="form-control" id="description" placeholder="Description"></textarea>
          </div>
          <div class="form-group">
            <label for="date_est"></label>
            <input type="text" name="date_est" class="form-control" id="date_est" placeholder="Date Established">
          </div>
          <div class="form-group">
            <label for="area_acres"></label>
            <input type="text" name="area_acres" class="form-control" id="area_acres" placeholder="Area in acres">
          </div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>

    <table>
        <tr>
            <th><a href="?sort_column=name&amp;sort_order=asc">Name</a>&nbsp<a href="?sort_column=name&amp;sort_order=desc"><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span></a></th>
            <th><a href="?sort_column=location&amp;sort_order=asc">Location</a>&nbsp<a href="?sort_column=location&amp;sort_order=desc"><span class="glyphicon glyphicon-sort-by-alphabet-alt"></span></a></th>
            <th>Description</th>
            <th><a href="?sort_column=date_est&amp;sort_order=asc">Date est</a>&nbsp<a href="?sort_column=date_est&amp;sort_order=desc"><span class="glyphicon glyphicon-sort-by-order-alt"></span></a></th>
            <th>Area in acres</th>
        </tr>
    <?php 
        
        while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $row['location'];?></td>
            <td><?php echo $row['description'];?></td>
            <td><?php echo $row['date_est'];?></td>
            <td><?php echo $row['area_acres'];?></td>
        </tr>
    <?php } ?>


    </table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
<html>

