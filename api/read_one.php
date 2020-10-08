<?php
/* Headers */
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header("Access-Control-Allow-Methods: GET");

include_once '../config/Database.php';
include_once '../classes/Courses.php';

/* Instantiate DB and connect */
$database = new Database();
$db = $database->connect();

/* Instantiate post object */
$course = new Courses($db);
/* GET */
$course->id = isset($_GET['id']) ? $_GET['id'] : die();
/* Get course */
$course->getOne();


/* Create array of courses */
$course_arr = array(
    'id' => $course->id,
    'code' => $course->code,
    'name' => $course->name,
    'progression' => $course->progression,
    'coursesyllabus' => $course->coursesyllabus
);

/* print in JSON format */
print_r(json_encode($course_arr));