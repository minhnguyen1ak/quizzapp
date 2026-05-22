<?php

header("Content-Type: application/json");

include "db.php";

$user_id = $_POST['user_id'];
$category_id = $_POST['category_id'];
$correct_count = $_POST['correct_count'];
$total_questions = $_POST['total_questions'];

$sql = "INSERT INTO results
(
    user_id,
    category_id,
    correct_count,
    total_questions
)

VALUES
(
    '$user_id',
    '$category_id',
    '$correct_count',
    '$total_questions'
)";

if(mysqli_query($conn, $sql)){

    echo json_encode([
        "success" => true
    ]);

}else{

    echo json_encode([
        "success" => false,
        "error" => mysqli_error($conn)
    ]);

}
?>