<?php

class Brain {

    private static $dbhost = 'localhost';
    private static $dbuser = 'root';
    private static $dbpass = '';
    private static $dbname = 'ai';

    public function __construct() {
        $this->mysqli = new mysqli(self::$dbhost, self::$dbuser, self::$dbpass, self::$dbname);
        if (mysqli_connect_errno()) {
            printf("Brain connection failed: %s\n", mysqli_connect_error());
            die();
        }
    }

    public function setArea($table) {
        $this->area = $table;
    }

    public static function getInstance() {
        if (!self::$singleDB) {
            self::$singleDB = new Database();
        }
        return self::$singleDB;
    }

    public function think($query) {

        $this->mysqli->query($query);
    }

    public function learn($insertArray) {

        $query = "INSERT INTO $this->area (";
        $count = count($insertArray);
        $c = 0;
        $valueArray = array();
        foreach ($insertArray AS $field => $value) {
            $c++;
            if ($c == $count) {
                $comma = "";
            } else {
                $comma = ",";
            }
            $query.= $field . $comma;
            $valueArray[] = $value;
        }
        $query.=") VALUES (";
        $c = 0;
        foreach ($valueArray AS $value) {
            $c++;
            if ($c == $count) {
                $comma = "";
            } else {
                $comma = ",";
            }
            $query.= "'" . $value . "'" . $comma;
        }
        $query.=")";
        echo $query;
        $this->mysqli->query($query);
    }

    public function delete($query) {

        $this->mysqli->query($query);
    }

    public function selectWhere($target, $whereStatement, $orderBYStatement = null) {
        $query = "SELECT $target FROM $this->area WHERE $whereStatement $orderBYStatement";
        $result = $this->query($query);
        $row = $result->fetch_assoc();
        return $row[$target];
    }

    public function selectSingle($target, $field, $value, $orderBYStatement = null) {
        $query = "SELECT $target FROM $this->area WHERE $field = '$value' $orderBYStatement";
        $result = $this->query($query);
        $row = $result->fetch_assoc();
        return $row[$target];
    }

    public function selectArray($target, $query) {
        $array = array();
        $result = $this->query($query);
        while ($row = $result->fetch_assoc()) {
            $array[] = $row[$target];
        }

        return $array;
    }

}
