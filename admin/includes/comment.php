<?php
class Comment extends Db_object
{
    // Properties for Database Fields
    protected static $db_table = "comments";
    protected static $db_table_fields = ['id', 'photo_id', 'author', 'content'];

    // Comment class properties
    public $id;
    public $photo_id;
    public $author;
    public $content;
    public $notification;

    // Create comment method
    public static function createComment($photo_id, $author, $content)
    {
        $comment = new Comment();
        if (!empty($comment) && !empty($author) && !empty($content)) {
            $comment->photo_id = $photo_id;
            $comment->author = $author;
            $comment->content = $content;

            return $comment;
        } else {
            return false;
        }
    }
} // End of Comment Class
