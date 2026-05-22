<?php

header("Content-Type: application/json");
include "db.php";

$category_id = $_GET['category_id'] ?? 0;

$result = mysqli_query($conn,
    "SELECT * FROM questions WHERE category_id='$category_id'"
);

if(!$result){
    echo json_encode(["error"=>mysqli_error($conn)]);
    exit;
}

$data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = [
        "id" => $row["id"],
        "question" => $row["question"],
        "answer_a" => $row["answer_a"],
        "answer_b" => $row["answer_b"],
        "answer_c" => $row["answer_c"],
        "answer_d" => $row["answer_d"],
        "correct_answer" => $row["correct_answer"],
        "time_limit" => $row["time_limit"]
    ];
}

echo json_encode($data);
?>