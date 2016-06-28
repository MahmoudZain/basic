<?php
include_once(get_template_directory() . '/database/db-integration/db_helper.php');
global $wpdb;

class wp_api extends db_helper
{
    public $lastError;

    function execute($query)
    {
        global $wpdb;
        $result = $wpdb->get_results($query);
        $this->set_error($wpdb->last_error);
        if (is_wp_error($result)) {
            return array();
        }
        return $result;
    }

    function set_error($error)
    {
        $this->lastError = $error;
    }

    function execute_rc($query)
    {
        global $wpdb;
        $result = $wpdb->query($query);
        $this->set_error($wpdb->last_error);
        if (is_wp_error($result)) {
            return 0;
        }
        return $wpdb->insert_id > 0 ? $wpdb->insert_id : $result;
    }
}

?>