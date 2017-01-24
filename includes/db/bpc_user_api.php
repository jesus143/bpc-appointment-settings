<?php


namespace App;

use App\PBC_AS_WPDB_QUERIES;

class Bpc_User_Api{


    private $table_name = 'wp_bpc_user_api';

    function __construct()
    {
        $this->bpc_as_wpdb_queries = new PBC_AS_WPDB_QUERIES($this->table_name);
    }


    public function getCurrentUserGoogleApi()
    {
        $user_id = bpc_as_get_current_user_logged_in_id();
        return $this->bpc_as_wpdb_queries->wpdb_get_result("select * from $this->table_name where user_id = $user_id ");
    }

    public function getGoogleCalendarAccessToken()
    {
        $googleApi = $this->getCurrentUserGoogleApi();
        return $googleApi[0]['access_token'];
    }
    public function addOrUpdate($apiInfo=[])
    {

        $name = $apiInfo['name'];
        $user_id = bpc_as_get_current_user_logged_in_id();
        $userInfoApi = $this->bpc_as_wpdb_queries->wpdb_get_result("select * from $this->table_name where user_id = $user_id ");

        if($userInfoApi) {
            //            print "update google api";
            // print exist do update
            if($this->bpc_as_wpdb_queries->wpdb_update($apiInfo, ['user_id'=>$user_id])) {
            //                print " successfully updated";
            } else {
            //                print " failed to updated";
            }
        } else {
            //            print "insert google api";
            $apiInfo['user_id'] = $user_id;
            if($this->bpc_as_wpdb_queries->wpdb_insert($apiInfo)) {
            //                print "successfully inserted";
            } else {
            //                print "failed to insert";
            }
        }
    }

    public function disconnectGoogleCalendar()
    {
        $user_id = bpc_as_get_current_user_logged_in_id();
        return $this->bpc_as_wpdb_queries->wpdb_delete(['user_id'=>$user_id, 'name'=>'google calendar']);
    }
}
