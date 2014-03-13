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

// Create the query and assign to var
$query = 'CREATE TABLE national_parks (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    location VARCHAR(15) NOT NULL,
    description TEXT NOT NULL,
    date_est DATE NOT NULL,
    area_acres FLOAT(10, 2) NOT NULL,
    PRIMARY KEY (id)
);';

// Run query, if there are errors then display them
if (!$mysqli->query($query)) {
    throw new Exception("Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error);
}

$parks = [
    ['name' => 'Acadia', 'location' => 'Maine', 'description' => "Covering most of Mount Desert Island and other coastal islands, Acadia features the tallest mountain on the Atlantic coast of the United States, granite peaks, ocean shoreline, woodlands, and lakes. There are freshwater, estuary, forest, and intertidal habitats.",
    'date_est' => '1919-02-26', 'area_acres' => '47389.67'],

    ['name' => 'Badlands', 'location' => 'South Dakota', 'description' => "The Badlands are a collection of buttes, pinnacles, spires, and grass prairies. It has the world\'s richest fossil beds from the Oligocene epoch, and there is wildlife including bison, bighorn sheep, black-footed ferrets, and swift foxes.",
    'date_est' => '1978-11-10', 'area_acres' => '242755.94'],

    ['name' => 'Congaree', 'location' => 'South Carolina', 'description' => "On the Congaree River, this park is the largest portion of old-growth floodplain forest left in North America. Some of the trees are the tallest in the Eastern US, and the Boardwalk Loop is an elevated walkway through the swamp.",
    'date_est' => '2003-11-10', 'area_acres' => '26545.86'],

    ['name' => 'Denali', 'location' => 'Alaska', 'description' => "Centered around the Mount McKinley, the tallest mountain in North America, Denali is serviced by a single road leading to Wonder Lake. McKinley and other peaks of the Alaska Range are covered with long glaciers and boreal forest. Wildlife includes grizzly bears, Dall sheep, caribou, and gray wolves.",
    'date_est' => '1917-02-26', 'area_acres' => '4740911.72'],

    ['name' => 'Everglades', 'location' => 'Florida', 'description' => "The Everglades are the largest subtropical wilderness in the United States. This mangrove ecosystem and marine estuary is home to 36 protected species, including the Florida panther, American crocodile, and West Indian manatee. Some areas have been drained and developed; restoration projects aim to restore the ecology.",
    'date_est' => '1934-03-30', 'area_acres' => '1508537.90'],

    ['name' => 'Glacier', 'location' => 'Montana', 'description' => "Part of Waterton Glacier International Peace Park, this park has 26 remaining glaciers and 130 named lakes under the tall Rocky Mountain peaks. There are historic hotels and a landmark road in this region of rapidly receding glaciers. These mountains, formed by an overthrust, have the world\'s best sedimentary fossils from the Proterozoic era.",
    'date_est' => '1910-05-11', 'area_acres' => '1013572.41'],

    ['name' => 'Haleakalā', 'location' => 'Hawaii', 'description' => "The Haleakalā volcano on Maui has a very large crater with many cinder cones, Hosmer\'s Grove of alien trees, and the native Hawaiian Goose. The Kipahulu section has numerous pools with freshwater fish. This National Park has the greatest number of endangered species.",
    'date_est' => '1916-08-01', 'area_acres' => '29093.67'],

    ['name' => 'Olympic', 'location' => 'Washington', 'description' => "Situated on the Olympic Peninsula, this park ranges from Pacific shoreline with tide pools to temperate rainforests to Mount Olympus. The glaciated Olympic Mountains overlook the Hoh Rain Forest and Quinault Rain Forest, the wettest area of the continental United States.",
    'date_est' => '1938-06-29', 'area_acres' => '922650.86'],

    ['name' => 'Redwood', 'location' => 'California', 'description' => "This park and the co-managed state parks protect almost half of all remaining Coastal Redwoods, the tallest trees on Earth. There are three large river systems in this very seismically active area, and the 37 miles (60 km) of protected coastline have tide pools and seastacks. The prairie, estuary, coast, river, and forest ecosystems have varied animal and plant species.",
    'date_est' => '1968-10-02', 'area_acres' => '112512.05'],

    ['name' => 'Yosemite', 'location' => 'California', 'description' => "Yosemite has towering cliffs, waterfalls, and sequoias in a diverse area of geology and hydrology. Half Dome and El Capitan rise from the central glacier-formed Yosemite Valley, as does Yosemite Falls, North America\'s tallest waterfall. Three Giant Sequoia groves and vast wilderness are home to diverse wildlife.",
    'date_est' => '1890-10-01', 'area_acres' => '761266.19'],
    
];

foreach ($parks as $park) {
    $query = "INSERT INTO national_parks (name, location, description, date_est, area_acres) VALUES ('{$park['name']}', '{$park['location']}', '{$park['description']}', '{$park['date_est']}', '{$park['area_acres']}');";
    if (!$mysqli->query($query)) {
    	throw new Exception("Table was not created: (" . $mysqli->errno . ") " . $mysqli->error);
    }
}

?>