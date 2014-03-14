<?php
// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}
else {

    echo $mysqli->host_info . "\n";
}

$sortColumn = $_GET['sort_column'];
$sortOrder = $_GET['sort_order'];
            
// Retrieve a result set using SELECT
$result = $mysqli->query("SELECT * FROM national_parks ORDER BY $sortColumn $sortOrder");


?>

<!DOCTYPE html>
<html>
<head>
    <title>Top 10 National Parks</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<h1>Top 10 National Parks</h1>

    <!-- <p>
        <a href="?sort_column=foo&amp;sort_order=desc">Click to sort desc</a>
    </p> -->
    <?php if (!empty($_GET)) : ?>
        We are sorting <?= $_GET['sort_column'] . ' ' . $_GET['sort_order']; ?>
    <?php endif; ?>
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

</body>
<html>

