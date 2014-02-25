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

// Verify there were uploaded files and no errors
if ((count($_FILES) > 0) && ($_FILES['upload_file']['error'] == 0)) {
    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $filename = basename($_FILES['upload_file']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename);

    //check if file is text/plain
    if ($_FILES['upload_file']['type'] == "text/plain") {

		// Check if we saved a file
		if (isset($saved_filename)) {
    		// If we did, show a link to the uploaded file
    		echo "<p>You can download your file <a href='/uploads/{$filename}'>here</a>.</p>";
		}
	}
	else {
		echo "Your file is not a plain text file";
	}
}

// Check if uploaded file is a text file


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

	<h1>Upload File</h1>
	<form method="POST" enctype="multipart/form-data">
		<p>
			<label for="upload_file">Upload file</label>
			<input id="upload_file" name="upload_file" type="file">
		</p>
		<p>
			<input type="submit" value="Upload">
		</p>

	</form>	
</body>
</html>