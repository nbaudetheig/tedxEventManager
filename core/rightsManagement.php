<?php
/**
 * rightsManagement.php enables admin users to set the units and their privile-
 * ges, and assign members to units.
 *
 * @author Nicolas Baudet <nicolas.baudet@heig-vd.ch>
 */
require_once( '../tedx-config.php' );

?>
<style>
body {
    font-family: Helvetica, Verdana, Sans-serif;
}
</style>


<?php
// DEBUG
/*echo '<h2>Session</h2>';
var_dump($_SESSION);
echo '<h2>Request</h2>';
var_dump($_REQUEST);*/

// Is the user trying to log out ?
if( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'logout' ) {
    $tedx_manager->logout();
}

// ALGORITHM FOR THIS USER INTERFACE
// Is the user logged ?
// yes -> Does he have sufficient rights ?
//        yes -> show the menu / do the action
//        no  -> show him error message
// no  -> Is he trying to login ?
//        yes -> try to login
//        no  -> show him login form
if( $tedx_manager->isLogged() ) {
    //echo 'user logged<br />';
    $message = $tedx_manager->isGranted( "manageRights" );
    if( $message->getStatus() ) {
        //echo $message->getMessage().'<br />';
        // Nothing to do here.
    }
    // Else : No sufficient rights
    else {
        die("<h2>You don't have sufficient privileges to access this page.</h2>
            <p><a href=\"../index.php\">Back to home</a><br />
            <a href=\"?action=logout\">Log out</a></p>");
    }
}
else {
    if ( isset($_REQUEST['action'] ) && $_REQUEST['action'] == 'login' ) {
        //echo 'User tries to login';
        // Nothing to do here.
    }
    else {
        //echo 'User not logged, and wants to login<br />';
        $_REQUEST['action'] = 'loginForm';
    }
}


// Gets and executes the action
if( isset( $_REQUEST['action'] ) ) {
    
    switch ( $_REQUEST['action'] ) {
    case 'seeMembersUnits':
        echo '<h1>See the members\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $members = FSMember::getMembers()->getContent();
        showMembers( $members );
        break;
    
    case 'displayMember':
        echo '<p><a href="?action=seeMembersUnits">Return to members\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        showMember();
        break;
    
    case 'updateMember':
        echo '<h1>Register the changes for a member</h1>';
        echo '<p><a href="?action=seeMembersUnits">Return to members\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        updateMember();
        break;
    
    case 'seeAccessesUnits':
        echo '<h1>See the accesses\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $accesses = FSAccess::getAccesses()->getContent();
        showAccesses( $accesses );
        break;
    
    case 'displayAccess':
        echo '<p><a href="?action=seeAccessesUnits">Return to accesses\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        showAccess();
        break;
    
    case 'addAccess':
        if( isset( $_REQUEST['service'] )  && $_REQUEST['service'] != '' ) {
            $accessToAdd['Service'] = $_REQUEST['service'];
            $messageAdd = $tedx_manager->addAccess( $accessToAdd );
        }
        echo '<h1>See the accesses\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $accesses = FSAccess::getAccesses()->getContent();
        showAccesses( $accesses );
        break;
        
    case 'deleteAccess':
        if( isset( $_REQUEST['Service'] ) && $_REQUEST['Service'] != '' ) {
            $accessToDelete['Service'] = $_REQUEST['Service'];
            $messageDelete = $tedx_manager->deleteAccess( $accessToDelete );
        }
        echo '<h1>See the accesses\' units</h1>';
        echo '<p><a href="?">Go back</a></p>';
        $accesses = FSAccess::getAccesses()->getContent();
        showAccesses( $accesses );
        break;
    
    case 'updateAccess':
        echo '<h1>Register the changes for an access</h1>';
        echo '<p><a href="?action=seeAccessesUnits">Return to accesses\' units</a><br />';
        echo '<a href="?">Go back</a></p>';
        updateAccess();
        break;
    
    case 'updateUnit':
        echo '<h1>Register the changes for a unit</h1>';
        echo '<p><a href="?">Go back</a></p>';
        break;
    
    case 'loginForm':
        loginForm();
        break;

    case 'login':
        $message = $tedx_manager->login( $_REQUEST['id'], $_REQUEST['password'] );
        if( $message->getStatus() ) {
            header( "Location: rightsManagement.php" );
        }
        else {
            header( "Location: rightsManagement.php?try=fail" );
        }
        break;
    
    default:
        showMenu();
        break;
    }
}
else {
    showMenu();
}

