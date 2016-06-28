<?php

class attribute_value
{
    public $id;
    public $attribute_id;
    public $value;
    public $order;
    public $parent_id;
    public $media_id;

    public function __construct($id, $attribute_id, $value, $order, $parent_id, $media_id)
    {
        $this->id = $id;
        $this->attribute_id = $attribute_id;
        $this->value = $value;
        $this->order = $order;
        $this->parent_id = $parent_id;
        $this->media_id = $media_id;
    }
}