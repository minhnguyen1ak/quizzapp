<?php

header("Content-Type: application/json");

include "db.php";

if(
    isset($_POST['username']) &&
    isset($_POST['email']) &&
    isset($_POST['password'])
){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // CHECK EMAIL

    $checkEmail = "SELECT * FROM users
    WHERE email='$email'";

    $checkResult = mysqli_query(
        $conn,
        $checkEmail
    );

    if(mysqli_num_rows($checkResult) > 0){

        echo json_encode([
            "success" => false,
            "message" => "Email đã tồn tại"
        ]);

        exit();

    }

    // INSERT USER

    $sql = "INSERT INTO users(
        username,
        email,
        password,
        avatar
    )

    VALUES(
        '$username',
        '$email',
        '$password',
        ''
    )";

    if(mysqli_query($conn,$sql)){

        echo json_encode([
            "success" => true,
            "message" => "Đăng ký thành công"
        ]);

    }else{

        echo json_encode([
            "success" => false,
            "message" => mysqli_error($conn)
        ]);

    }

}else{

    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu POST"
    ]);

}

?>