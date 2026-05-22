<?php

header("Content-Type: application/json");

include "connect.php";

$user_id = $_GET['user_id'] ?? 0;

$sql = "

SELECT COUNT(*) as total
FROM results
WHERE user_id = '$user_id'

";

$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

echo json_encode([
    "total" => intval($row["total"])
]);