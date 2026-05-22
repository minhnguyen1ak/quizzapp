<?php
include "db.php";

$category_id = $_POST['category_id'];
$total_time = $_POST['total_time'];

$questions = $_POST['question'];
$a = $_POST['a'];
$b = $_POST['b'];
$c = $_POST['c'];
$d = $_POST['d'];
$correct = $_POST['correct'];

// chia thời gian theo câu
$time_per_question = ($total_time * 60) / count($questions);

for($i=0;$i<count($questions);$i++){

    $q = mysqli_real_escape_string($conn, $questions[$i]);

    mysqli_query($conn,"
        INSERT INTO questions (
            category_id,
            question,
            answer_a,
            answer_b,
            answer_c,
            answer_d,
            correct_answer,
            time_limit
        )
        VALUES (
            '$category_id',
            '$q',
            '{$a[$i]}',
            '{$b[$i]}',
            '{$c[$i]}',
            '{$d[$i]}',
            '{$correct[$i]}',
            '$time_per_question'
        )
    ");
}

echo "<h2>Saved Successfully</h2><a href='create_questions.php'>Back</a>";
?>