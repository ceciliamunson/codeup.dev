<?php

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

    /**
     * Returns array of lines in $this->filename
     */
    // for todo list
    private function read_lines()
    {
        $handle = fopen($this->filename, "r");
        $contents = fread($handle, filesize($this->filename));
        fclose($handle);    
        return  explode("\n", $contents);
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    //for todo list
    private function write_lines($array)
    {   
        
        $handle = fopen($this->filename, 'w');        
        foreach ($array as $content) {
                    fwrite($handle, PHP_EOL . $content);
                }
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