<?php

include "db.php";

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM categories WHERE id=$id"
);

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $title = $_POST['title'];

    $image = $data['image'];

    if($_FILES['image']['name'] != ""){

        $imageName =
            time() . "_" .
            $_FILES['image']['name'];

        $tmp =
            $_FILES['image']['tmp_name'];

        $path =
            "uploads/" . $imageName;

        move_uploaded_file($tmp,$path);

        $image = $path;

    }

    mysqli_query($conn,"

        UPDATE categories

        SET

        title='$title',
        image='$image'

        WHERE id=$id

    ");

    header("Location:add_category.php");

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Category</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    padding:40px;
}

.box{

    width:450px;
    background:white;
    margin:auto;
    padding:30px;
    border-radius:20px;

}

input{
    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:20px;
}

button{
    width:100%;
    padding:14px;
    background:#5B1CE5;
    color:white;
    border:none;
}

img{
    width:100px;
    border-radius:15px;
}

</style>

</head>

<body>

<div class="box">

<h2>Edit Category</h2>

<form method="POST" enctype="multipart/form-data">

<input
    type="text"
    name="title"
    value="<?= $data['title'] ?>"
>

<img src="<?= $data['image'] ?>">

<br><br>

<input type="file" name="image">

<button name="update">
    Update Category
</button>

</form>

</div>

</body>
</html>