<?php
/* Class Courses */
class Courses
{
    /* Connect to database + add table name */
    private $conn;
    private $table_name = "courses";

    /* Course properties */
    public $id;
    public $code; 
    public $name;
    public $progression;
    public $coursesyllabus;

    /* Constructor */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* GET all courses */
    public function getAll() 
    {
        $query = "SELECT * FROM  malinsvens_courses.courses";

        /* Prepare and execute statement */
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    /* GET one course */
    public function getOne() 
    {
        $query = "SELECT * FROM malinsvens_courses.courses WHERE id = ?";

        /* Prepare statment */
        $stmt = $this->conn->prepare($query);
        /* Bind data */
        $stmt->bindParam(1, $this->id);
        /* Execute statement */
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->code = $row['code']; 
        $this->name = $row['name'];
        $this->progression = $row['progression'];
        $this->coursesyllabus = $row['coursesyllabus'];
    }


    /* Create new course */
    public function create()
    {
        $query = "INSERT INTO malinsvens_courses.courses 
        SET
            code = :code,
            name = :name,
            progression = :progression,
            coursesyllabus = :coursesyllabus";

        /* Prepare statement */
        $stmt = $this->conn->prepare($query);

        /* Clean up in data */
        $this->code = htmlspecialchars(strip_tags($this->code));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->progression = htmlspecialchars(strip_tags($this->progression));
        $this->coursesyllabus = htmlspecialchars(strip_tags($this->coursesyllabus));

        /* Bind data */
        $stmt->bindParam(':code', $this->code);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':progression', $this->progression);
        $stmt->bindParam(':coursesyllabus', $this->coursesyllabus);

        /* Execute */
        if ($stmt->execute()) {
            return true;
        }
        /* Error message */
        printf('Error: %s.\n', $stmt->error);
        return false;
    }

/* Update course */
public function update()
{
    $query = "UPDATE malinsvens_courses.courses 
    SET
        code = :code,
        name = :name,
        progression = :progression,
        coursesyllabus = :coursesyllabus
    WHERE
        id = :id";

    /* Prepare statement */
    $stmt = $this->conn->prepare($query);

    /* Clean up in data */
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->code = htmlspecialchars(strip_tags($this->code));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->progression = htmlspecialchars(strip_tags($this->progression));
    $this->coursesyllabus = htmlspecialchars(strip_tags($this->coursesyllabus));

    /* Bind data */
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':code', $this->code);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':progression', $this->progression);
    $stmt->bindParam(':coursesyllabus', $this->coursesyllabus);

    /* Execute */
    if ($stmt->execute()) {
        return true;
    }
    /* Error message */
    printf('Error: %s.\n', $stmt->error);
    return false;
}

    /* Delete post */
    public function delete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "DELETE FROM malinsvens_courses.courses WHERE id = $id";
            $stmt = $this->conn->prepare($query);

            /* Clean data */
            $this->id = htmlspecialchars(strip_tags($this->id));

            /* Bind data */
            $stmt->bindParam(1, $this->id);
            /* Execute */
            if ($stmt->execute()) {
                return true;
            }
            /* Error message */ 
            printf('Error: %s.\n', $stmt->error);
            return false;
        }
    }
}