<?php

var_dump($_POST);

$address_book = [];
$fields = [];
$filename = 'address_book.csv';

function add_to_address_book($filename, $address_book) {
    
    $handle = fopen($filename, 'w');
    foreach ($address_book as $fields) {
		fputcsv($handle, $fields);
	}
	fclose($handle);
}

	
	if (isset($_POST['name'])) {
		$new_item = htmlspecialchars(strip_tags($_POST['name']));
		array_push($fields, $new_item);			
	}
	if (isset($_POST['address'])) {
		$new_item = htmlspecialchars(strip_tags($_POST['address']));
		array_push($fields, $new_item);			
	}
	if (isset($_POST['city'])) {
		$new_item = htmlspecialchars(strip_tags($_POST['city']));
		array_push($fields, $new_item);			
	}
	if (isset($_POST['state'])) {
		$new_item = htmlspecialchars(strip_tags($_POST['state']));
		array_push($fields, $new_item);			
	}
	if (isset($_POST['zip'])) {
		$new_item = htmlspecialchars(strip_tags($_POST['zip']));
		array_push($fields, $new_item);			
	}
	
array_push($address_book, $fields);

		
var_dump($address_book);	
add_to_address_book($filename, $address_book);

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
			
				<? foreach ($address_book as $fields) : ?>
					<td><?= $_POST['name']; ?></td>
					<td><?= $_POST['address']; ?></td>
					<td><?= $_POST['city']; ?></td>
					<td><?= $_POST['state']; ?></td>
					<td><?= $_POST['zip']; ?></td>
					<td><?= $_POST['phone']; ?></td>
				<? endforeach; ?>
			</tr>
		</table>
	
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
	
</body>
</html>