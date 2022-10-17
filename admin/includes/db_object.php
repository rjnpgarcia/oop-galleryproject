<?php

class Db_object
{
    //  Properties
    private static $db_table;
    private static $db_table_fields;

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
}
