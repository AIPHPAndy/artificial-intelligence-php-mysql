<?php

class Mood implements Emotion {

    public static $area = "moods";

    public static function averageMoodTypePerFeelingArray($feelingID) {
        $array = array();
        foreach (MoodType::moodTypeIDArray() AS $moodTypeID) {
            
            @$array[$moodTypeID] = self::totalScaleMoodTypeAndFeeling($moodTypeID, $feelingID) / self::totalRowsMoodTypeAndFeeling($moodTypeID, $feelingID);
        }
        
        return $array;
    }

    public static function totalRowsMoodTypeAndFeeling($moodTypeID, $feelingID) {
        $brain = Brain::getInstance();
        $result = $brain->think("SELECT id FROM " . self::$area . " WHERE mood_type_id = $moodTypeID AND feeling_id = $feelingID");
        return $result->num_rows;
    }

    public static function totalScaleMoodTypeAndFeeling($moodTypeID, $feelingID) {
        $brain = Brain::getInstance();
        $result = $brain->think("SELECT sum(scale) FROM " . self::$area . " WHERE mood_type_id = $moodTypeID AND feeling_id = $feelingID");
        $row = mysqli_fetch_row($result);
        return $row[0];
    }

    public function mood() {
        
    }

}
