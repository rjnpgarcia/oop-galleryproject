<?php
class Photo extends Db_object
{
    // Properties for Database Fields
    protected static $db_table = "photos";
    protected static $db_table_fields = ['title', 'caption', 'alternate_text', 'description', 'filename', 'type', 'size'];
    public $id;
    public $title;
    public $caption;
    public $alternate_text;
    public $description;
    public $filename;
    public $type;
    public $size;
    protected static $upload_directory = "images";
    protected $image_placeholder = "placeholder/placeholder1.png";
    public $notification;
} // End of Photo Class
