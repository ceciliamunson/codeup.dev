<?php

class AddressDataStore {

    public $filename = '';

    function __construct($filename = '')
    {
        $this->filename = $filename;
    }

	function write_address_book($address_book) {
	    
	    $handle = fopen($this->filename, 'w+');
	    foreach ($address_book as $fields) {
			fputcsv($handle, $fields);
		}
		fclose($handle);
	}
	
	function read_address_book() {
	
		$handle = fopen($this->filename, 'r');
		while (($data = fgetcsv($handle)) !== FALSE) {
	  		$address_book[] = $data;
		}
		fclose($handle);
		return $address_book;
	}
}

?>