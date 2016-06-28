<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/media-uploader.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/attributes/forms/script.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/jquery.form-validator.min.js"></script>
<?php
/**
 * Created by PhpStorm.
 * User: ZAIN
 * Date: 3/27/2016
 * Time: 4:08 AM
 */

include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/media.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/attribute_value.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/media.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');

global $attributes_types;
global $languages;
global $lang_ids;
$attribute_bl = new attribute_bl();
$media_bl = new media_bl();
$attribute_id = $_GET['attribute_id'];
$attribute = $attribute_bl->get_attribute_by_id($attribute_id)[0];
$feature_url = $media_bl->get_image_by_media_id($attribute->media_id);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_attribute'])) {
    $name = $_POST['attribute_name_' . $languages['en']];
    if (isset($_POST['media_id']) && $_POST['media_id'] > 0) {
        $media_id = $_POST['media_id'];
    } elseif (isset($_POST['featured_media'])) {
        $new_media = new media(0, $_POST['featured_media']);
        $media_id = $media_bl->add_media($new_media);
    } else {
        $media_id = 0;
    }
    $attribute_obj = new attribute($attribute_id, $name, $attribute->attribute_type, $media_id);
    $attribute_bl->update_attribute($attribute_obj);
    foreach ($lang_ids as $lang) {
        $name = $_POST['attribute_name_' . $lang->id];
        $attribute_obj = new attribute($attribute_id, $name, $attribute->attribute_type, $media_id);
        $attribute_bl->update_attribute_lang($attribute_obj, $lang->id);
    }
    if ($media_id > 0) {
        $feature_media = new media($media_id, $_POST['featured_media']);
        $media_bl->update_media($feature_media);
    }
    if ($_POST['old_order']) {
        $index = 0;
        foreach ($_POST['old_order'] as $old_order) {
            $attribute_value = $_POST['old_attribute_value_' . $languages['en']][$index];
            $attribute_value_obj = new attribute_value($_POST['attr_value_id'][$index], $attribute_id, $attribute_value, $old_order, 0, 0);
            $attribute_bl->update_attribute_value($attribute_value_obj);
            foreach ($lang_ids as $lang) {
                $attribute_value_lang = $_POST['old_attribute_value_' . $lang->id][$index];
                $attribute_value_lang_obj = new attribute_value($_POST['attr_value_id'][$index], $attribute_id, $attribute_value_lang, $old_order, 0, 0);
                $attribute_bl->update_attribute_value_lang($attribute_value_lang_obj, $lang->id);
            }
            $index++;
        }
    }
    if ($_POST['order']) {
        $order = $_POST['order'];
        $value = $_POST['attribute_value_' . $languages['en']];
        for ($index = 0; $index < count($order); $index++) {
            $attribute_value = new attribute_value(0, $attribute_id, $value[$index], $order[$index], 0, 0);
            $attribute_value_id = $attribute_bl->add_attribute_value($attribute_value);
            foreach ($lang_ids as $lang_id) {
                $value_lang = $_POST['attribute_value_' . $lang_id->id][$index];
                $attribute_value_lang = new attribute_value($attribute_value_id, $attribute_id, $value_lang, $order[$index], 0, 0);
                $attribute_bl->add_attribute_value_lang($attribute_value_lang, $lang_id->id);
            }
        }
    }
    echo 'Done';
    echo '<meta http-equiv="refresh" content="0;URL=?page=attributes_manager" />';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && $_GET['action'] == 'edit' && isset($_GET['attribute_id'])) {
    ?>
    <div class="container">
        <div style="overflow: auto;">
            <h2 class="listing-title">Edit Attribute</h2>
            <a class="anchor-add" href="admin.php?page=attributes_manager">Back</a>
        </div>
        <form id="edit_attribute" method="POST" name="edit_attribute">
            <input type="hidden" id="media_id" name="media_id" value="<?php echo $attribute->media_id; ?>">
            <label>Name :</label>
            <?php foreach ($lang_ids as $lang) {
                $attribute_lang = $attribute_bl->get_attribute_lang($attribute_id, $lang->id);
                ?>
                <input type="text" name="attribute_name_<?php echo $lang->id ?>"
                       placeholder="<?php echo $lang->name; ?> language" data-validation="required"
                       value="<?php echo $attribute_lang[0]->attribute_name ?>">
                <input name="lang_name[]" type="hidden" value="<?php echo $lang->name; ?>">
                <input name="lang_id[]" type="hidden" value="<?php echo $lang->id; ?>">
            <?php } ?>
            <?php if ($attribute->attribute_type == $attributes_types['drop-down']) {
                $attribute_values = $attribute_bl->get_attribute_values($attribute_id);
                ?>
                <hr/>
                <div class="attribute_values"><label>Attribute values:</label>
                    <?php foreach ($attribute_values as $attribute_value) { ?>
                        <div class="attr_value">
                            <label>order: </label>
                            <input type="text" name="old_order[]" style="width: 4%;"
                                   data-validation="required" value="<?php echo $attribute_value->order; ?>">
                            <input type="hidden" name="attr_value_id[]" value="<?php echo $attribute_value->id; ?>">
                            <?php foreach ($lang_ids as $lang) {
                                $attribute_value_lang = $attribute_bl->get_attribute_values_lang($attribute_value->id, $lang->id)[0];
                                ?>
                                <label> <?php echo $lang->name; ?> value: </label>
                                <input type="text" name="old_attribute_value_<?php echo $lang->id; ?>[]"
                                       data-validation="required"
                                       value="<?php echo $attribute_value_lang->attribute_value; ?>">
                            <?php } ?>
                            <input id="<?php echo $attribute_value->id; ?>" type="button" value="Delete"
                                   class="delete-button delete-value value_<?php echo $attribute_value->id; ?>">
                            <br>
                        </div>
                    <?php } ?>
                    <input id="add_value" type="button" value="Add" class="button" onclick="add_val()"></div>
            <?php } ?>
            <hr/>
            <label>Attribute Media:</label>

            <div class="featured_holder">
                <img class="featured_preview" style="display:block" src="<?php echo $feature_url; ?>"/>
                <input type="button" value="Delete" class="delete-button delete_featured"/>
                <input class="featured_url" type="text" name="featured_media" readonly
                       value="<?php echo $feature_url; ?>" placeholder="Feature Image"/>
                <input id="feature_button" class="button" type="button" value="Upload Featured"/>
            </div>
            <hr/>
            <input type="submit" class="submit-button" name="edit_attribute" value="Update Attribute">
        </form>
    </div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=?page=attributes_manager" />';
}?>
<script type="text/javascript"> $.validate(); </script>