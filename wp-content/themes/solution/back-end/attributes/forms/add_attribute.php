<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/media-uploader.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/jquery.form-validator.min.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/attributes/forms/script.js"></script>
<?php
include_once(THEME_PHYSICAL_DIR . '/database/bl/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/bl/media.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/attribute.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/attribute_value.php');
include_once(THEME_PHYSICAL_DIR . '/database/models/media.php');
include_once(THEME_PHYSICAL_DIR . '/common-files/config.php');

global $attributes_types;
global $languages;
global $lang_ids;
$media_bl = new media_bl();
$attribute_bl = new attribute_bl();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_attribute'])) {
    $attribute_name = $_POST['attribute_name_' . $languages['en']];
    $attribute_type = $_POST['type'];
    $attribute_img = $_POST['featured_media'];
    if ($attribute_img) {
        $media = new media(0, $attribute_img);
        $media_id = $media_bl->add_media($media);
    } else {
        $media_id = 0;
    }
    $attribute = new attribute(0, $attribute_name, $attribute_type, $media_id);
    $attribute_id = $attribute_bl->add_attribute($attribute);
    //add attribute lang
    foreach ($lang_ids as $lang_id) {
        $attribute_name = $_POST['attribute_name_' . $lang_id->id];
        $attribute = new attribute($attribute_id, $attribute_name, $attribute_type, $media_id);
        $attribute_bl->add_attribute_lang($attribute, $lang_id->id);
    }
    if ($attribute_type == $attributes_types['drop-down']) {
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

    echo '<meta http-equiv="refresh" content="0;URL=?page=attributes_manager" />';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    ?>
    <div class="container">
        <div style="overflow: auto;">
            <h2 class="listing-title">Add new attribute</h2>
            <a class="anchor-add" href="admin.php?page=attributes_manager">Back</a>
        </div>
        <form id="add_attribute" method="POST">
            <label>Name :</label>
            <?php foreach ($lang_ids as $lang) { ?>
                <input type="text" name="attribute_name_<?php echo $lang->id ?>"
                       placeholder="<?php echo $lang->name; ?> language" data-validation="required">
                <input name="lang_name[]" type="hidden" value="<?php echo $lang->name; ?>">
                <input name="lang_id[]" type="hidden" value="<?php echo $lang->id; ?>">
            <?php } ?>
            <hr/>
            <label>Type:</label><br>
            <input type="radio" name="type" checked value="<?php echo $attributes_types['text-box']; ?>"
                   onclick="hide_values()">Text box<br>
            <input type="radio" name="type" value="<?php echo $attributes_types['number']; ?>"
                   onclick="hide_values()">Number<br>
            <input type="radio" name="type" value="<?php echo $attributes_types['check-box']; ?>"
                   onclick="hide_values()">True / False<br>
            <input type="radio" name="type" value="<?php echo $attributes_types['drop-down']; ?>"
                   onclick="show_values()">Multi Select<br>
            <input type="radio" name="type" value="<?php echo $attributes_types['text-area']; ?>"
                   onclick="hide_values()">Text area<br>
            <hr/>


            <div class="attribute_values">
            </div>
            <hr/>
            <label>Attribute Media:</label>

            <div class="featured_holder">
                <img class="featured_preview" style="display:block" src=""/>
                <input type="button" value="Delete" class="delete-button delete_featured"/>
                <input class="featured_url" type="text" name="featured_media" readonly
                       placeholder="Feature Image"/>
                <input id="feature_button" class="button" type="button" value="Upload Featured"/>
            </div>
            <hr/>
            <input type="submit" class="submit-button" name="create_attribute" value="Add Attribute">
        </form>
    </div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=?page=attributes_manager" />';
}
?>
<script type="text/javascript"> $.validate(); </script>