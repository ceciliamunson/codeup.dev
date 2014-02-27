<?php

//var_dump($_POST);

$address_book = [];
$fields = [];
$filename = 'address_book.csv';

function add_to_address_book($filename, $address_book) {
    
    $handle = fopen($filename, 'w+');
    foreach ($address_book as $fields) {
		fputcsv($handle, $fields);
	}
	fclose($handle);
}

function read_csv($filename, $address_book) {

	$handle = fopen($filename, 'r');
	while (($data = fgetcsv($handle)) !== FALSE) {
  		$address_book[] = $data;
	}
	fclose($handle);
	return $address_book;
}
$address_book = read_csv($filename, $address_book);
$error_message = [];



if (!empty($_POST)) {
	foreach ($_POST as $key => $field) {
		$new_item = htmlspecialchars(strip_tags($field));
		if (empty($new_item)) {
			array_push($error_message, $key);
		}
		array_push($fields, $new_item);	
	}
	array_push($address_book, $fields);
	add_to_address_book($filename, $address_book);
}

if (isset($_GET['remove'])) {
	unset($address_book[$_GET['remove']]);
	add_to_address_book($filename, $address_book);
	//refreshes page to start at the beginning
	header("Location: address_book.php");
	exit(0);
}


var_dump($address_book);
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
	
</body>
</html>