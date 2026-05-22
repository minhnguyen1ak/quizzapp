<?php

header("Content-Type: application/json");

include "db.php";

$response = [];

try{

    if(
        isset($_POST['email']) &&
        isset($_POST['username']) &&
        isset($_POST['password'])
    ){

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        $avatar = "";

        // ================= GET OLD AVATAR =================

        $check = mysqli_query(
            $conn,
            "SELECT avatar FROM users WHERE email='$email'"
        );

        $oldData = mysqli_fetch_assoc($check);

        $avatar = $oldData['avatar'];

        // ================= UPLOAD IMAGE =================

        if(isset($_FILES['avatar'])){

            if(!file_exists("uploads")){

                mkdir("uploads", 0777, true);

            }

            $imageName =
                time() . "_" .
                $_FILES['avatar']['name'];

            $tmpName =
                $_FILES['avatar']['tmp_name'];

            $path =
                "uploads/" . $imageName;

            move_uploaded_file(
                $tmpName,
                $path
            );

            $avatar = $path;
        }

        // ================= UPDATE =================

        $sql = "UPDATE users SET

            username='$username',
            password='$password',
            avatar='$avatar'

            WHERE email='$email'
        ";

        if(mysqli_query($conn,$sql)){

            $response = [

                "success" => true,

                "avatar" => $avatar

            ];

        }else{

            $response = [

                "success" => false,

                "message" => mysqli_error($conn)

            ];

        }

    }else{

        $response = [

            "success" => false,

            "message" => "Thiếu dữ liệu"

        ];

    }

}catch(Exception $e){

    $response = [

        "success" => false,

        "message" => $e->getMessage()

    ];

}

echo json_encode($response);

?>