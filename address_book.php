<?php


require_once('address_data_store.php');


$error_message = [];
$fields = [];

$file = new AddressDataStore('address_book.csv');
$address_book = $file->read();

if ((count($_FILES) > 0) && ($_FILES['upload_file']['error'] == 0)) {

    // Set the destination directory for uploads
    $upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
    // Grab the filename from the uploaded file by using basename
    $uploaded_filename = basename($_FILES['upload_file']['name']);
    // Create the saved filename using the file's original name and our upload directory
    $saved_filename = $upload_dir . $uploaded_filename;
    // Move the file from the temp location to our uploads directory
    move_uploaded_file($_FILES['upload_file']['tmp_name'], $saved_filename);
    $file2 = new AddressDataStore("$uploaded_filename");
    $uploadedItems = $file2->read($saved_filename);
 
    $address_book = array_merge($address_book, $uploadedItems);

    $file->write($address_book);
}

if (!empty($_POST)) {
	foreach ($_POST as $key => $field) {
		$new_item = htmlspecialchars(strip_tags($field));
		if (empty($new_item)) {
			array_push($error_message, $key);
		}
		else {
			// Validate if input is < 125 characters
			try {
				$file->validate_addressbook_input($field);
			}
			catch (InvalidAddressbookInputException $e) {
				echo $e->getMessage();
				echo "Please try again";
				exit();
			}
		array_push($fields, $new_item);	
		}
	}
	array_push($address_book, $fields);
	$file->write($address_book);
}

if (isset($_GET['remove'])) {
	unset($address_book[$_GET['remove']]);
	$file->write($address_book);
	//refreshes page to start at the beginning
	header("Location: address_book.php");
	exit(0);
}

array_pop($error_message);	

?>

<!DOCTYPE html>
<html>
<head>
		<title>Address Book</title>
</head>
<body>
	<h2>Address Book</h2>
	
		<table>
			<tr>
					<th><?='Name'; ?></th>
					<th><?='Address'; ?></th>
					<th><?='City'; ?></th>
					<th><?='State'; ?></th>
					<th><?='Zip'; ?></th>
					<th><?='Phone'; ?></th>
			</tr>
				<? foreach ($address_book as $fields => $field) : ?>
			<tr>
			
					<? foreach ($field as $info) : ?>
						<td><?= $info; ?></td>
					<? endforeach; ?>
					<td><?= "<a href=\"?remove=$fields\">Remove</a>"; ?></td>
				<? endforeach; ?>
			</tr>
		</table>
	<? if (count($error_message) != 0) : ?>
		<?//var_dump(count($error_message));?>
		<?= "Must enter following fields: "; ?>
		<?= implode(", ", $error_message); ?>
	<? endif; ?>
	<h2>Add items to the Address Book</h2>
	<form method="POST" action="address_book.php">
		<p>
			<label for="name">Name</label>
			<input id="name" name="name" type="text">
		</p>
		<p>
			<label for="address">Address</label>
			<input id="address" name="address" type="text">
		</p>
		<p>
			<label for="city">City</label>
			<input id="city" name="city" type="text">
		</p>
		<p>
			<label for="state">State</label>
			<input id="state" name="state" type="text">
		</p>
		<p>
			<label for="zip">Zip Code</label>
			<input id="zip" name="zip" type="text">
		</p>
		<p>
			<label for="phone">Phone</label>
			<input id="phone" name="phone" type="text">
		</p>
		<p>
			<input type="submit" value="add">
		</p>
	</form>
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