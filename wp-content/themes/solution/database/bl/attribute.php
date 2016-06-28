<?php
include_once(get_template_directory() . '/database/dal/attribute.php');
include_once(get_template_directory() . '/database/db-integration/wp_api.php');

class attribute_bl
{
    private $dal;

    function __construct()
    {
        $db = new wp_api();
        $this->dal = new attribute_dal($db);
    }

    function add_attribute($attribute)
    {
        return $this->dal->add_attribute($attribute);
    }

    function add_attribute_lang($attribute, $lang_id)
    {
        return $this->dal->add_attribute_lang($attribute, $lang_id);
    }

    function add_attribute_value($attribute_value)
    {
        return $this->dal->add_attribute_value($attribute_value);
    }

    function add_attribute_value_lang($attribute_value, $lang_id)
    {
        return $this->dal->add_attribute_value_lang($attribute_value, $lang_id);
    }

    function get_all_attributes()
    {
        return $this->dal->get_all_attributes();
    }

    function get_attribute_by_id($attribute_id)
    {
        return $this->dal->get_attribute_by_id($attribute_id);
    }

    function get_attribute_lang($attribute_id, $lang_id)
    {
        return $this->dal->get_attribute_lang($attribute_id, $lang_id);
    }

    function get_attribute_values($attribute_id)
    {
        return $this->dal->get_attribute_values($attribute_id);
    }

    function get_attribute_values_lang($attribute_value_id, $lang_id)
    {
        return $this->dal->get_attribute_values_lang($attribute_value_id, $lang_id);
    }

    function update_attribute($attribute)
    {
        return $this->dal->update_attribute($attribute);
    }

    function update_attribute_lang($attribute, $lang_id)
    {
        return $this->dal->update_attribute_lang($attribute, $lang_id);
    }

    function update_attribute_value($attribute_value)
    {
        return $this->dal->update_attribute_value($attribute_value);
    }

    function update_attribute_value_lang($attribute_value, $lang_id)
    {
        return $this->dal->update_attribute_value_lang($attribute_value, $lang_id);
    }

    function delete_attribute($attribute_id)
    {
        return $this->dal->delete_attribute($attribute_id);
    }

    function delete_attribute_with_values($attribute_id)
    {
        return $this->dal->delete_attribute_with_values($attribute_id);
    }

    function delete_attribute_value($attribute_value_id)
    {
        $this->dal->delete_attribute_value($attribute_value_id);
        return $this->dal->delete_attribute_value_lang($attribute_value_id);
    }

    function be_get_attributes_list($list)
    {
        return $this->dal->be_get_attributes_list($list);
    }

    function get_attribute_values_lang_by_attribute_id($attribute_id, $lang_id)
    {
        return $this->dal->get_attribute_values_lang_by_attribute_id($attribute_id, $lang_id);
    }
}