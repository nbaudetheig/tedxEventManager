<?php


/**
 * Event.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Event as definited in the model
 * 
 */
class Event {
    
     
    /**
     * Event's numero
     * @var type int
     */
    private $no; 
    
    
    /**
     * Event's mainTopic
     * @var type string
     */
    private $mainTopic; 
    
    
    /**
     * Event's starting date
     * @var type date
     */
    private $startingDate; 
    
    
    /**
     * Event's ending date
     * @var type date
     */
    private $endingDate; 
    
    
    /**
     * Event's starting time
     * @var type time
     */
    private $startingTime; 
    
    
    /**
     * Event's ending time
     * @var type time
     */
    private $endingTime; 
    
    
    /**
     * Event's isArchived 
     * @var type boolean
     */
    private $isArchived; 
    
    
    /**
     * Event's maxParticipant
     * @var type int
     */
    private $maxParticipant; 
    


    
    /**
     * Constructs object Event
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->no = $array['no']; 
        $this->mainTopic = $array['mainTopic']; 
        $this->startingDate = $array['startingDate']; 
        $this->endingDate = $array['endingDate'];
        $this->startingTime = $array['startingTime']; 
        $this->endingTime = $array['endingTime']; 
        $this->isArchived = $array['isArchived']; 
        $this->maxParticipant = $array['maxParticipant']; 
    

        
    }//construct
    
    
    
    
    
    
    /**
     * get numero
     * @return type int numero
     */
    public function getNo() {
        return $this->no; 
    }
    
    
    /**
     * get mainTopic
     * @return type string mainTopic
     */
    public function getMainTopic() {
        return $this->mainTopic; 
    }
    
    
    /**
     * set mainTopic 
     * @param type $mainTopic 
     */
    public function setMainTopic($mainTopic) {
        $this->mainTopic = $mainTopic; 
    }
    
    
    /**
     * get startingDate
     * @return type date startingDate
     */
    public function getStartingDate() {
        return $this->startingDate; 
    }
    
    
    /**
     * set startingDate
     * @param type $startingDate 
     */
    public function setStartingDate($startingDate) {
        $this->startingDate = $startingDate; 
    }
    
    
    /**
     * get endingDate
     * @return type date endingDate
     */
    public function getEndingDate() {
        return $this->endingDate; 
    }
    
    
    /**
     * set endingDate
     * @param type $endingDate 
     */
    public function setEndingDate($endingDate) {
        $this->endingDate = $endingDate; 
    }
    
    
    /**
     * get startingTime
     * @return type time startingTime
     */
    public function getStartingTime() {
        return $this->startingTime; 
    }
    
    
    /**
     * set startingTime
     * @param type $startingTime 
     */
    public function setStartingTime($startingTime) {
        $this->startingTime = $startingTime; 
    }
    
    
    /**
     * get EndingTime
     * @return type endingTime
     */
    public function getEndingTime() {
        return $this->endingTime; 
    }
    
    
    /**
     * set endingTime
     * @param type $endingTime 
     */
    public function setEndingTime($endingTime) {
        $this->endingTime = $endingTime; 
    }
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }
    
    
    /**
     * get maxParticipant
     * @return type int maxParticipantbb
     */
    public function getMaxParticipant() {
        return $this->maxParticipant; 
    }
    
    
    /**
     * set maxParticipant
     * @param type $maxParticipant 
     */
    public function setMaxParticipant($maxParticipant) {
        $this->maxParticipant = $maxParticipant; 
    }
    
    
}//class
?>