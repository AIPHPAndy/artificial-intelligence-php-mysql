<?php

class Feeling implements Emotion {

    public static $area = "feelings";

    public function __construct($feelingID) {
        $this->id = $feelingID;
        $this->brain = Brain::getInstance();
        $this->brain->setArea("feelings");
    }

    public function get($field) {

        return $this->brain->selectSingle($field, "id", $this->id);
    }

    public function addCount() {

        $newCount = $this->displayCount() + 1;
        $this->brain->update("UPDATE " . self::$area . " SET count = $newCount WHERE id = $this->id");
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
        $brain->setArea("feelings");
        return $brain->selectSingle("id", "name", $name);
    }

    public static function parseNewFeeling() {

        $newFeeling = $_POST["feeling"];
        $brain = Brain::getInstance();
        $brain->setArea("feelings");
        $array = array("name" => $newFeeling);
        if (!$brain->checkExists($array)) {
            $brain->learn(array("name" => $newFeeling));
            $feelingID = $brain->lastInsertID();
            echo"<p> The feeling ' $newFeeling '  is new to me...please tell me more.....";
            echo"<p>" . MoodType::moodTypeForm($feelingID);
        } else {
            $feeling = new Feeling(self::IDFromName($newFeeling));
            $feeling->addCount();
            echo"<p> Funny you should say that; " . $feeling->displayCount() . " people felt '" . $feeling->displayFeeling() . "' the same talking to me";
            echo"<p> When they felt " . $feeling->displayFeeling() . ", on average they felt like this....";
        }
    }

    public static function parseNewMoods() {
        $brain = Brain::getInstance();
        $brain->setArea("moods");
        $feelingID = $_POST["feelingID"];
        foreach ($_POST AS $key => $value) {

            if (is_numeric($key)) {
                $brain->learn(array("feeling_id" => $feelingID, "mood_type_id" => $key, "scale" => $value));
            }
        }
        
        echo"<p>Thanks, I have learnt something about feelings";
    }

    public function mood() {
        
    }

}
