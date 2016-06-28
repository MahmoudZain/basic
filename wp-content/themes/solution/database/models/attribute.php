<?php

class attribute
{
    public $id;
    public $name;
    public $type;
    public $media_id;

    public function __construct($id, $name, $type, $media_id)
    {
        $this->id = $id;
        $this->name = $name;
        $this->type = $type;
        $this->media_id = $media_id;
    }
}