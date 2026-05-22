<?php

header("Content-Type: application/json");

include "db.php";

$user_id = $_GET['user_id'];

$sql = "

SELECT

    c.title AS category,

    SUM(r.correct_count) AS correct,

    SUM(r.total_questions) AS total

FROM results r

JOIN categories c
ON c.id = r.category_id

WHERE r.user_id = '$user_id'

GROUP BY r.category_id

ORDER BY correct DESC

";

$result = mysqli_query($conn, $sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = $row;

}

echo json_encode($data);

?>