<?php
class Photo extends Db_object
{
    // Properties for Database Fields
    protected static $db_table = "photos";
    protected static $db_table_fields = ['title', 'caption', 'alternate_text', 'description', 'filename', 'type', 'size', 'view_count'];
    public $id;
    public $title;
    public $caption;
    public $alternate_text;
    public $description;
    public $filename;
    public $type;
    public $size;
    public $view_count;
    protected static $upload_directory = "images";
    protected $image_placeholder = "placeholder/placeholder1.png";
    public $notification;

    // Photo view count
    public static function viewCounter($photo_id)
    {
        global $database;
        return $database->query("UPDATE photos SET view_count = view_count + 1 WHERE id = $photo_id");
    }
} // End of Photo Class
