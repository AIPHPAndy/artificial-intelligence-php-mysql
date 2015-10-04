<?php

class MoodType {
    
    public static $area = "mood_types";

    public function __construct($moodTypeID) {
        $this->moodTypeID = $moodTypeID;
        $this->brain = Brain::getInstance();
    }

    public function get($field) {
   
        return $this->brain->selectSingle($field,self::$area, "id", $this->moodTypeID);
    }

    public function name() {

        return $this->get("name");
    }

    public static function moodTypeIDArray() {
        $brain = Brain::getInstance();
        
        return $brain->selectArray("id", "SELECT id FROM mood_types ORDER BY name");
    }

    public static function moodTypeForm($feelingID) {
        $feeling = new Feeling($feelingID);
        
        $html = "<form action ='index.php' method = 'POST' id='moodForm'>";
        $html.="On a scale of 1 - 10, how would you rate how feeling '".$feeling->name()."' reflects your mood state?"
                . " (1 being that you don't feel like that, 10 being you definitely do feel like that)<br/>";
        foreach(self::moodTypeIDArray() AS $moodTypeID){
        $MoodType = new MoodType($moodTypeID);   
        $html.="<strong>".$MoodType->name()."</strong></br>";
        $html.="<input type='text' name ='".$MoodType->moodTypeID."' value =''><br/>";    
        }
        $html.="<input type='hidden' name ='newMoods'>";
        $html.="<input type='hidden' name ='feelingID' value = '$feelingID'>";
        $html.="</form>";
        $html.="<button type='submit'  form='moodForm' value='Submit'>Submit</button>";
        return $html;
        
        
    }
    
        public static function moodTypeArrayForm($feelingID,$moodTypeArray) {
        $feeling = new Feeling($feelingID);
        
        $html = "<form action ='index.php' method = 'POST' id='moodArrayForm'>";
        $html.="If you were feeling ".$feeling->name().", on a scale of 1 - 10, how would you rate how the following "
                . "mood states reflected your feeling?"
                . " (1 being that you don't feel like that, 10 being you definitely do feel like that)<br/>";
        foreach($moodTypeArray AS $moodTypeID => $currentAverageScale){
        $MoodType = new MoodType($moodTypeID);   
        $html.="<strong>".$MoodType->name()."</strong></br>";
        $html.="<input type='text' name ='".$MoodType->moodTypeID."' value ='$currentAverageScale'><br/>";    
        }
        $html.="<input type='hidden' name ='newMoodsArray'>";
        $html.="<input type='hidden' name ='feelingID' value = '$feelingID'>";
        $html.="</form>";
        $html.="<button type='submit'  form='moodArrayForm' value='Submit'>Submit</button>";
        return $html;
        
        
    }

}
