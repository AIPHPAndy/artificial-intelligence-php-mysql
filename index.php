<?php




///LOAD ALL CLASSES AND INTERFACES - please keep in alphabetical order


//BRAIN
require_once("Machine/Brain/Brain.php");


//Actions
// - communication (CLASSES)
require_once("Machine/Brain/Actions/Communication/Communication.php");
require_once("Machine/Brain/Actions/Communication/Expression.php");
require_once("Machine/Brain/Actions/Communication/Gesticulation.php");
require_once("Machine/Brain/Actions/Communication/Listening.php");
require_once("Machine/Brain/Actions/Communication/Talking.php");
// - movement (CLASSES)
require_once("Machine/Brain/Actions/Movement/Movement.php");
// - rest (CLASSES)
require_once("Machine/Brain/Actions/Rest/Rest.php");
require_once("Machine/Brain/Actions/Rest/Sleep.php");




//Areas of the Brain (CLASSES)
require_once("Machine/Brain/BrainAreas/Brainstem/Brainstem.php");
require_once("Machine/Brain/BrainAreas/Cerebellum/Cerebellum.php");
require_once("Machine/Brain/BrainAreas/FrontalLobe/FrontalLobe.php");
require_once("Machine/Brain/BrainAreas/OccipitalLobe/OccipitalLobe.php");
require_once("Machine/Brain/BrainAreas/ParietalLobe/ParietalLobe.php");
require_once("Machine/Brain/BrainAreas/TemporalLobe/TemporalLobe.php");


//Cognitive Abilities  (CLASSES)
require_once("Machine/Brain/Cognitive/Feeling/Feeling.php");
require_once("Machine/Brain/Cognitive/Language/Language.php");
require_once("Machine/Brain/Cognitive/Learning/Learning.php");
require_once("Machine/Brain/Cognitive/Planning/Planning.php");
require_once("Machine/Brain/Cognitive/Remembering/Remembering.php");
require_once("Machine/Brain/Cognitive/Resourcing/Resourcing.php");
require_once("Machine/Brain/Cognitive/Sensing/Sensing.php");
require_once("Machine/Brain/Cognitive/Visualising/Visualising.php");

//Core  (INTERFACES)
// - Conscious
require_once("Machine/Brain/Core/Conscious/Conscious.php");
require_once("Machine/Brain/Core/Conscious/Emotion.php");
require_once("Machine/Brain/Core/Conscious/Logic.php");
require_once("Machine/Brain/Core/Conscious/Memory.php");
// - Subconscious
require_once("Machine/Brain/Core/Subconscious/AutonomicNervousSystem/Parasympathetic/Parasympathetic.php");
require_once("Machine/Brain/Core/Subconscious/AutonomicNervousSystem/Sympathetic/Sympathetic.php");

//Senses (INTERFACES)
require_once("Machine/Brain/Senses/Sight.php");
require_once("Machine/Brain/Senses/Smell.php");
require_once("Machine/Brain/Senses/Sound.php");
require_once("Machine/Brain/Senses/Taste.php");
require_once("Machine/Brain/Senses/Touch.php");



//BODY
require_once("Machine/Body/Body.php");







////THIS HAS TO BE LOADED LAST
///Full AI Machine (CLASS)
require_once("Machine/Machine.php");


$machine = new Machine();


