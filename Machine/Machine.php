<?php

class Machine {

    public function __construct() {
        echo "Welcome - I am an AI Machine - I like to learn and Interact.<p> I learn how to react to situations and people "
        . "based on who interacts with me.<p>"
        . " Slowly but surely I am working out how"
        . " to think and feel for myself. "
        . "<p>You can help me do this by telling me how you think and feel about things as well as giving me knowledge about the world.<p> "
        . "The more you tell me, the more knowledgeable and personable I become.";
        $this->start();
    }

    public function start() {

        if (isset($_POST) && count($_POST) > 0) {

            if (isset($_POST["newFeeling"])) {

                Feeling::parseNewFeeling();
            }

            if (isset($_POST["newMoodsArray"])) {

                Feeling::parseNewMoodsArray();
            }
            
             if (isset($_POST["newMoods"])) {

                Feeling::parseNewMoods();
            }
        } else {

            $this->feelingID = Feeling::mostCommonFeelingID();
            $feeling = new Feeling($this->feelingID);
            echo "<p>I am feeling " . $feeling->name() . "</p><p>";
            echo "<p>On average, humans who are feeling " . $feeling->name() . " have the mood characteristics below:</p>";
            echo "<p>";
            echo MoodType::moodTypeArrayForm($this->feelingID, $feeling->moods);
            echo $feeling->overallMoodValue();
        }
    }

}
