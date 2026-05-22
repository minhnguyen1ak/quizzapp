<?php

header("Content-Type: application/json");

include "db.php";

$sql = "SELECT * FROM categories
        ORDER BY id DESC";

$result = mysqli_query($conn,$sql);

$data = [];

while($row = mysqli_fetch_assoc($result)){

    $data[] = [

        "id" => $row["id"],

        "title" => $row["title"],

        "image" => $row["image"]

    ];

}

echo json_encode($data);

?>