<?php

class Feeling implements Emotion {

    public static $area = "feelings";

    public function __construct($feelingID) {
        $this->feelingID = $feelingID;
        $this->brain = Brain::getInstance();
        $this->moods();
    }

    public function moods() {

        return $this->moods = Mood::averageMoodTypePerFeelingArray($this->feelingID);
    }

    public function get($field) {

        return $this->brain->selectSingle($field, self::$area, "id", $this->feelingID);
    }

    public function name() {

        return $this->get("name");
    }

    public function addCount() {

        $newCount = $this->displayCount() + 1;
        $this->brain->update("UPDATE " . self::$area . " SET count = $newCount WHERE id = $this->feelingID");
    }

    public function displayCount() {

        return $this->get("count");
    }

    public function displayFeeling() {

        return $this->get("name");
    }

    public static function ask() {

        $html = "<form action ='index.php' method = 'POST' id='feelingForm'>";
        $html.="How are you feeling? ";
        $html.="<input type='text' name ='feeling'>";
        $html.="<input type='hidden' name ='newFeeling'>";
        $html.="</form>";
        $html.="<button type='submit'  form='feelingForm' value='Submit'>Submit</button>";
        return $html;
    }

    public static function IDFromName($name) {
        $brain = Brain::getInstance();

        return $brain->selectSingle("id", self::$area, "name", $name);
    }

    public static function parseNewFeeling() {

        $newFeeling = $_POST["feeling"];
        $brain = Brain::getInstance();

        $array = array("name" => $newFeeling);
        if (!$brain->checkExists(self::$area, $array)) {
            $brain->learn(self::$area, array("name" => $newFeeling));
            $feelingID = $brain->lastInsertID();
            echo"<p> The feeling ' $newFeeling '  is new to me...please tell me more.....";
            echo"<p>" . MoodType::moodTypeForm($feelingID);
        } else {
            $feeling = new Feeling(self::IDFromName($newFeeling));
            $feeling->addCount();
            echo"<p> Funny you should say that; " . $feeling->displayCount() . " people felt '" .
            $feeling->displayFeeling() . "' the same talking to me...please tell me a bit more...";
            echo"<p>" . MoodType::moodTypeForm($feeling->feelingID);
        }
    }

    public static function parseNewMoodsArray() {
        $brain = Brain::getInstance();
        $feelingID = $_POST["feelingID"];
        
       
        foreach ($_POST AS $key => $value) {

            if (is_numeric($key) && $value <= 10 && $value >= 1) {
                $brain->learn("moods", array("feeling_id" => $feelingID, "mood_type_id" => $key, "scale" => $value));
            }
        }
        echo"<p>Thanks, I have learnt more about feelings</p>";
        echo"<p>Now tell me about how you are feeling</p>";
        echo self::ask() . "</p>";
        
    }
    
    
       public static function parseNewMoods() {
        $brain = Brain::getInstance();
        $feelingID = $_POST["feelingID"];
        
       
        foreach ($_POST AS $key => $value) {

            if (is_numeric($key) && $value <= 10 && $value >= 1) {
                $brain->learn("moods", array("feeling_id" => $feelingID, "mood_type_id" => $key, "scale" => $value));
            }
        }
        echo"<p>Thanks, I have learnt more about feelings</p>";
     
        
    }

    public static function mostCommonFeelingID() {
        $brain = Brain::getInstance();
        return $brain->selectWhere("id", self::$area, "id > 0", " ORDER BY count DESC LIMIT 0,1");
    }

    public function mood() {
        
    }

}
