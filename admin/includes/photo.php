<?php
class Photo extends Db_object
{
    // Properties for Database Fields
    protected static $db_table = "photos";
    protected static $db_table_fields = ['photo_id', 'title', 'description', 'filename', 'type', 'size'];
    public $photo_id;
    public $title;
    public $description;
    public $filename;
    public $type;
    public $size;

    // Properties for Uploads and Errors
    public $tmp_path; // Temporary path
    public $upload_directory = "images";
    public $errors = [];
    public $uploadErrorsArray = [
        UPLOAD_ERR_OK => "There is no error",
        UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive",
        UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the max_file_size",
        UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded",
        UPLOAD_ERR_NO_FILE => "No file was uploaded",
        UPLOAD_ERR_NO_TMP_DIR => "Missing temporary folder",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk",
        UPLOAD_ERR_EXTENSION => "A PHP Extension stopped the file upload"
    ];

    // Passing $_FILES['uploaded_file'] as an arguement
    public function set_file($file)
    {
        if (empty($file) || !$file || !is_array($file)) {
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif ($file['error'] != 0) {
            $this->error[] = $this->uploadErrorsArray[$file['error']];
            return false;
        } else {
            $this->filename = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type = $file['type'];
            $this->size = $file['size'];
        }
    }

    // Uploaded picture path
    public function picturePath()
    {
        return $this->upload_directory . DS . $this->filename;
    }

    // Create/Update Photos
    public function savePhoto()
    {
        if ($this->photo_id) {
            $this->update();
        } else {
            if (!empty($this->errors)) {
                return false;
            }

            if (empty($this->filename) || empty($this->tmp_path)) {
                $this->errors[] = "The file was not available";
                return false;
            }
            $targetPath = SITE_ROOT . DS . 'admin' . DS . "$this->upload_directory" . DS . "$this->filename";

            if (file_exists($targetPath)) {
                $this->errors[] = "The filename $this->filename already exists";
                return false;
            }

            if (move_uploaded_file($this->tmp_path, $targetPath)) {
                if ($this->create()) {
                    unset($this->tmp_path);
                    return true;
                }
            } else {
                $this->errors[] = "File cannot be saved in directory";
                return false;
            }
        }
    }
} // End of Photo Class
