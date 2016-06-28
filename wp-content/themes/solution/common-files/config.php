<?php
global $languages;
$languages = array(
    'en' => 1,
    'ar' => 2
);

global $lang_ids;
$lang_ids = array();
$lang_obj = new stdClass();
$lang_obj->id = 1;
$lang_obj->name = 'english';
$lang_ids[] = $lang_obj;
$lang_obj = new stdClass();
$lang_obj->id = 2;
$lang_obj->name = 'arabic';
$lang_ids[] = $lang_obj;

global $attributes_types;
$attributes_types = array(
    'text-box' => 1,
    'check-box' => 2,
    'drop-down' => 3,
    'text-area' => 4,
    'number' => 5,
    1 => 'Text-Box',
    2 => 'Check-Box',
    3 => 'Multi-Select',
    4 => 'Text-Area',
    5 => 'number'
);
global $config_attribute_values;
$config_attribute_values = array(
    'true' => 1,
    'false' => 0
);
global $attribute;
$attribute = array(
    'capital' => 4,
    'population' => 5,
    'area' => 6,
    'official-language' => 7,
    'landlocked' => 8,
    'continent' => 9,
    'description' => 10,
    'gdp' => 11,
);

global $item_attributes;
$item_attributes = array(
    $attribute['capital'],
    $attribute['population'],
    $attribute['area'],
    $attribute['official-language'],
    $attribute['landlocked'],
    $attribute['continent'],
    $attribute['description'],
    $attribute['gdp'],
);