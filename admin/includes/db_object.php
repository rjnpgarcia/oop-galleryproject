<?php

class Db_object
{
    //  Properties
    private static $db_table;
    private static $db_table_fields;
    private static $upload_directory = "images";
    protected $image_placeholder = "placeholder/placeholder1.png";
    public $notification;

    // Properties for Uploads and Errors
    public $tmp_path; // Temporary path
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

    // Read Query
    public static function findThisQuery($sql)
    {
        global $database;
        $result = $database->query($sql);
        $objectArray = [];
        while ($row = mysqli_fetch_array($result)) {
            $objectArray[] = static::instantiation($row);
        }
        return $objectArray;
    }

    // to check if the attribute in table exists
    private function checkAttribute($attribute)
    {
        $objectProperties = get_object_vars($this);
        return array_key_exists($attribute, $objectProperties);
    }

    // for instantiation - will return each attribute to object
    public static function instantiation($record)
    {
        $object = new static;
        foreach ($record as $attribute => $value) {
            if ($object->checkAttribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    // Read ALL user columns
    public static function findAll()
    {
        $table = static::$db_table;
        return static::findThisQuery("SELECT * FROM $table");
    }

    // Read ALL user columns (descending order)
    public static function findAllDescOrder()
    {
        $table = static::$db_table;
        return static::findThisQuery("SELECT * FROM $table ORDER BY id DESC");
    }

    // Read by ID
    public static function findById($id)
    {
        $table = static::$db_table;
        $result = self::findThisQuery("SELECT * FROM $table WHERE id=$id LIMIT 1");
        return $result[0];
        // OR
        // return !empty($foundUser) ? array_shift($foundUser) : false;
    }

    // Get Table Properties
    protected function properties()
    {
        $properties = [];
        foreach (static::$db_table_fields as $db_field) {
            if (property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }

    // Escape/Clean properties
    protected function cleanProperties()
    {
        global $database;
        $properties = $this->properties();
        $cleanProperties = [];
        foreach ($properties as $key => $value) {
            $cleanProperties[$key] = $database->escape($value);
        }
        return $cleanProperties;
    }

    //  CREATE
    public function create()
    {
        global $database;
        $properties = $this->cleanProperties();
        $columns = implode(",", array_keys($properties));
        $values = implode("','", array_values($properties));
        $table = static::$db_table;
        $sql = "INSERT INTO $table ($columns) VALUES ('$values')";

        if ($database->query($sql)) {
            $this->id = $database->insertId();
            return true;
        } else {
            return false;
        }
    }

    // UPDATE
    public function update()
    {
        global $database;
        $table = static::$db_table;
        $properties = $this->cleanProperties();
        $propertyPair = [];
        foreach ($properties as $key => $values) {
            $propertyPair[] = "$key = '$values'";
        }

        $updateSetValues = implode(", ", $propertyPair);
        $sql = "UPDATE $table SET $updateSetValues WHERE id=$this->id";

        $database->query($sql);
        return mysqli_affected_rows($database->connection) === 1 ? true : false;
    }

    //  DELETE
    public function delete()
    {
        global $database;
        $id = $database->escape($this->id);
        $table = static::$db_table;
        $sql = "DELETE FROM $table WHERE id=$id LIMIT 1";
        $database->query($sql);
        return mysqli_affected_rows($database->connection) === 1 ? true : false;
    }

    // Abstaction for Create/Update Method
    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    // ##### Methods for photo upload and delete #######

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
        $placeholder = "images" . DS . $this->image_placeholder;
        $image = static::$upload_directory . DS . $this->filename;
        return empty($this->filename) ? $placeholder : $image;
    }

    // Create/Update Photos
    public function saveDataPhoto()
    {
        if (!empty($this->errors)) {
            return false;
        }

        if (empty($this->filename) || empty($this->tmp_path)) {
            $this->errors[] = "The file was not available";
            return false;
        }
        $targetPath = SITE_ROOT . DS . 'admin' . DS . static::$upload_directory . DS . $this->filename;

        if (file_exists($targetPath)) {
            $this->errors[] = "The filename $this->filename already exists";
            return false;
        }

        if (move_uploaded_file($this->tmp_path, $targetPath)) {
            if ($this->save()) {
                unset($this->tmp_path);
                return true;
            }
        } else {
            $this->errors[] = "File cannot be saved in directory";
            return false;
        }
    }

    // Delete Photo in database and images folder
    public function deletePhoto()
    {
        if ($this->delete()) {
            $targetPath = SITE_ROOT . DS . 'admin' . DS . static::$upload_directory . DS . $this->filename;
            return unlink($targetPath) ? true : false;
        } else {
            return false;
        }
    }


    // Status notification
    public function statusNotification()
    {
        echo !empty($this->notification) ? $this->notification : "";
    }

    // Data count
    public static function dataCount()
    {
        $data = static::findAll();
        $result = count($data);
        return $result;
    }
}
