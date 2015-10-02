<?php

class Brain {

    public static $singleDB;
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
            self::$singleDB = new Brain();
        }
        return self::$singleDB;
    }

    public function think($query) {

        return $this->mysqli->query($query);
    }

    public function checkExists($whereArray) {

        $whereStatement = "";
        foreach ($whereArray AS $field => $value) {

            $whereStatement.=$field . " = '$value'";
        }

        if ($this->selectWhere("id", $whereStatement)) {
         
            return true;
        } else {
            
            return false;
        }
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
        //echo $query;
        $this->mysqli->query($query);
    }

    public function delete($query) {

        $this->mysqli->query($query);
    }

    public function selectWhere($target, $whereStatement, $orderBYStatement = null) {
        $query = "SELECT $target FROM $this->area WHERE $whereStatement $orderBYStatement";
        //echo "<br/>".$query."<br/>";
        $result = $this->think($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
              return $row[$target];
        } else {
            return null;
        }
    }

    public function selectSingle($target, $field, $value, $orderBYStatement = null) {
        $query = "SELECT $target FROM $this->area WHERE $field = '$value' $orderBYStatement";
        //echo $query;
      
        $result = $this->think($query);
        $row = $result->fetch_assoc();
        return $row[$target];
    }

    public function selectArray($target, $query) {
        $array = array();
        $result = $this->think($query);
        while ($row = $result->fetch_assoc()) {
            $array[] = $row[$target];
        }

        return $array;
    }
    
    public function update($query){
        
        $this->think($query);
    }
    
    public function lastInsertID(){
        
        return $this->mysqli->insert_id;
    }

}
