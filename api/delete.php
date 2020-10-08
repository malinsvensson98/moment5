<?php
/* Headers */
header('Access-Control-Allow-Origin: *');
header('Content-typ: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Typ, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../config/Database.php';
include_once '../classes/Courses.php';


/* Instantiate DB and connect */
$database = new Database();
$db = $database->connect();

/* Instatiate post object */
$courses = new Courses($db);
$id = $courses->id;

/* Update post */
if ($courses->delete($id)) {
    echo json_encode(
        array('message' => 'Course deleted!')
    );
} else {
    echo json_encode(
        array('message' => 'Course not deleted')
    );
}