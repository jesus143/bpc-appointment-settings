<?php
/**
 * Created by PhpStorm.
 * User: JESUS
 * Date: 9/10/2016
 * Time: 6:56 PM
 */

namespace wpdb_oop;

class WPDB_OOP_QUERIES
{

    private $wpdb;
    private $table_name;

    function __construct($table_name='')
    {

        global $wpdb;
        $this->wpdb = $wpdb;
        $this->table_name = $table_name;

       // print "construct debugging";
    }


    public function select($query, $response_format=ARRAY_A) {
        return $this->wpdb->get_row( $query , $response_format );
    }

    public function update() {
        print "update";
    }

    public function insert() {
        print "insert";
    }

    public function delete() {
        print "delete";
    }
}