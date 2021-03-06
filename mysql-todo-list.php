<?php

// Get new instance of MySQLi object
$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'todo');

// Check for errors
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}

// set page limit
$limit = 10;

if (!empty($_GET['page'])) {
    $page = $_GET['page'];

} 
else {

    $page = 1;
}

if ($page > 1) {

    $offset = ($_GET['page'] * $limit) - $limit;
}
else {
    $offset = 0;
}



if (!empty($_POST)) {

    if(!empty($_POST['form_type']) && $_POST['form_type'] == 'remove_form') {

        $id = $_POST['remove'];

        // Create the prepared statement
        $stmt = $mysqli->prepare("DELETE FROM todo_items WHERE id = ?");
        
        // bind parameters
        $stmt->bind_param("i", $id);
        
        // execute query, return result
        $stmt->execute();

    } 

    else {
            if (isset($_POST['newitem']) && $_POST['newitem'] == "") {
                $errorMessage = "Field can't be empty! ";
            }
            
            else {
                
                // truncate text to be <= 240 characters
                $newitem = substr($_POST['newitem'], 0, 240);

                // add to database
                $stmt = $mysqli->prepare("INSERT INTO todo_items (items) VALUES (?)");                
                $stmt->bind_param("s", $newitem);
                $stmt->execute();
            }            
    }       
}


// create prepared statements       
$stmt = $mysqli->prepare("SELECT * FROM todo_items LIMIT ? OFFSET ?");

// bind parameters
$stmt->bind_param("ii", $limit, $offset);

// execute query, return result
$stmt->execute();

// bind results
$stmt->bind_result($id, $items);

$rows = array();

while ($stmt->fetch()) {
    $rows[] = array('id' => $id, 'items' => $items);
}

$result = $mysqli->query("SELECT * FROM todo_items");

$num_rows = $result->num_rows;

$num_pages = ceil($num_rows / $limit);

$result->close();

// close connection
$mysqli->close();

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<title>TODO List</title>
</head>

<body>
<div class="container">
    <?php if (!empty($errorMessage)) { ?>
        <div class="alert alert-danger"><?= $errorMessage ?></div>
    <?php } ?>
    <h2>TODO List</h2>

        <table class="table table-striped">
        <? foreach ($rows as $row) :?>
            <tr>
              <td><?=$row['items']; ?></td>
              <td><button class="btn btn-danger btn-sm pull-right" onclick="removeById(<?= $row['id']; ?>)">Remove</button></td>
            </tr>
        <? endforeach; ?>
    </table>

    <div>
        <? if ($page > 1): ?>
            <? $page_no = $page - 1; ?>
            <a href="?page=<?= $page_no; ?>">&lt; Previous</a>
        <? endif; ?>
    
        <? if ($page < $num_pages): ?>
            <? $page_no = $page + 1; ?>
            <a href="?page=<?= $page_no; ?>">Next &gt;</a>
        <? endif; ?>
    </div>
    <br>

    <!-- Button trigger modal -->
    <p>
        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
          Add new todo item
        </button>
    </p>
    
    
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="myModalLabel">Add new todo item</h4>
          </div>
          <div class="modal-body">
    		<form method="POST" action="mysql-todo-list.php">
    			<p>
    				<label for="newitem">New item</label>
    				<input id="newitem" name="newitem" placeholder="Enter new item" type="text">
    			</p>
    			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              	<button type="submit" class="btn btn-primary">Add</button>
    		</form>	
    	  </div>
        </div>
      </div>
    </div>
</div>

    <!-- Hidden form javascript uses it to submit so we have post and not get -->
    <form id="removeForm" action="mysql-todo-list.php" method="POST">
    	<input id="removeId" type="hidden" name="remove" value="">
    	<input type="hidden" name="form_type" value="remove_form">
    </form>
    
    <script>
        // Grab form with id removeForm
    	var form = document.getElementById('removeForm');
    
        // Get hiddent input to change its value before submitting
    	var removeId = document.getElementById('removeId');
    
        // form called from button onclick
    	function removeById(id) {
            if (confirm('Are you sure you want to remove item?')) {
                // change hidden field id to button clicked passed as param id
    		    removeId.value = id;
        
                // submit form
    		    form.submit();
            }
    	}
    </script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

</body>
</html>