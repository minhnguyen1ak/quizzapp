<?php

include "db.php";

$message = "";

// ================= ADD CATEGORY =================

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $title = $_POST['title'];

    $image = "";

    // ================= IMAGE =================

    if(isset($_FILES['image'])){

        $imageName =
            time() . "_" .
            $_FILES['image']['name'];

        $tmpName =
            $_FILES['image']['tmp_name'];

        $path =
            "uploads/" . $imageName;

        move_uploaded_file(
            $tmpName,
            $path
        );

        $image = $path;

    }

    // ================= INSERT =================

    $sql = "INSERT INTO categories(

        title,
        image

    )

    VALUES(

        '$title',
        '$image'

    )";

    if(mysqli_query($conn,$sql)){

        $message =
            "✅ Thêm chủ đề thành công";

    }else{

        $message =
            "❌ Lỗi: " .
            mysqli_error($conn);

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Admin Add Category</title>

    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{

            font-family: Arial;

            background: #f5f5f5;

            padding: 40px;

        }

        .container{

            width: 450px;

            background: white;

            padding: 30px;

            border-radius: 20px;

            margin: auto;

            box-shadow:
            0 0 15px rgba(0,0,0,0.1);

        }

        h2{

            text-align: center;

            margin-bottom: 30px;

            color: #5B1CE5;

        }

        label{

            font-weight: bold;

        }

        input{

            width: 100%;

            padding: 14px;

            margin-top: 10px;

            margin-bottom: 20px;

            border-radius: 12px;

            border: 1px solid #ccc;

            font-size: 15px;

        }

        button{

            width: 100%;

            padding: 14px;

            background: #5B1CE5;

            color: white;

            border: none;

            border-radius: 12px;

            font-size: 16px;

            cursor: pointer;

            transition: 0.3s;

        }

        button:hover{

            background: purple;

        }

        .message{

            text-align: center;

            margin-bottom: 20px;

            font-weight: bold;

        }

        .preview{

            width: 100px;

            height: 100px;

            border-radius: 15px;

            object-fit: cover;

            margin-bottom: 20px;

            display: none;

            border: 2px solid #ddd;

        }

    </style>

</head>




<body>

<div class="container">

    <h2>Thêm Chủ Đề Quiz</h2>

    <?php if($message != ""){ ?>

        <div class="message">

            <?php echo $message; ?>

        </div>

    <?php } ?>

    <form

        method="POST"

        enctype="multipart/form-data"

    >

        <label>

            Tên chủ đề

        </label>

        <input

            type="text"

            name="title"

            placeholder="Ví dụ: Flutter"

            required

        >

        <label>

            Chọn icon chủ đề

        </label>

        <input

            type="file"

            name="image"

            id="imageInput"

            accept="image/*"

            required

        >

        <center>

            <img
                id="preview"
                class="preview"
            >

        </center>

        <button type="submit">

            Thêm Chủ Đề

        </button>

    </form>

</div>

<script>

    const imageInput =
    document.getElementById(
        "imageInput"
    );

    const preview =
    document.getElementById(
        "preview"
    );

    imageInput.addEventListener(

        "change",

        function(e){

            const file =
            e.target.files[0];

            if(file){

                preview.src =
                URL.createObjectURL(file);

                preview.style.display =
                    "block";

            }

        }

    );

</script>

</body>
<?php

// ================= DELETE CATEGORY =================

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM categories WHERE id=$id"
    );

    echo "
    <script>
        window.location='add_category.php';
    </script>
    ";

}

// ================= LOAD CATEGORY =================

$categoryList = mysqli_query(
    $conn,
    "SELECT * FROM categories ORDER BY id DESC"
);

?>

<hr style="margin:50px 0;">

<h2 style="text-align:center;">
    Danh sách chủ đề
</h2>

<table
    border="1"
    cellpadding="15"
    cellspacing="0"
    width="100%"
    style="
        background:white;
        border-collapse: collapse;
    "
>

<tr style="background:#5B1CE5;color:white;">

    <th>ID</th>
    <th>Ảnh</th>
    <th>Tên chủ đề</th>
    <th>Action</th>

</tr>

<?php while($cat = mysqli_fetch_assoc($categoryList)){ ?>

<tr>

    <td>
        <?= $cat['id'] ?>
    </td>

    <td>

        <img
            src="<?= $cat['image'] ?>"
            width="70"
            height="70"
            style="
                object-fit:cover;
                border-radius:10px;
            "
        >

    </td>

    <td>
        <?= $cat['title'] ?>
    </td>

    <td>

        <a
            href="edit_category.php?id=<?= $cat['id'] ?>"
            style="
                padding:8px 14px;
                background:orange;
                color:white;
                text-decoration:none;
                border-radius:8px;
            "
        >
            Edit
        </a>

        <a
            href="?delete=<?= $cat['id'] ?>"
            onclick="return confirm('Delete category?')"
            style="
                padding:8px 14px;
                background:red;
                color:white;
                text-decoration:none;
                border-radius:8px;
            "
        >
            Delete
        </a>

    </td>

</tr>

<?php } ?>

</table>

</html>