<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/25/2016
 * Time: 5:50 PM
 */
include_once(get_template_directory() . '/database/db-integration/wp_api.php');
include_once(get_template_directory() . '/database/db-integration/db_helper.php');

class items_dal
{
    private $dbObj;

    function __construct(db_helper $db)
    {
        $this->dbObj = $db;
    }

    function get_items($filters)
    {
        $query = "SELECT * FROM items";
        if (isset($filters['keyword'])) {
            $query .= " WHERE items.name LIKE '%" . $filters['keyword']->value . "%'";
        }
        $result = $this->dbObj->execute($query);
        return $result;
    }

    function add_item($item, $user_id)
    {
        $query = "INSERT INTO `items`(`name`, `media_id`, `user_id`) VALUES"
            . " ('" . $item->name . "', " . $item->media_id . "," . $user_id . ")";
        return $this->dbObj->execute_rc($query);
    }

    function add_item_lang($item, $lang_id)
    {
        $query = "INSERT INTO `items_lang`(`item_id`, `item_name`, `lang_id`)" .
            " VALUES (" . $item->id . ",'" . $item->name . "'," . $lang_id . ")";
        return $this->dbObj->execute($query);
    }

    function get_item_by_id($item_id)
    {
        $query = "SELECT `name`, `media_id`, `user_id` FROM `items` WHERE id=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function get_item_gallery_media($item_id)
    {
        $query = "SELECT  media.id , media.media_url FROM "

            . "`item_gallery` INNER JOIN `gallery_media` "

            . "ON item_gallery.gallery_id = gallery_media.gallery_id "

            . "INNER JOIN media ON media.id = gallery_media.media_id "

            . "WHERE item_gallery.item_id=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function get_item_lang($item_id, $lang_id)
    {
        $query = "SELECT `item_name` FROM `items_lang` WHERE `item_id`=" . $item_id . " AND `lang_id`=" . $lang_id;
        return $this->dbObj->execute($query);
    }

    function update_item($item, $user_id)
    {
        $query = "UPDATE `items` SET `name`='" . $item->name . "',`media_id`=" . $item->media_id . ","
            . " `user_id`=" . $user_id . " WHERE `id`=" . $item->id;
        return $this->dbObj->execute($query);
    }

    function update_item_lang($item, $lang_id)
    {
        $query = "UPDATE `items_lang` SET `item_name`='" . $item->name . "',"
            . "`lang_id`=" . $lang_id . " WHERE `item_id`=" . $item->id . " AND `lang_id`=" . $lang_id;
        return $this->dbObj->execute($query);
    }

    function get_item_gallery_id($item_id)
    {
        $query = "SELECT `gallery_id` FROM `item_gallery` WHERE `item_id`=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function delete_item($item_id)
    {
        $query = "DELETE FROM `items` WHERE `id`=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function delete_item_lang($item_id)
    {
        $query = "DELETE FROM `items_lang` WHERE `item_id`=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function delete_item_gallery($item_id)
    {
        $query = "DELETE FROM `item_gallery` WHERE `item_id`=" . $item_id;
        return $this->dbObj->execute($query);
    }

    function add_item_attribute_value($item_id, $attribute_value)
    {
        $query = "INSERT INTO `item_attribute_value`(`item_id`, `attribute_id`, `value_text`, `value_id`)"
            . " VALUES ($item_id,$attribute_value->attribute_id,'$attribute_value->value',$attribute_value->id)";
        return $this->dbObj->execute($query);
    }

    function add_item_attribute_value_lang($item_id, $attribute_value, $lang_id)
    {
        $query = "INSERT INTO `item_attribute_value_lang`(`item_id`, `attribute_id`, `lang_id`, `value_text`, `value_id`)"
            . " VALUES ($item_id,$attribute_value->attribute_id,$lang_id,'$attribute_value->value',$attribute_value->id)";
        return $this->dbObj->execute($query);
    }

    function get_item_attribute_value($item_id, $attribute_id)
    {
        $query = "SELECT `item_id`, `attribute_id`, `value_text`, `value_id` FROM `item_attribute_value`"
            . " WHERE `item_id`=$item_id and `attribute_id`=$attribute_id";
        return $this->dbObj->execute($query);
    }

    function get_item_attribute_value_lang($item_id, $attribute_id, $lang_id)
    {
        $query = "SELECT `item_id`, `attribute_id`, `lang_id`, `value_text`, `value_id` FROM `item_attribute_value_lang`"
            . " WHERE `item_id`=$item_id and `attribute_id`=$attribute_id and `lang_id`=$lang_id";
        return $this->dbObj->execute($query);
    }

    function update_item_attribute_value($item_id, $attribute_value)
    {
        $query = "UPDATE `item_attribute_value` SET `item_id`=$item_id,`attribute_id`=$attribute_value->attribute_id,"
            . "`value_text`='$attribute_value->value',`value_id`=$attribute_value->id "
            . " WHERE `item_id`=$item_id and `attribute_id`=$attribute_value->attribute_id";
        return $this->dbObj->execute_rc($query);
    }

    function update_item_attribute_value_lang($item_id, $attribute_value, $lang_id)
    {
        $query = "UPDATE `item_attribute_value_lang` SET `item_id`=$item_id,`attribute_id`=$attribute_value->attribute_id,"
            . "`lang_id`=$lang_id,`value_text`='$attribute_value->value',`value_id`=$attribute_value->id "
            . " WHERE `item_id`=$item_id and `attribute_id`=$attribute_value->attribute_id and `lang_id`=$lang_id";
        return $this->dbObj->execute($query);
    }

    function delete_all_item_attributes_values($item_id)
    {
        $query = "DELETE FROM `item_attribute_value` WHERE `item_id`=$item_id";
        return $this->dbObj->execute($query);
    }

    function delete_all_item_attributes_values_lang($item_id)
    {
        $query = "DELETE FROM `item_attribute_value_lang` WHERE `item_id`=$item_id";
        return $this->dbObj->execute($query);
    }

    function get_search_items($lang_id, $filters, $attributes)
    {
        $keyword = '';
        if (isset($filters['keyword'])) {
            $keyword = "AND items_lang.item_name LIKE '%" . $filters['keyword'] . "%'";
        }
        $pagination = '';
        if ($filters['pagination']) {
            $pagination = "LIMIT " . $filters['page_from'] . "," . $filters['page_count'];
        }
        if (count($attributes)) {
            $conditions = "WHERE";
            $count = 0;
            foreach ($attributes as $attribute) {
                if ($count > 0) {
                    $conditions .= " AND item_id IN(SELECT item_id FROM item_attribute_value_lang WHERE";
                }
                $conditions .= " ";
                if (isset($attribute->value_id)) {
                    $conditions .= " item_attribute_value_lang.attribute_id=" . $attribute->attribute_id . " and"
                        . " item_attribute_value_lang.`value_id`=" . $attribute->value_id . " and"
                        . " item_attribute_value_lang.lang_id=" . $lang_id;
                } elseif (isset($attribute->value_text) && !empty($attribute->value_text)) {
                    $conditions .= " item_attribute_value_lang.attribute_id=" . $attribute->attribute_id . " and"
                        . " item_attribute_value_lang.`value_text`='" . $attribute->value_text . "' and"
                        . " item_attribute_value_lang.lang_id=" . $lang_id;
                } elseif (isset($attribute->has_range) && !empty($attribute->has_range)) {
                    $conditions .= " item_attribute_value_lang.attribute_id=" . $attribute->attribute_id . " and"
                        . " item_attribute_value_lang.`value_text` between convert(" . $attribute->value_from . ",unsigned integer)"
                        . " AND convert(" . $attribute->value_to . ",unsigned integer) and"
                        . " item_attribute_value_lang.lang_id=" . $lang_id;
                }
                if ($count > 0) {
                    $conditions .= ")";
                }
                $count++;
            }
        }
        $query = "SELECT items.id AS id, items_lang.item_name AS name, media.media_url AS url FROM items inner join items_lang on items.id = items_lang.item_id "
            . " inner join media on items.media_id = media.id WHERE items_lang.lang_id=" . $lang_id . " $keyword AND items.id IN "
            . " (SELECT item_id FROM item_attribute_value_lang " . $conditions . ") $pagination";//var_dump($query);die();
        return $this->dbObj->execute($query);
    }

    function get_item_gallery_urls($item_id)
    {
        $query = "SELECT item_gallery.gallery_id, media.id, media.media_url AS url FROM "
            . " item_gallery INNER JOIN gallery_media on item_gallery.gallery_id = gallery_media.gallery_id "
            . " INNER JOIN media on gallery_media.media_id = media.id WHERE item_gallery.item_id=$item_id";
        return $this->dbObj->execute($query);
    }
}