<?php

class InvalidAddressbookInputException extends Exception {}

class InvalidTodoInputException extends Exception {}

class Filestore {

    public $filename = '';

    private $is_csv = FALSE;

    public function __construct($filename = '') 
    {
        $this->filename = $filename; 

        if (substr($filename, -3) == 'csv') {
            $this->is_csv = TRUE;
        }

    }

    public function read() {

        if ($this->is_csv == TRUE) {

            return $this->read_csv();
        }
        else {

            return $this->read_lines();
        }

    }

    public function write($array) {

        if ($this->is_csv == TRUE) {

            return $this->write_csv($array);
        }
        else {

            return $this->write_lines($array);
        }

    }

    public function validate_input($new_item) {

        if (empty($new_item) || (strlen($new_item) > 240)) {

            throw new InvalidTodoInputException("Must enter input shorter or equal to 125 characters. ");
        }
    }

    public function validate_addressbook_input($input) {

        if (strlen($input) > 125) {

            throw new InvalidAddressbookInputException("Input can't be longer than 125 characters. ");
        }
    }

    /**
     * Returns array of lines in $this->filename
     */
    // for todo list
    private function read_lines()
    {
        $filesize = filesize($this->filename);
        if ($filesize == 0) {

            $contents = [];
        }
        else {

            $handle = fopen($this->filename, "r");
            $contents = fread($handle, $filesize);
            fclose($handle);    
            $contents =explode("\n", $contents);
        }
        return $contents;
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    //for todo list
    private function write_lines($array)
    {   
        $handle = fopen($this->filename, 'w');        
        $items_string = implode("\n", $array);
        fwrite($handle, $items_string);
        fclose($handle);
        
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function read_csv()
    {
        $array = [];
        if(empty($this->filename)) {
            $array = [];
        }
        else {

             $handle = fopen($this->filename, 'r');
             while (($data = fgetcsv($handle)) !== FALSE) {
                 $array[] = $data;
             }
             fclose($handle);
        }
        return $array;
    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    private function write_csv($array)
    {
        $handle = fopen($this->filename, 'w+');
        foreach ($array as $content) {
            fputcsv($handle, $content);
        }
        fclose($handle);
    }

}