<?php
include "db.php";
$categories = mysqli_query($conn,"SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
<title>Create Questions</title>

<style>
body{
    font-family: Arial;
    background: #f4f4f4;
    padding: 30px;
}
.box{
    background: white;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
}
input,select,textarea{
    width: 100%;
    padding: 10px;
    margin-top: 10px;
}
button{
    padding: 12px 20px;
    background: purple;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
}
</style>
</head>

<body>

<h2>Create Quiz Questions</h2>

<div class="box">
<form method="POST">

<label>Choose Category</label>
<select name="category_id" required>
<?php while($row = mysqli_fetch_assoc($categories)){ ?>
<option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
<?php } ?>
</select>

<label>Number Question</label>
<input type="number" name="total" min="1" required>

<label>Total Time (minutes)</label>
<input type="number" name="total_time" min="1" required>

<br><br>
<button type="submit" name="generate">Create Form</button>

</form>
</div>

<?php

// ================= DELETE QUESTION =================

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM questions WHERE id=$id"
    );

    echo "
    <script>
        window.location='create_questions.php';
    </script>
    ";

}

// ================= LOAD QUESTIONS =================

$questionList = mysqli_query($conn, "

SELECT

    questions.*,
    categories.title as category

FROM questions

JOIN categories
ON categories.id = questions.category_id

ORDER BY questions.id DESC

");

?>

<hr style="margin:50px 0;">

<h2>Question List</h2>

<table
    border="1"
    cellpadding="10"
    cellspacing="0"
    width="100%"
    style="
        background:white;
        border-collapse:collapse;
    "
>

<tr style="background:purple;color:white;">

    <th>ID</th>
    <th>Category</th>
    <th>Question</th>
    <th>Correct</th>
    <th>Action</th>

</tr>

<?php while($q = mysqli_fetch_assoc($questionList)){ ?>

<tr>

    <td>
        <?= $q['id'] ?>
    </td>

    <td>
        <?= $q['category'] ?>
    </td>

    <td>
        <?= $q['question'] ?>
    </td>

    <td>
        <?= $q['correct_answer'] ?>
    </td>

    <td>

        <a
            href="edit_question.php?id=<?= $q['id'] ?>"
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
            href="?delete=<?= $q['id'] ?>"
            onclick="return confirm('Delete question?')"
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

<?php
if(isset($_POST['generate'])){

$total = $_POST['total'];
$category_id = $_POST['category_id'];
$total_time = $_POST['total_time'];
?>

<form action="save_questions.php" method="POST">

<input type="hidden" name="category_id" value="<?= $category_id ?>">
<input type="hidden" name="total_time" value="<?= $total_time ?>">

<?php for($i=1;$i<=$total;$i++){ ?>

<div class="box">

<h3>Question <?= $i ?></h3>

<textarea name="question[]" required></textarea>

<input name="a[]" placeholder="Answer A" required>
<input name="b[]" placeholder="Answer B" required>
<input name="c[]" placeholder="Answer C" required>
<input name="d[]" placeholder="Answer D" required>

<select name="correct[]">
<option value="A">A</option>
<option value="B">B</option>
<option value="C">C</option>
<option value="D">D</option>
</select>

</div>

<?php } ?>

<button type="submit">Save Questions</button>

</form>

<?php } ?>

</body>
</html>