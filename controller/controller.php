<?php
// This is for Controller functions.
require_once('./model/MemberManager.php');
require_once("./model/PetProfileManager.php");
require_once("./model/PreviewManager.php");
require_once("./model/EventManager.php");
require_once("./controller/signinController.php");
require_once("./controller/eventsController.php");
require_once("./controller/accountController.php");
require_once("./model/MapManager.php");

function landing()
{
    require("./view/landing.php");
}

function showPetProfile($petId){
    // echo $petId;
    $petProfileManager = new PetProfileManager();
    $petProfile = $petProfileManager->getPetProfile($petId);
    require("./view/petProfileView.php");
}
function showPetPreview($ownerId){
    // echo $petId;
    $previewManager = new PetProfileManager();
    $petPreviews = $previewManager->getPreview($ownerId);
    require("./view/previewPet.php");
}

function displayAddEditInput($petId) {
    $petProfileManager = new PetProfileManager();
    $petProfile = $petProfileManager->getPetProfile($petId);
    require("./view/addEditPetView.php");
}

function petAddEdit($params) {
    $addEditManager = new PetProfileManager();

    if ($_FILES['file']['size'] !== 0) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($fileActualExt,$allowed)) {
            if ($fileError === 0) {
                if($fileSize < 1000000) {
                    $fileNameNew = uniqid('',true) . '.' . $fileActualExt;
                    $fileDestination = './private/pet/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // $addEditManager->updateImage($params['petId'], $fileNameNew);
                } else {
                    echo "fileError";
                    return null;
                }
            } else {
                echo "fileError";
                return null;

            }
        } else {
            echo "fileError";
            return null;
        }
    }
    $photoData = array (
        "photo" => isset($fileNameNew) ? $fileNameNew : '' ,
    );
    $success = $addEditManager->addEditPet($params, $photoData);
    
    echo !empty($success) ? 'success' : 'error';
}


function deletePet($petId) {
    $deleteManager = new PetProfileManager();
    $deleteManager->deletePet($petId);
}

function aboutUs(){
    require('./view/aboutUsView.php');
}

function showPartnersPage() {
    require('./view/partnersView.php');
}

function contactPage(){
    require('./view/contactPageView.php');
}

function accountView($userID){
    $manager = new MemberManager();
    $memberDataFromDB = $manager->getMemberDataByID($userID);
    require("./view/accountView.php");
}
function legalPage(){
    require('./view/legalPageView.php');
}

function displayAddEditEvent($eventId){
    if(!empty($eventId)){
        $eventManager = new EventManager();
        $eventEditDetails = $eventManager->getEventEditDetails($eventId);
    }
    require('./view/addEditEventView.php');
}

function addEditEventDetails($params){
    $eventManager = new EventManager();

    if ($_FILES['file']['size'] !== 0) {
        $fileName = $_FILES['file']['name'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];
        $fileType = $_FILES['file']['type'];
        $fileExt = explode('.',$fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($fileActualExt,$allowed)) {
            if ($fileError === 0) {
                if($fileSize < 5000000) {
                    $fileNameNew = uniqid('',true) . '.' . $fileActualExt;
                    $fileDestination = './private/event/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);
                    // $addEditManager->updateImage($params['petId'], $fileNameNew);
                } else {
                    echo "fileError";
                    return null;
                }
            } else {
                echo "fileError";
                return null;

            }
        } else {
            echo "fileError";
            return null;
        }
    }
    $photoData = array (
        "eventPicture" => isset($fileNameNew) ? $fileNameNew : '' ,
    );

    $eventId = $eventManager->updateEventDetails($params, $photoData);
    if($eventId){
        //display the details of newly added or edited event
        showEventDetail($eventId);
    }else{
        echo "Event details were not saved properly";
    }
}

function deleteEvent($eventId) {
    $eventManager = new EventManager();
    $eventManager->deleteEvent($eventId);
}



function showMap(){
    // echo $petId;
    $mapManager = new MapManager();
    $sponsors = $mapManager->getSponsors();
    require("./view/mapViewTest.php");
}

function showMapDetail(){
    
    require("./view/mapViewDetail.php");
}