/**
 * Shows the login form.
 * nb: only the superadmin is allowed to manage the rights.
 */
function loginForm(){
    if( isset( $_REQUEST['try'] ) && $_REQUEST['try'] == 'fail' ) {
        echo '<p style="color: crimson;"><strong>Login failed</strong></p>';
    }
    echo '<h2>Hello! You must login to manage rights</h2>';
    echo '<form method="POST">
        <label for="id">Login</label>
        <input type="texte" id="id" name="id" /><br />
        <label for="password">Password</label>
        <input type="password" id="password" name="password" /><br />
        <input type="hidden" id="action" name="action" value="login" />
        <input type="submit" value="login" />';
}

/**
 * Shows the landing page
 */
function showMenu(){
    //var_dump($_SESSION);
    echo '<h2>Welcome to the rights management page</h2>
    <p>Select one of the option to access the corresponding page</p>
    <ul>
        <li><a href="?action=seeMembersUnits">See the members\' units</a></li>
        <li><a href="?action=seeAccessesUnits">See the accesses\' units</a></li>
        <li><a href="?action=logout">Log out</a></li>
    </ul>
    ';
}

/**
 * Shows all the members and the units they are part of.
 * @param Mixed $members an array of Member
 */
function showMembers( $members ) {
    $tabOfAllUnits = getUnitsAsString();
    
    // Construct the table to display
    echo '<table><tr>'.PHP_EOL;
    echo '<th>Login\Unit</th>';
    foreach($tabOfAllUnits as $unit){
        echo '<th>'.$unit.'</th>';
    } // foreach
    echo '<th>Update</th></tr>'.PHP_EOL;
    
    $lineColor = 0;
    foreach( $members as $member ) {
        
        echo '<tr style="background-color: '. ($lineColor++%2 == 0 ? 'lightgray' : 'whitesmoke') .';">'.PHP_EOL;
        
        $tabUnitsOfMember = getUnitsFromMember( $member );
        
        echo '<td>'.$member->getID().'</td>';
        foreach ( $tabOfAllUnits as $unit ) {

            if( in_array( $unit, $tabUnitsOfMember ) ) {
                echo '<td style="text-align: center;">&#10003;</td>';
            } // if
            else {
                echo '<td style="text-align: center; color: darkgray;">&#10005;</td>';
            } // else
        } // foreach
        echo '<td><a href="?action=displayMember&memberID='.$member->getID().'">Change rights</a></td></tr>'.PHP_EOL;
    } // foreach
    echo '</table>'.PHP_EOL;
}

/**
 * Shows all the Accesses and the Units which are allowed to use them.
 * Also show two form: one to add an Access and one to erase an Access
 * @param Mixed $accesses an array of Access
 */
function showAccesses( $accesses ) {
    // Echo a form to add/delete accesses to the application
    echo '<div style="float: right;
        background-color: lightgray;
        margin-right: 30px;
        padding: 10px;
        border-radius: 3px;
        border-bottom: 1px solid gray;
        border-right: 1px solid gray;">';
    echo '<form method="POST" style="margin-bottom: 0px;">
            <fieldset style="width: 250px;">
                <legend>Add a new Access</legend>
                <input type="hidden" name="action" value="addAccess" />
                <label for="serviceToAdd">Access name:</label>
                <input type="text" id="serviceToAdd" name="service" /><br />
                <input type="submit" value="Add Access" />
            </fieldset>
        </form>';
    
    echo '<form method="POST" style="margin-bottom: 0px; margin-top: 20px;">
            <fieldset style="width: 250px;">
                <legend>Delete an Access</legend>
                <p><em>Please type exactly the name of the access you want to delete.<br />
                <strong>Warning:</strong> this action cannot be canceled!</em></p>
                <input type="hidden" name="action" value="deleteAccess" />
                <label for="serviceToDelete">Access name:</label>
                <input type="text" id="serviceToDelete" name="Service" /><br />
                <input type="submit" value="Delete Access" />
            </fieldset>
        </form>';
    echo '</div>';

    $tabOfAllUnits = getUnitsAsString();
    
    // Construct the table to display
    echo '<table><tr>'.PHP_EOL;
    echo '<th>Access\Unit</th>';
    foreach($tabOfAllUnits as $unit){
        echo '<th>'.$unit.'</th>';
    } // foreach
    echo '<th>Update</th></tr>'.PHP_EOL;
    
    $lineColor = 0;
    foreach( $accesses as $access ) {
        
        echo '<tr style="background-color: '. ($lineColor++%2 == 0 ? 'lightgray' : 'whitesmoke') .';">'.PHP_EOL;
        
        $tabUnitsOfAccess = getUnitsFromAccess( $access );
        
        echo '<td>'.$access->getService().'</td>';
        foreach ( $tabOfAllUnits as $unit ) {

            if( in_array( $unit, $tabUnitsOfAccess ) ) {
                echo '<td style="text-align: center;">&#10003;</td>';
            } // if
            else {
                echo '<td style="text-align: center; color: darkgray;">&#10005;</td>';
            } // else
        } // foeach
        echo '<td><a href="?action=displayAccess&AccessNo='.$access->getNo().'">Change units</a></td></tr>'.PHP_EOL;
    } // foreach
    echo '</table>'.PHP_EOL;
}

