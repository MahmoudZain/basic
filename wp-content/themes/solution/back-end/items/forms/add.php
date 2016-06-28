<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/media-uploader.js"></script>
<script src="<?php echo THEME_DIR; ?>/back-end/assets/js/jquery.form-validator.min.js"></script>
<?php
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
$user_id = 0;
$media_bl = new media_bl();
$items_bl = new items_bl();
$gallery_bl = new gallery_bl();
$attribute_bl = new attribute_bl();
$attributes = $attribute_bl->be_get_attributes_list($item_attributes);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_item'])) {
    $item_name = $_POST['item_name_' . $languages['en']];
    $feature_url = $_POST['featured_media'];
    $media_urls = $_POST['media_url'];
    if ($feature_url) {
        $media = new media(0, $feature_url);
        $media_id = $media_bl->add_media($media);
    } else {
        $media_id = 0;
    }
    $item = new item(0, $item_name, $media_id, 0);
    $item_id = $items_bl->add_item($item, $user_id);
    $gallery = new gallery(0, current_time('mysql'));
    $gallery_id = $gallery_bl->add_gallery($gallery);
    $gallery_bl->assign_gallery_to_item($item_id, $gallery_id);
    //add item lang
    foreach ($lang_ids as $lang_id) {
        $item_name = $_POST['item_name_' . $lang_id->id];
        $item = new item($item_id, $item_name, $media_id, 0);
        $items_bl->add_item_lang($item, $lang_id->id);
    }
    if ($media_urls) {
        foreach ($media_urls as $media_url) {
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
                $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $value_lang = $_POST['text_' . $lang->id . '_' . $attribute->id];
                    $attribute_value = new attribute_value(0, $attribute->id, $value_lang, 0, 0, 0);
                    $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['number']:
                $value = $_POST['number_' . $attribute->id];
                $attribute_value = new attribute_value(0, $attribute->id, $value, 0, 0, 0);
                $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['check-box']:
                if ($_POST['check_' . $attribute->id] == 'on')
                    $value = $config_attribute_values['true'];
                else
                    $value = $config_attribute_values['false'];
                $attribute_value = new attribute_value($value, $attribute->id, 0, 0, 0, 0);
                $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['text-area']:
                $value = $_POST['textarea_' . $languages['en'] . '_' . $attribute->id];
                $attribute_value = new attribute_value(0, $attribute->id, $value, 0, 0, 0);
                $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $value_lang = $_POST['textarea_' . $lang->id . '_' . $attribute->id];
                    $attribute_value = new attribute_value(0, $attribute->id, $value_lang, 0, 0, 0);
                    $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
            case $attributes_types['drop-down']:
                $value = $_POST['dropdown_' . $attribute->id];
                $attribute_value = new attribute_value($value, $attribute->id, 0, 0, 0, 0);
                $items_bl->add_item_attribute_value($item_id, $attribute_value);
                foreach ($lang_ids as $lang) {
                    $items_bl->add_item_attribute_value_lang($item_id, $attribute_value, $lang->id);
                }
                break;
        }
    }
    echo '<meta http-equiv="refresh" content="0;URL=?page=item_manager" />';
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
    ?>
    <div class="container">
        <div style="overflow: auto;">
            <h2 class="listing-title">Add new Item</h2>
            <a class="anchor-add" href="admin.php?page=item_manager">Back</a>
        </div>
        <form id="add_item" method="POST">
            <label>Name :</label>
            <?php foreach ($lang_ids as $lang) { ?>
                <input type="text" name="item_name_<?php echo $lang->id ?>"
                       placeholder="<?php echo $lang->name; ?> language" data-validation="required">
            <?php } ?>
            <hr/>
            <table class="wp-list-table page fixed widefat">
                <tbody>
                <tr class="tableRow alternate">
                    <th scope="row" style="width:150px;"><label>Featured</label></th>
                    <td>
                        <span class="Req_size">Recommended size .</span>

                        <div class="featured_holder">
                            <img class="featured_preview" style="display:block" src=""/>
                            <input type="button" value="Delete" class="delete-button delete_featured"/>
                            <input class="featured_url" type="text" name="featured_media" readonly
                                   placeholder="Feature Image"/>
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
                                    echo $lang->name . ' value <input type="text" name="text_' . $lang->id . '_' . $attribute->id . '">';
                                }
                                echo '</td><br>';
                                break;
                            case $attributes_types['number']:
                                echo '<td><input type="text" name="number_' . $attribute->id . '"></td><br>';
                                break;
                            case $attributes_types['check-box']:
                                echo '<td><input type="checkbox" name="check_' . $attribute->id . '"></td><br>';
                                break;
                            case $attributes_types['text-area']:
                                echo '<td>';
                                foreach ($lang_ids as $lang) {
                                    echo '<textarea style="width: 50%" name="textarea_' . $lang->id . '_' . $attribute->id . '" placeholder="' . $lang->name . ' value"></textarea>';
                                }
                                echo '</td><br>';
                                break;
                            case $attributes_types['drop-down']:
                                echo '<td><select name="dropdown_' . $attribute->id . '"><option value="-1">select</option>';
                                $attribute_values = $attribute_bl->get_attribute_values($attribute->id);
                                foreach ($attribute_values as $value) {
                                    echo '<option value="' . $value->id . '">' . $value->attribute_value . '</option>';
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
            <input type="submit" class="submit-button" name="create_item" value="Add Item">
        </form>
    </div>
<?php
} else {
    echo '<meta http-equiv="refresh" content="0;URL=?page=manager" />';
}
?>
<script type="text/javascript"> $.validate(); </script>