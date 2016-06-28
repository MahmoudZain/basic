<?php

/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/25/2016
 * Time: 9:52 PM
 */
include_once(get_template_directory() . '/database/dal/items.php');
include_once(get_template_directory() . '/database/db-integration/wp_api.php');

class items_bl
{
    private $dal;

    function __construct()
    {
        $db = new wp_api();
        $this->dal = new items_dal($db);
    }

    function get_items($filters)
    {
        $all_items = $this->dal->get_items($filters);
        return $all_items;
    }

    function add_item($item, $user_id)
    {
        return $this->dal->add_item($item, $user_id);
    }

    function add_item_lang($item, $lang_id)
    {
        return $this->dal->add_item_lang($item, $lang_id);
    }

    function get_item_by_id($item_id)
    {
        $item = new stdClass();
        $item->item = $this->dal->get_item_by_id($item_id);
        $item->media = $this->get_item_gallery_media($item_id);
        $item->gallery = $this->get_item_gallery_id($item_id);
        return $item;
    }

    function get_item_gallery_media($item_id)
    {
        return $this->dal->get_item_gallery_media($item_id);
    }

    function get_item_lang($item_id, $lang_id)
    {
        return $this->dal->get_item_lang($item_id, $lang_id);
    }

    function update_item($item, $user_id)
    {
        return $this->dal->update_item($item, $user_id);
    }

    function update_item_lang($item, $lang_id)
    {
        return $this->dal->update_item_lang($item, $lang_id);
    }

    function get_item_gallery_id($item_id)
    {
        return $this->dal->get_item_gallery_id($item_id);
    }

    function delete_item_by_id($item_id)
    {
        include_once(THEME_PHYSICAL_DIR . '/database/bl/media.php');
        include_once(THEME_PHYSICAL_DIR . '/database/bl/gallery.php');
        $media_bl = new media_bl();
        $gallery_bl = new gallery_bl();
        $media_id = $this->dal->get_item_by_id($item_id)[0]->media_id;
        $media_bl->delete_media($media_id);
        $medias = $this->get_item_gallery_media($item_id);
        foreach ($medias as $media) {
            $media_bl->delete_media($media->id);
            $gallery_bl->delete_gallery_media($media->id);
        }
        $gallery_bl->delete_gallery($this->get_item_gallery_id($item_id)[0]->gallery_id);
        $this->delete_item_gallery($item_id);
        $this->delete_item($item_id);
        $this->delete_item_lang($item_id);
        $this->delete_all_item_attributes_values($item_id);
        $this->delete_all_item_attributes_values_lang($item_id);
    }

    function delete_item($item_id)
    {
        return $this->dal->delete_item($item_id);
    }

    function delete_item_lang($item_id)
    {
        return $this->dal->delete_item_lang($item_id);
    }

    function delete_item_gallery($item_id)
    {
        return $this->dal->delete_item_gallery($item_id);
    }

    function add_item_attribute_value($item_id, $attribute_value)
    {
        return $this->dal->add_item_attribute_value($item_id, $attribute_value);
    }

    function add_item_attribute_value_lang($item_id, $attribute_value, $lang_id)
    {
        return $this->dal->add_item_attribute_value_lang($item_id, $attribute_value, $lang_id);
    }

    function get_item_attribute_value($item_id, $attribute_id)
    {
        return $this->dal->get_item_attribute_value($item_id, $attribute_id);
    }

    function get_item_attribute_value_lang($item_id, $attribute_id, $lang_id)
    {
        return $this->dal->get_item_attribute_value_lang($item_id, $attribute_id, $lang_id);
    }

    function update_item_attribute_value($item_id, $attribute_value)
    {
        return $this->dal->update_item_attribute_value($item_id, $attribute_value);
    }

    function update_item_attribute_value_lang($item_id, $attribute_value, $lang_id)
    {
        return $this->dal->update_item_attribute_value_lang($item_id, $attribute_value, $lang_id);
    }

    function delete_all_item_attributes_values($item_id)
    {
        return $this->dal->delete_all_item_attributes_values($item_id);
    }

    function delete_all_item_attributes_values_lang($item_id)
    {
        return $this->dal->delete_all_item_attributes_values($item_id);
    }

    function get_item_gallery_urls($item_id, $img_size)
    {
        $images = $this->dal->get_item_gallery_urls($item_id);
        foreach ($images as $img) {
            $pos = strrpos($img->url, '.');
            $add_size = '-' . $img_size . strrchr($img->url, '.');
            if ($pos !== false) {
                $img->url = substr_replace($img->url, $add_size, $pos, 10);
            }
        }
        return $images;
    }

    function get_search_items($lang_id, $filters, $attributes, $attributes_range)
    {
        $attributes = explode('|', $attributes);
        $search_attributes = array();
        foreach ($attributes as $attribute) {
            $attribute = explode(':', $attribute);
            if (isset($attribute[0]) && isset($attribute[1])) {
                $attribute_obj = new stdClass();
                $attribute_obj->attribute_id = $attribute[0];
                $attribute_obj->value_id = $attribute[1];
                $search_attributes[] = $attribute_obj;
            }
        }
        $attributes_range = explode('|', $attributes_range);
        foreach ($attributes_range as $range) {
            $range = explode(':', $range);
            $attribute_obj = new stdClass();
            $attribute_obj->has_range = true;
            $attribute_obj->attribute_id = $range[0];
            $range = explode(',', $range[1]);
            if (isset($range[0]) && !empty($range[0]) && isset($range[1]) && !empty($range[1])) {
                $attribute_obj->value_from = $range[0];
                $attribute_obj->value_to = $range[1];
                $search_attributes[] = $attribute_obj;
            }
        }
        $items = $this->dal->get_search_items($lang_id, $filters, $search_attributes);
        $img_size = "260x200";
        foreach ($items as $item) {
            $item->url = $this->get_item_gallery_urls($item->id, $img_size)[0]->url;
        }
        return $items;
    }

}