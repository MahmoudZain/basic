<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/media-uploader.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/items/forms/script.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/jquery.form-validator.min.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/27/2016
 * Time: 4:08 AM
 */

include_once(THEME_PHYSICAL_DIR . '/database/bl/items.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/media.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/gallery.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/item.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/media.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/gallery.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/attribute_value.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');

global $languages;
global $lang_ids;
global $item_attributes;
global $attributes_types;
global $config_attribute_values;
$items_bl = new items_bl();
$media_bl = new media_bl();
$attribute_bl = new attribute_bl();
$gallery_bl = new gallery_bl();
$item_id = $_GET['item_id'];
$item = $items_bl->get_item_by_id($item_id);
$feature_url = $media_bl->get_image_by_media_id($item->item[0]->media_id);
$attributes = $attribute_bl->be_get_attributes_list($item_attributes);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_item'])) {
    $name = $_POST['item_name_' . $languages['en']];
    if (isset($_POST['media_id']) && $_POST['media_id'] > 0) {
        $media_id = $_POST['media_id'];
    } elseif (isset($_POST['featured_media'])) {
        $new_media = new media(0, $_POST['featured_media']);
        $media_id = $media_bl->add_media($new_media);
    } else {
        $media_id = 0;
    }
    $item_obj = new item($item_id, $name, $media_id, 0);
    $items_bl->update_item($item_obj, 0);
    foreach ($lang_ids as $lang) {
        $name = $_POST['item_name_' . $lang->id];
        $item_obj = new item($item_id, $name, $media_id, 0);
        $items_bl->update_item_lang($item_obj, $lang->id);
    }
    if ($media_id > 0) {
        $feature_media = new media($media_id, $_POST['featured_media']);
        $media_bl->update_media($feature_media);
    }
    if ($_POST['old_media_url']) {
        $index = 0;
        foreach ($_POST['old_media_url'] as $old_media) {
            $new_media = new media($item->media[$index]->id, $old_media);
            $media_bl->update_media($new_media);
            $index++;
        }
    }
    if ($_POST['gallery_id']) {
        $gallery_id = $_POST['gallery_id'];
    } else {
        $gallery = new gallery(0, current_time('mysql'));
        $gallery_id = $gallery_bl->add_gallery($gallery);
        $gallery_bl->assign_gallery_to_item($item_id, $gallery_id);
    }
    if ($_POST['media_url']) {
        foreach ($_POST['media_url'] as $media_url) {
            $media = new media(0, $media_url);
            $media_id = $media_bl->add_media($media);
            $gallery_bl->assign_media_to_gallery($media_id, $gallery_id);
        }
    }
    foreach ($attributes as $attribute) {
        switch ($attribute->attribute_type) {
            case $attributes_types['text-box']:
                $value = $_POST['text_' . $languages['en'] . '_' . $attribute->id];
                $attribute_value = new attribute_value(0, $attribute->id, $value, 0, 0, 0);
                $attribute_exist = $items_bl->get_item_attribute_value($item_id, $attribute->id);
                if (isset($attribute_exist) && !empty($attribute_exist))
                    $items_bl->update_item_attribute_value($item_id, $attribute_value);
                else $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $value_lang = $_POST['text_' . $lang->id . '_' . $attribute->id];
                    $attribute_value = new attribute_value(0, $attribute->id, $value_lang, 0, 0, 0);
                    if (isset($attribute_exist) && !empty($attribute_exist))
                        $items_bl->update_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                    else $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['number']:
                $value = $_POST['number_' . $attribute->id];
                $attribute_value = new attribute_value(0, $attribute->id, $value, 0, 0, 0);
                $attribute_exist = $items_bl->get_item_attribute_value($item_id, $attribute->id);
                if (isset($attribute_exist) && !empty($attribute_exist))
                    $items_bl->update_item_attribute_value($item_id, $attribute_value);
                else
                    $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    if (isset($attribute_exist) && !empty($attribute_exist))
                        $items_bl->update_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                    else $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['check-box']:
                if ($_POST['check_' . $attribute->id] == 'on')
                    $value = $config_attribute_values['true'];
                else
                    $value = $config_attribute_values['false'];
                $attribute_value = new attribute_value($value, $attribute->id, 0, 0, 0, 0);
                $attribute_exist = $items_bl->get_item_attribute_value($item_id, $attribute->id);
                if (isset($attribute_exist) && !empty($attribute_exist))
                    $items_bl->update_item_attribute_value($item_id, $attribute_value);
                else $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    if (isset($attribute_exist) && !empty($attribute_exist))
                        $items_bl->update_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                    else $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['text-area']:
                $value = $_POST['textarea_' . $languages['en'] . '_' . $attribute->id];
                $attribute_value = new attribute_value(0, $attribute->id, $value, 0, 0, 0);
                $attribute_exist = $items_bl->get_item_attribute_value($item_id, $attribute->id);
                if (isset($attribute_exist) && !empty($attribute_exist))
                    $items_bl->update_item_attribute_value($item_id, $attribute_value);
                else $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $value_lang = $_POST['textarea_' . $lang->id . '_' . $attribute->id];
                    $attribute_value = new attribute_value(0, $attribute->id, $value_lang, 0, 0, 0);
                    if (isset($attribute_exist) && !empty($attribute_exist))
                        $items_bl->update_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                    else $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['drop-down']:
                $value = $_POST['dropdown_' . $attribute->id];
                $attribute_value = new attribute_value($value, $attribute->id, 0, 0, 0, 0);
                $attribute_exist = $items_bl->get_item_attribute_value($item_id, $attribute->id);
                if (isset($attribute_exist) && !empty($attribute_exist))
                    $items_bl->update_item_attribute_value($item_id, $attribute_value);
                else $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    if (isset($attribute_exist) && !empty($attribute_exist))
                        $items_bl->update_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                    else $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
        }
    }
    echo 'Done';
    echo '<meta http-equiv="refresh" content="0;URL=?page=item_manager" />';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit' && isset($_GET['item_id'])) {
    ?>
    <div class="container">
        <div style="overflow: auto;">
            <h2 class="listing-title">Edit Item</h2>
            <a class="anchor-add" href="admin.php?page=item_manager">Back</a>
        </div>
        <form id="edit_item" method="POST" name="edit_item">
            <input type="hidden" id="media_id" name="media_id" value="<?php echo $item->item[0]->media_id ?>">
            <input type="hidden" id="gallery_id" name="gallery_id" value="<?php echo $item->gallery[0]->gallery_id ?>">
            <label>Name :</label>
            <?php foreach ($lang_ids as $lang) {
                $item_lang = $items_bl->get_item_lang($item_id, $lang->id);
                ?>
                <input type="text" name="item_name_<?php echo $lang->id ?>"
                       placeholder="<?php echo $lang->name; ?> language" data-validation="required"
                       value="<?php echo $item_lang[0]->item_name ?>">
            <?php } ?>
            <hr/>
            <table class="wp-list-table page fixed widefat">
                <tbody>
                <tr class="tableRow alternate">
                    <th scope="row" style="width:150px;"><label>Featured</label></th>
                    <td>
                        <span class="Req_size">Recommended size .</span>

                        <div class="featured_holder">
                            <img class="featured_preview" style="display:block" src="<?php echo $feature_url; ?>"/>
                            <input type="button" value="Delete" class="delete-button delete_featured"/>
                            <input class="featured_url" type="text" name="featured_media" placeholder="Feature Image"
                                   readonly value="<?php echo $feature_url; ?>"/>
                            <input id="feature_button" class="button" type="button" value="Upload Featured"/>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr/>
            <table class="wp-list-table page fixed widefat">
                <tbody>
                <tr class="tableRow alternate">
                    <th scope="row" style="width:150px;"><label>Images</label></th>
                    <td>
                        <span class="Req_size">Recommended size .</span>

                        <div class="media_holder">
                            <?php foreach ($item->media as $media) { ?>
                                <div>
                                    <img class="img_preview" style="display:block"
                                         src="<?php echo $media->media_url ?>">
                                    <input id="<?php echo $media->id ?>" type="button" value="Delete"
                                           class="delete-button delete_media">
                                    <input class="img_url" type="text" name="old_media_url[]" placeholder="Image Url"
                                           readonly value="<?php echo $media->media_url ?>">
                                    <input type="button" value="change Image" class="change_img">
                                </div>
                            <?php } ?>
                        </div>
                        <input id="images_button" class="button" type="button" value="Upload Image"/>
                    </td>
                </tr>
                </tbody>
            </table>
            <hr/>
            <h3>Attributes :</h3>

            <?php foreach ($attributes as $attribute) { ?>
                <table class="wp-list-table page fixed widefat">
                    <tbody>
                    <tr class="tableRow alternate">
                        <?php
                        echo '<th scope="row" style="width:150px;"><label>' . $attribute->attribute_name . '</label></th>';
                        switch ($attribute->attribute_type) {
                            case $attributes_types['text-box']:
                                echo '<td>';
                                foreach ($lang_ids as $lang) {
                                    $attribute_value = $items_bl->get_item_attribute_value_lang($item_id, $attribute->id, $lang->id)[0];
                                    echo $lang->name . ' value <input type="text" value="' . $attribute_value->value_text . '" name="text_' . $lang->id . '_' . $attribute->id . '">';
                                }
                                echo '</td><br>';
                                break;
                            case $attributes_types['number']:
                                $attribute_value = $items_bl->get_item_attribute_value($item_id, $attribute->id)[0];
                                echo '<td><input type="text" value="' . $attribute_value->value_text . '" name="number_' . $attribute->id . '"></td><br>';
                                break;
                            case $attributes_types['check-box']:
                                $attribute_value = $items_bl->get_item_attribute_value($item_id, $attribute->id)[0];
                                $value = ($attribute_value->value_id == $config_attribute_values['true']) ? "checked" : "";
                                echo '<td><input type="checkbox" ' . $value . ' name="check_' . $attribute->id . '"></td><br>';
                                break;
                            case $attributes_types['text-area']:
                                echo '<td>';
                                foreach ($lang_ids as $lang) {
                                    $attribute_value = $items_bl->get_item_attribute_value_lang($item_id, $attribute->id, $lang->id)[0];
                                    echo '<textarea style="width: 50%" name="textarea_' . $lang->id . '_' . $attribute->id . '" placeholder="' . $lang->name . ' value">' . $attribute_value->value_text . '</textarea>';
                                }
                                echo '</td><br>';
                                break;
                            case $attributes_types['drop-down']:
                                $attribute_value = $items_bl->get_item_attribute_value($item_id, $attribute->id)[0];
                                echo '<td><select name="dropdown_' . $attribute->id . '"><option value="-1">select</option>';
                                $attribute_values = $attribute_bl->get_attribute_values($attribute->id);
                                foreach ($attribute_values as $value) {
                                    if ($value->id == $attribute_value->value_id)
                                        $is_selected = 'selected';
                                    else $is_selected = '';
                                    echo '<option ' . $is_selected . ' value="' . $value->id . '">' . $value->attribute_value . '</option>';
                                }
                                echo '</select></td><br>';
                                break;
                        }?>
                    </tr>
                    </tbody>
                </table>
            <?php
            }
            ?>
            <input type="submit" class="submit-button" name="edit_item" value="Update Item">
        </form>
    </div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=?page=item_manager" />';
}?>
<script type="text/javascript"> $.validate(); </script>