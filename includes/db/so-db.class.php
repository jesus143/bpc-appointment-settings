<?php

namespace APP;

use APP\WPDB_QUERIES;

class SODB {

    private $wpdb = '';
    private static $table_name = 'wp_simple_order';

    function __construct()
    {
        //
    }

    public static function getAllEntry($limit=null)
    {
        $wpdb_queries = new WPDB_QUERIES(self::$table_name);
        if($limit != null) {
            return $wpdb_queries->wpdb_get_result("select * from " . self::$table_name . " limit $limit");
        } else {
            return $wpdb_queries->wpdb_get_result("select * from " . self::$table_name);
        }
    }

    public static function getEntryById($id)
    {
        $wpdb_queries = new WPDB_QUERIES(self::$table_name);
        return $wpdb_queries->wpdb_get_result("select * from " . self::$table_name . " where id = " . $id);
    }

    public static function updateEntry($data = array(), $id)
    {
        $wpdb_queries = new WPDB_QUERIES(self::$table_name);
        return $wpdb_queries->wpdb_update($data, array('id'=>$id));
    }

    public static function deleteEntry($id)
    {
        $wpdb_queries = new WPDB_QUERIES(self::$table_name);
        return  $wpdb_queries->wpdb_delete(array('id'=>$id));
    }

    public static function addEntry($data = array())
    {
       $wpdb_queries = new WPDB_QUERIES(self::$table_name);
       return  $wpdb_queries->wpdb_insert($data);
    }

}