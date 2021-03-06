<?php



/**
 * Keyword.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Registration as definited in the model
 * 
 */
class Keyword {
    
    
    
    /**
     * Keyword's value
     * @var type string
     */
    private $value; 
    
    
    /**
     * Keyword's eventNo
     * @var type int
     */
    private $eventNo; 
    
    
    /**
     * Keyword's participantPersonNo
     * @var type int participantPersonNo
     */
    private $personNo; 
    
    
    /**
     * Keyword's isArchived
     * @var type boolean
     */
    private $isArchived; 
    
    
    
    
    /**
     * Constructs object Keyword
     * 
     * @param type $array of parameters that correspond to the classes properties
     */
    public function __construct($array = null){
        
        if(!is_array($array)) {
            throw new Exception('No parameters');
            
        }//if
        $this->value = $array['value']; 
        $this->eventNo = $array['eventNo']; 
        $this->personNo = $array['personNo']; 
        $this->isArchived = $array['isArchived']; 
       
    }//construct
    
    /**
     * get value
     * @return type string value
     */
    public function getValue() {
        return $this->value; 
    }//function
    
    
    /**
     * get eventNo
     * @return type int eventNo
     */
    public function getEventNo() {
        return $this->eventNo; 
    }//function
    
    
    /**
     * get participantPersonNo
     * @return type int participantPersonNo
     */
    public function getPersonNo() {
        return $this->personNo; 
    }//function
    
    
    /**
     * get isArchived
     * @return type boolean is Archived
     */
    public function getIsArchived() {
        return $this->isArchived; 
    }//function
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    public function setIsArchived($isArchived) {
        $this->isArchived = $isArchived; 
    }//function
    
    
    
    
}//class
?>
