<?php
require_once(APP_DIR . '/core/model/Slot.class.php');
require_once(APP_DIR . '/core/model/Message.class.php');

/**
 * Description of FSSlot
 *
 * @author Lauric Francelet
 */
class FSSlot {
    /**
     * The constructor that does nothing
     */
    public function __construct() {
        // Nothing
    }
    
    /**
     * Returns a Message containing a Slot 
     * @param type $args A Slot No and an Event
     * @return Message containing the Slot
     */
    public static function getSlot($args){
        global $crud;
        $slot = NULL;
        $event = $args['event'];
        $return = NULL;
        
        $sql = "SELECT * FROM Slot WHERE No = ".$args['no']." AND EventNo = ". $event->getNo();
        $data = $crud->getRow($sql);
        
        
        if($data){
            $argsSlot = array(
                'no'            => $data['No'],
                'eventNo'       => $data['EventNo'],
                'happeningDate' => $data['HappeningDate'],
                'startingTime'  => $data['StartingTime'],
                'endingTime'    => $data['EndingTime'],
                'isArchived'    => $data['IsArchived'],
            );
            
            $slot = new Slot($argsSlot);
            
            $argsMessage = array(
                'messageNumber' => 115,
                'message'       => 'Existant Slot',
                'status'        => true,
                'content'       => $slot
            );
            $return = new Message($argsMessage);
        } else {
            $argsMessage = array(
                'messageNumber' => 116,
                'message'       => 'Inexistant Slot',
                'status'        => false,
                'content'       => NULL
            );
            $return = new Message($argsMessage);
        }
        
        return $return;
    }
    
    /**
     * Returns all the Slots of a given Event
     * @param an Event
     * @return a Message conainting an array of Slots
     */
    public static function getSlotsByEvent($event){
        global $crud;
        
        $sql = "SELECT * FROM Slot WHERE EventNo = ".$event->getNo();
        $data = $crud->getRows($sql);
        
        if ($data){
            $slots = array();

            foreach($data as $row){
                $argsSlot = array(
                    'no'            => $row['No'],
                    'eventNo'       => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime'  => $row['StartingTime'],
                    'endingTime'    => $row['EndingTime'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 117,
                'message'       => 'All Slots for an Event selected',
                'status'        => true,
                'content'       => $slots
            );
            
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 118,
                'message'       => 'Error while SELECT * FROM person',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);

        }
        
        return $return;
    }
    
    /**
     * Returns all the Slots
     * @return a Message conainting an array of Slots
     */
    public static function getSlots(){
        global $crud;
        
        $sql = "SELECT * FROM Slot";
        $data = $crud->getRows($sql);
        
        if ($data){
            $slots = array();

            foreach($data as $row){
                $argsSlot = array(
                    'no'            => $row['No'],
                    'eventNo'       => $row['EventNo'],
                    'happeningDate' => $row['HappeningDate'],
                    'startingTime'  => $row['StartingTime'],
                    'endingTime'    => $row['EndingTime'],
                    'isArchived'    => $row['IsArchived'],
                );
            
                $slots[] = new Slot($argsSlot);
            } //foreach

            $argsMessage = array(
                'messageNumber' => 119,
                'message'       => 'All Slots selected',
                'status'        => true,
                'content'       => $slots
            );
            
            $return = new Message($argsMessage);

        } else {
            $argsMessage = array(
                'messageNumber' => 120,
                'message'       => 'Error while SELECT * FROM person',
                'status'        => false,
                'content'       => NULL
            );
            
            $return = new Message($argsMessage);

        }
        
        return $return;
    } 

}

?>