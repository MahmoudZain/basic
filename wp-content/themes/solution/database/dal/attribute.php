<?php
include_once(get_template_directory() . '/database/db-integration/wp_api.php');
include_once(get_template_directory() . '/database/db-integration/db_helper.php');

class attribute_dal
{
    private $dbObj;

    function __construct(db_helper $db)
    {
        $this->dbObj = $db;
    }

    function add_attribute($attribute)
    {
        $query = "INSERT INTO `attributes`(`attribute_name`, `attribute_type`, `media_id`)"
            . " VALUES ('$attribute->name','$attribute->type',$attribute->media_id)";
        return $this->dbObj->execute_rc($query);
    }

    function add_attribute_lang($attribute, $lang_id)
    {
        $query = "INSERT INTO `attribute_lang`(`attribute_id`, `lang_id`, `attribute_name`)"
            . " VALUES ($attribute->id,$lang_id,'$attribute->name')";
        return $this->dbObj->execute_rc($query);
    }

    function add_attribute_value($attribute_value)
    {
        $query = "INSERT INTO `attribute_values`(`attribute_id`, `attribute_value`, `order`, `parent_id`, `media_id`)"
            . " VALUES ($attribute_value->attribute_id,'$attribute_value->value',$attribute_value->order" .
            ",$attribute_value->parent_id,$attribute_value->media_id)";
        return $this->dbObj->execute_rc($query);
    }

    function add_attribute_value_lang($attribute_value, $lang_id)
    {
        $query = "INSERT INTO `attribute_values_lang`(`attribute_value_id`, `lang_id`, `attribute_value`) VALUES "
            . " ($attribute_value->id,$lang_id,'$attribute_value->value')";
        return $this->dbObj->execute_rc($query);
    }

    function get_all_attributes()
    {
        $query = "SELECT `id`, `attribute_name`, `attribute_type` FROM `attributes`";
        return $this->dbObj->execute($query);
    }

    function get_attribute_by_id($attribute_id)
    {
        $query = "SELECT `attribute_name`, `attribute_type`, `media_id` FROM `attributes` WHERE `id`=" . $attribute_id;
        return $this->dbObj->execute($query);
    }

    function get_attribute_lang($attribute_id, $lang_id)
    {
        $query = "SELECT `attribute_id`, `attribute_name` FROM `attribute_lang`"
            . "WHERE `attribute_id`=$attribute_id and `lang_id`=" . $lang_id;
        return $this->dbObj->execute($query);
    }

    function get_attribute_values($attribute_id)
    {
        $query = "SELECT `id`, `attribute_value`, `order`, `media_id` FROM `attribute_values` WHERE `attribute_id`=" . $attribute_id;
        $query .= " ORDER BY attribute_values.order ASC";
        return $this->dbObj->execute($query);
    }

    function get_attribute_values_lang($attribute_value_id, $lang_id)
    {
        $query = "SELECT `attribute_value` FROM `attribute_values_lang` "
            . "WHERE attribute_value_id=" . $attribute_value_id . " and lang_id=" . $lang_id;
        return $this->dbObj->execute($query);
    }

    function update_attribute($attribute)
    {
        $query = "UPDATE `attributes` SET `attribute_name`='$attribute->name',`attribute_type`=$attribute->type,"
            . "`media_id`=$attribute->media_id WHERE `id`=" . $attribute->id;
        return $this->dbObj->execute($query);
    }

    function update_attribute_lang($attribute, $lang_id)
    {
        $query = "UPDATE `attribute_lang` SET `attribute_name`='$attribute->name' "
            . " WHERE `attribute_id`=$attribute->id and `lang_id`=$lang_id";
        return $this->dbObj->execute($query);
    }

    function update_attribute_value($attribute_value)
    {
        $query = "UPDATE `attribute_values` SET "
            . "`attribute_id`=$attribute_value->attribute_id,`attribute_value`='$attribute_value->value',"
            . "`order`=$attribute_value->order,`parent_id`=$attribute_value->parent_id,"
            . "`media_id`=$attribute_value->media_id WHERE `id`=$attribute_value->id";
        return $this->dbObj->execute($query);
    }

    function update_attribute_value_lang($attribute_value, $lang_id)
    {
        $query = "UPDATE `attribute_values_lang` SET `attribute_value`='$attribute_value->value' "
            . " WHERE `attribute_value_id`=$attribute_value->id and `lang_id`=$lang_id";
        return $this->dbObj->execute($query);
    }

    function delete_attribute($attribute_id)
    {
        $query = "DELETE attributes, attribute_lang FROM attributes inner join attribute_lang "
            . " on attributes.id = attribute_lang.attribute_id WHERE attributes.id=$attribute_id";
        return $this->dbObj->execute($query);
    }

    function delete_attribute_with_values($attribute_id)
    {
        $query = "DELETE attributes, attribute_lang, attribute_values, attribute_values_lang"
            . " FROM attributes inner join attribute_lang on attributes.id = attribute_lang.attribute_id "
            . " inner join attribute_values on attribute_lang.attribute_id = attribute_values.attribute_id "
            . " inner join attribute_values_lang on attribute_values.id = attribute_values_lang.attribute_value_id "
            . " WHERE attributes.id=$attribute_id";
        return $this->dbObj->execute($query);
    }

    function delete_attribute_value($attribute_value_id)
    {
        $query = "DELETE FROM `attribute_values` WHERE `id`=$attribute_value_id";
        return $this->dbObj->execute($query);
    }

    function delete_attribute_value_lang($attribute_value_id)
    {
        $query = "DELETE FROM `attribute_values_lang` WHERE `attribute_value_id`=$attribute_value_id";
        return $this->dbObj->execute($query);
    }

    function be_get_attributes_list($list)
    {
        $query = "SELECT * FROM `attributes` WHERE `id`in (";
        foreach ($list as $id) {
            $query .= $id . ",";
        }
        $query = rtrim($query, ',');
        $query .= ")";
        return $this->dbObj->execute($query);
    }

    function get_attribute_values_lang_by_attribute_id($attribute_id, $lang_id)
    {
        $query = "SELECT attribute_values.id, attribute_values_lang.attribute_value "
            . " FROM attribute_values inner join attribute_values_lang on id = attribute_value_id "
            . " WHERE attribute_values.attribute_id =" . $attribute_id . " and attribute_values_lang.lang_id=" . $lang_id
            . " ORDER BY attribute_values.order ASC";
        return $this->dbObj->execute($query);
    }
}