/**
 * Show the Units of a Member in a form, so you can choose which one the member
 * is going to be part of.
 */
function showMember() {
    if( isset( $_REQUEST['memberID'] ) ) {
        $member = FSMember::getMember( $_REQUEST['memberID'] )->getContent();
        $tabUnitsOfMember = getUnitsFromMember( $member );
        
        $tabOfAllUnits = getUnitsAsString();
        
        echo '<h1>Change <em>'.$member->getId().'</em>\'s units</h1>';
        
        echo '<form method="POST" action="">
            <input type="hidden" id="action" name="action" value="updateMember" />
            <input type="hidden" id="memberID" name="memberID" value="'.$member->getId().'" />'.PHP_EOL;
        
        foreach ( $tabOfAllUnits as $unit ) {
            if( in_array( $unit, $tabUnitsOfMember ) ) {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" checked />';
            } // if
            else {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" />';
            } // else
            echo '<label for="'.$unit.'">'.$unit.'</label>'.PHP_EOL;
            echo '<br />'.PHP_EOL;
        } // foreach
        
        echo '<input type="submit" value="Change rights" />
            </form>';
    } // if
    else {
        echo 'Error: no member set.';
    } // else
}


/**
 * Show the Units of an Access and enables to choose which ones are linked or not.
 */
function showAccess() {
    if( isset( $_REQUEST['AccessNo'] ) ) {
        $access = FSAccess::getAccess( $_REQUEST['AccessNo'] )->getContent();
        $tabUnitsOfAccess = getUnitsFromAccess( $access );
        
        $tabOfAllUnits = getUnitsAsString();
        
        echo '<h1>Change <em>'.$access->getService().'</em>\'s units</h1>';
        
        echo '<form method="POST" action="">
            <input type="hidden" id="action" name="action" value="updateAccess" />
            <input type="hidden" id="memberID" name="memberID" value="'.$access->getNo().'" />'.PHP_EOL;
        
        foreach ( $tabOfAllUnits as $unit ) {
            if( in_array( $unit, $tabUnitsOfAccess ) ) {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" checked />';
            } // if
            else {
                echo '<input type="checkbox" id="'.$unit.'" name="'.$unit.'" />';
            } // else
            echo '<label for="'.$unit.'">'.$unit.'</label>'.PHP_EOL;
            echo '<br />'.PHP_EOL;
        } // foreach
        
        echo '<input type="submit" value="Change Units" />
            </form>';
    } // if
    else {
        echo 'Error: no Access set.';
    } // else
}

/**
 * Updates the units a Member is part of.
 * When we unset a Unit, it is archived. So, when we set one, we first check if
 * there is an archived one, and we dearchived it.
 * @global Tedx_manager $tedx_manager
 */
function updateMember() {
    
    global $tedx_manager;
    
    $tabRequest = $_REQUEST;
    $memberID = $tabRequest['memberID'];
    unset($tabRequest['action']);
    unset($tabRequest['memberID']);
    $checkedUnits = $tabRequest;
    
    // Gets all the units a member is part of
    $member = FSMember::getMember($memberID)->getContent();
    $tabUnitsOfMember = getUnitsFromMember( $member );
    
    $tabOfAllUnits = getUnitsAsString();
    
    foreach( $tabOfAllUnits as $unit ) {
        // If the member was already granted this access
        if( in_array( $unit, $tabUnitsOfMember ) ) {
            // If it was checked
            if( isset( $checkedUnits[$unit] ) ) {
                // do nothing
                //echo $unit.' already granted<br />';
            } // if
            // Change this right
            else {
                // change the right
                echo 'Successfully changed the membership to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'member' => $member,
                    'unit'   => $objectUnit
                );
                FSMembership::upsertMembership( $args );
            } // else
        } // if
        
        // If this access was not yet granted
        else {
            // If it was checked
            if ( isset( $checkedUnits[$unit] ) ) {
                // change this right
                echo 'Successfully changed the membership to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName($unit)->getContent();
                $args = array(
                    'member' => $member,
                    'unit'   => $objectUnit
                );
                $message = FSMembership::upsertMembership( $args );
            }
            else {
                // do nothing
                //echo $unit.' already not granted<br />';
            } // else
        } // else
    } // foreach
    showMember();
}

