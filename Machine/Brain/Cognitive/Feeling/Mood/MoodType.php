<?php

class MoodType {

    public function __construct($moodTypeID) {
        $this->id = $moodTypeID;
        $this->brain = Brain::getInstance();
    }

    public function get($field) {
        $this->brain->setArea("mood_types");
        return $this->brain->selectSingle($field, "id", $this->id);
    }

    public function name() {

        return $this->get("name");
    }

    public static function moodTypeIDArray() {
        $brain = Brain::getInstance();
        return $brain->selectArray("id", "SELECT id FROM mood_types ORDER BY name");
    }

    public static function moodTypeForm($feelingID) {
        
        
        $html = "<form action ='index.php' method = 'POST' id='moodForm'>";
        $html.="On a scale of 1 - 10, how would you rate how the following mood states reflect your current feeling?"
                . " (1 being that you don't feel like that, 10 being you definitely do feel like that)<br/>";
        foreach(self::moodTypeIDArray() AS $moodTypeID){
        $MoodType = new MoodType($moodTypeID);   
        $html.="<strong>".$MoodType->name()."</strong></br>";
        $html.="<input type='text' name ='".$MoodType->id."' value =''><br/>";    
        }
        $html.="<input type='hidden' name ='newMoods'>";
        $html.="<input type='hidden' name ='feelingID' value = '$feelingID'>";
        $html.="</form>";
        $html.="<button type='submit'  form='moodForm' value='Submit'>Submit</button>";
        return $html;
        
        
    }

}
