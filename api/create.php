<?php
    /* Headers */
    header('Access-Control-Allow-Origin: *');
    header('Content-typ: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Typ, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../config/Database.php';
    include_once '../classes/Courses.php';

    /* Instantiate DB and connect */
    $database = new Database();
    $db = $database->connect();

    /* Instatiate post object */
    $courses = new Courses($db);

    /* Get raw posted data */
    $data = json_decode(file_get_contents("php://input"));
  
    $courses->code = $data->code;
    $courses->name = $data->name;
    $courses->progression = $data->progression;
    $courses->coursesyllabus = $data->coursesyllabus;

    /* Create post */
    if ($courses->create()) {
        echo json_encode(
            array('message' => 'Added new course')
        );
    } else {
        echo json_encode(
            array('message' => 'Course not added!')
        );
    }