/**
 * Updates the Units an Access lets access to.
 * @global Tedx_manager $tedx_manager
 */
function updateAccess() {
    
    global $tedx_manager;
    
    $tabRequest = $_REQUEST;
    $accessNo = $tabRequest['AccessNo'];
    unset($tabRequest['action']);
    unset($tabRequest['AccessNo']);
    $checkedUnits = $tabRequest;
    
    // Gets all the units a member is part of
    $access = FSAccess::getAccess($accessNo)->getContent();
    $tabUnitsOfAccess = getUnitsFromAccess( $access );
    
    $tabOfAllUnits = getUnitsAsString();
    // Order the array to have superadmin at beginning
    array_splice( $tabOfAllUnits, 0, 0, $tabOfAllUnits[5] );
    unset($tabOfAllUnits[6]);
    
    foreach( $tabOfAllUnits as $unit ) {
        // If the access was already a privilege for this unit
        if( in_array( $unit, $tabUnitsOfAccess ) ) {
            // If it was checked
            if( isset( $checkedUnits[$unit] ) ) {
                // do nothing
                //echo $unit.' already granted<br />';
            } // if
            // Change this right
            else {
                // change the right
                echo 'Successfully changed the access to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName( $unit )->getContent();
                $args = array(
                    'access' => $access,
                    'unit'   => $objectUnit
                );
                FSPermission::upsertPermission( $args );
            } // else
        } // if
        
        // If this access was not yet granted
        else {
            // If it was checked
            if ( isset( $checkedUnits[$unit] ) ) {
                // change this right
                echo 'Successfully changed the Permission to '.$unit.'<br />';
                $objectUnit = FSUnit::getUnitByName( $unit )->getContent();
                $args = array(
                    'access' => $access,
                    'unit'   => $objectUnit
                );
                $message = FSPermission::upsertPermission( $args );
            } // if
            else {
                // do nothing
                //echo $unit.' already not granted<br />';
            } // else
        } // else
    } // foreach
    showAccess();
}

/**
 * Get all the existing units and make an array with their names.
 * The array of is then ordered by Unit, following their rank.
 * @return String Array of all the units' names
 */
function getUnitsAsString() {
    $units = FSUnit::getAllUnits()->getContent();
    $tabOfAllUnits = array();
    foreach ( $units as $unit) {
        $tabOfAllUnits[] = $unit->getName();
    }
    // Order the array to have superadmin at beginning
    array_splice( $tabOfAllUnits, 0, 0, $tabOfAllUnits[5] );
    unset($tabOfAllUnits[6]);
    return $tabOfAllUnits;
}

/**
 * Get all the units of a member and make an array.
 * @param Member The member to get the units from.
 * @return Mixed An array with units OR null
 */
function getUnitsFromMember( $member ) {
    $unitsOfMember = FSUnit::getUnitsFromMember( $member )->getContent();
    $tabUnitsOfMember = array();
    
    if( count( $unitsOfMember ) > 0 ) {
        foreach($unitsOfMember as $unit){
            $tabUnitsOfMember[] = $unit->getName();
        }
    }
    else {
        $tabUnitsOfMember[] = NULL;
    }
    return $tabUnitsOfMember;
}

/**
 * Get all the units from an access and make an array.
 * @param Access $access
 * @return Mixed An array with accesses OR null
 */
function getUnitsFromAccess( $access ) {
    $unitsFromAccess = FSUnit::getUnitsFromAccess( $access )->getContent();
    $tabAccessesOfUnit = array();
    
    if( count( $unitsFromAccess ) > 0 ) {
        foreach($unitsFromAccess as $unit){
            $tabAccessesOfUnit[] = $unit->getName();
        }
    }
    else {
        $tabAccessesOfUnit[] = NULL;
    }
    return $tabAccessesOfUnit;
}

?>
