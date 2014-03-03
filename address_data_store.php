<?php

require_once('filestore.php');

class AddressDataStore extends Filestore {


    function __construct($filename) {
    
    	$filename = strtolower($filename);
    	parent::__construct($filename);
	}

}


	// function write_address_book($address_book) {
	    
	//     $handle = fopen($this->filename, 'w+');
	//     foreach ($address_book as $fields) {
	// 		fputcsv($handle, $fields);
	// 	}
	// 	fclose($handle);
	// }
	
	// function read_address_book() {
	// 	$address_book = [];
	// 	$handle = fopen($this->filename, 'r');
	// 	while (($data = fgetcsv($handle)) !== FALSE) {
	//   		$address_book[] = $data;
	// 	}
	// 	fclose($handle);
	// 	return $address_book;
	// }


?>