<?php

echo "<p>POST:</p>";
var_dump($_POST);

?>

<!DOCTYPE html>
<html>
<head>
		<title>TODO List</title>
</head>
<body>
	<h2>TODO List</h2>
	<ul>
		<li>Do laundry</li>
		<li>Cook dinner</li>
		<li>Clean bathrooms</li>
	</ul>
	<h2>Add items to the list</h2>
	<form method="POST" action="">
		<p>
			<label for="new item"></label>
			<input id="new item" name="new item" placeholder="Enter new item" type="text">
		</p>

	</form>	
</body>
</html>