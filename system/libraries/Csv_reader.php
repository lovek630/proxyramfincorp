<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CSVReader Class
*
* $Id: csvreader.php 147 2007-07-09 23:12:45Z Pierre-Jean $
*
* Allows to retrieve a CSV file content as a two dimensional array.
* The first text line shall contains the column names.
*
* @author        Pierre-Jean Turpeau
* @link        http://www.codeigniter.com/wiki/CSVReader
*/
class CI_Csv_reader {
    
    var $fields;        /** columns names retrieved after parsing */
    var $separator = ',';    /** separator used to explode each line */
    
    /**
     * Parse a text containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_text($p_Text) {

        $lines = explode("\n", $p_Text);
        return $this->parse_lines($lines);

    }
    
    /**
     * Parse a file containing CSV formatted data.
     *
     * @access    public
     * @param    string
     * @return    int
     */
    function get_number_record($p_Filepath) {

        $lines = file($p_Filepath);
        return count($lines);

    }
    /**
     * Parse a file to count number for records.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_file($p_Filepath) {

        $lines = file($p_Filepath);
        return $this->parse_lines($lines);

    }
    /**
     * Parse a file to return number of records as per pagination.
     *
     * @access    public
     * @param    string
     * @return    array
     */
    function parse_file_paginate($p_Filepath, $start, $length) {

        $lines = file($p_Filepath);
        $no_of_record = $this->get_number_record($p_Filepath);
        $record_cnt = $start + $length;
        $length = ($no_of_record >= $record_cnt) ? $length : $no_of_record - $start;
        $paginate_lines = array_slice($lines, $start, $length);
        //echo "<pre>";print_r($paginate_lines);//die();
        return $this->parse_lines($paginate_lines);

    }
    /**
     * Parse an array of text lines containing CSV formatted data.
     *
     * @access    public
     * @param    array
     * @return    array
     */
    function parse_lines($p_CSVLines) {    

        foreach( $p_CSVLines as $line_num => $line ) {

            if( $line != '' ) { // skip empty lines
                $elements = explode($this->separator, $line);
                    $this->fields = $elements;
                    $item = array();
                    $index = 0;
                    foreach( $this->fields as $id => $field ) {
                        if( isset($elements[$id]) ) {
                            $item[$index] = $elements[$id];
                            $index++;
                        }
                    }
                    $content[] = $item;
                }
        }
        //echo "<pre>";print_r( $content);
        return $content;

    }
}
