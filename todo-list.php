<?php

// echo "<p>POST:</p>";
// var_dump($_POST);
// var_dump($_GET);

$filename = 'todo_list.txt';

function add_to_list($filename) {
       
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));
    fclose($handle);    
    return explode("\n", $contents);

}

function save_file($filename, $items) {

	$items_string = implode("\n", $items);
	$handle = fopen($filename, 'w');        
    fwrite($handle, $items_string);
   	fclose($handle);

}
$items = add_to_list($filename);

//check that file is not empty
// if (filesize($filename > 0)) {
// 	$items = add_to_list($filename);
// }
// else {
// 	$items = [];
// }

if (isset($_POST['newitem'])) {
	$new_item = $_POST['newitem'];
	array_push($items, $new_item);
	save_file($filename, $items);
}

if (isset($_GET['remove'])) {
	unset($items[$_GET['remove']]);
	save_file($filename, $items);
	//refreshes page to start at the beginning
	header("Location: todo-list.php");
	exit(0);
}


?>

<!DOCTYPE html>
<html>
<head>
		<title>TODO List</title>
</head>
<body>
	<h2>TODO List</h2>
	<ul>
		<?php
			
			foreach ($items as $key => $item) {
				echo "<li>$item <a href=\"?remove=$key\">Remove</a></li>";
			}

		?>
	</ul>
	<h2>Add items to the list</h2>
	<form method="POST" action="todo-list.php">
		<p>
			<label for="newitem">New item</label>
			<input id="newitem" name="newitem" placeholder="Enter new item" type="text">
			<input type="submit" value="add">
		</p>

	</form>	
</body>
</html>