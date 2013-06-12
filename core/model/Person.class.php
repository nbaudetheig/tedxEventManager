<?php
/**
 * Person.class.php
 * 
 * Author : Guillaume Lehmann
 * Date : 05.06.2013
 * 
 * Description : define the class Person as described in the model
 * 
 */
class Person {
    
      
    /**
     * Person's id number
     * @var int
     */
   protected $no; 
   
   
   /**
    * Person's name 
    * @var string
    */
   protected $name; 
   
   
   /**
    * Person's first name
    * @var string
    */
   protected $firstName; 
   
   
   /**
    * Person's date of birth
    * @var date
    */
   protected $dateOfBirth; 
   
   
   /**
    * Person's address
    * @var string
    */
   protected $address; 
   
   
   /**
    * Person's city
    * @var string
    */
   protected $city; 
   
   
   /**
    * Person's country
    * @var country
    */
   protected $country; 
   
   
   /**
    * Person's phone number
    * @var int
    */
   protected $phoneNumber; 
   
   
   /**
    * Person's email
    * @var type string
    */
   protected $email; 
   
   
   /**
    * Person's isArchived
    * @var type boolean
    */
   protected $isArchived; 
    
   
   
   /**
    * Constructs object Person
    * @param type $array of parameters that correspond to the classes properties
    */
    protected function __construct($array = null) {
        
        if(!is_array($array)) {
           throw new Exception('No parameters');
            

        }//if      
        $this->no = $array['no'];
        $this->name = $array['name']; 
        $this->firstName = $array['firstName']; 
        $this->dateOfBirth = $array['dateOfBirth']; 
        $this->address = $array['address']; 
        $this->country = $array['country']; 
        $this->phoneNumber = $array['phoneNumber']; 
        $this->email = $array['email']; 
        $this->isArchived = $array['isArchived']; 
                
        
    }//construct


    /**
     * get numero
     * @return type numero
     */
    protected function getNo() {
       return $this->no; 
    }// function


    /**
     * get name
     * @return name
     */
    protected function getName() {
        return $this->name; 
    }// function


    /**
     * set no
     * @param type $name 
     */
    protected function setName($name) {
        $this->name = $name; 
    }// function


    /**
     * get first name
     * @return type firstName
     */
    protected function getFirstName() {
        return $this->firstName; 
    }// function


    /**
     * set first name
     * @param type $first name 
     */
    protected function setFirstName($firstName) {   
        $this->firstName = $firstName; 
    }// function


    /**
     * get date of birth
     * @return type dateOfBirth
     */
    protected function getDateOfBirth() {
        return $this->dateOfBirth; 
    }// function


    /**
     * set date of birth
     * @param type $dateOfBirth 
     */
    protected function setDateOfBirth($dateOfBirth) {  
        $this->dateOfBirth = $dateOfBirth; 
    }// function


    /**
     * get address
     * @return type address
     */
    protected function getAddress() {
        return $this->address; 
    }// function


    /**
     * set address
     * @param type $address 
     */
    protected function setAddress($address) {
        $this->address = $address; 
    }// function


    /**
     * get country
     * @return type country
     */
    protected function getCountry() {
        return $this->country; 
    }// function


    /**
     * set country
     * @param type $country 
     */
    protected function setCountry($country) {
        $this->country = $country; 
    }// function


    /**
     * get email
     * @return type email
     */
    protected function getEmail() {
        return $this->email; 
    }// function


    /**
     * set email
     * @param type $email 
     */
    protected function setEmail($email) {
        $this->email = email; 
    }// function
    
    
    /**
     * get isArchived
     * @return type boolean isArchived
     */
    protected function getIsArchived() {
        return $this->isArchived; 
    }//function
    
    
    /**
     * set isArchived
     * @param type $isArchived 
     */
    protected function setIsArchived($isArchived) {
        $this->isArchived = $isArchived;   
    }//function



}//class


?>