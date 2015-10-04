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

    

    public static function getInstance() {
        if (!self::$singleDB) {
            self::$singleDB = new Brain();
        }
        return self::$singleDB;
    }

    public function think($query) {

        return $this->mysqli->query($query);
    }

    public function checkExists($table,$whereArray) {

        $whereStatement = "";
        foreach ($whereArray AS $field => $value) {

            $whereStatement.=$field . " = '$value'";
        }

        if ($this->selectWhere("id",$table, $whereStatement)) {
         
            return true;
        } else {
            
            return false;
        }
    }

    public function learn($table,$insertArray) {

        $query = "INSERT INTO $table (";
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

    public function selectWhere($target, $table, $whereStatement, $orderBYStatement = null) {
        $query = "SELECT $target FROM $table WHERE $whereStatement $orderBYStatement";
        //echo "<br/>".$query."<br/>";
        $result = $this->think($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
              return $row[$target];
        } else {
            return null;
        }
    }

    public function selectSingle($target, $table, $field, $value, $orderBYStatement = null) {
        $query = "SELECT $target FROM $table WHERE $field = '$value' $orderBYStatement";
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
