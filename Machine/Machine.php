<?php

class Machine {
    
    public function __construct() {
        echo "Welcome - I am an AI Machine - I like to learn and Interact.<p> I learn how to react to situations and people based on who interacts with me.<p>"
        . " Slowly but surely I am working out how"
        . " to think for myself. <p>You can help me do this by helping me learn how you think and feel about things as well as giving me knowledge about the world.<p> "
                . "The more you tell me, the more knowledgeable and personable I become.";
        $this->start();
    }
    
    
    public function start(){
        
        
        if(isset($_POST["newFeeling"])){
            
         Feeling::parseNewFeeling() ;  
        }
        
         if(isset($_POST["newMoods"])){
            
         Feeling::parseNewMoods() ;  
        }
        
        
        echo Feeling::ask();
    }
    
}

