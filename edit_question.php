<?php

include "db.php";

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT * FROM questions WHERE id=$id"
);

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){

    $question = $_POST['question'];

    $a = $_POST['a'];

    $b = $_POST['b'];

    $c = $_POST['c'];

    $d = $_POST['d'];

    $correct = $_POST['correct'];

    mysqli_query($conn,"

    UPDATE questions

    SET

    question='$question',
    answer_a='$a',
    answer_b='$b',
    answer_c='$c',
    answer_d='$d',
    correct_answer='$correct'

    WHERE id=$id

    ");

    header("Location:create_questions.php");

}

?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Question</title>

<style>

body{
    font-family:Arial;
    background:#f5f5f5;
    padding:40px;
}

.box{

    background:white;
    padding:30px;
    border-radius:20px;

}

input,textarea,select{

    width:100%;
    padding:12px;
    margin-top:10px;
    margin-bottom:20px;

}

button{

    padding:14px;
    background:purple;
    color:white;
    border:none;
    width:100%;

}

</style>

</head>

<body>

<div class="box">

<h2>Edit Question</h2>

<form method="POST">

<textarea name="question"><?= $data['question'] ?></textarea>

<input
    name="a"
    value="<?= $data['answer_a'] ?>"
>

<input
    name="b"
    value="<?= $data['answer_b'] ?>"
>

<input
    name="c"
    value="<?= $data['answer_c'] ?>"
>

<input
    name="d"
    value="<?= $data['answer_d'] ?>"
>

<select name="correct">

<option
value="A"
<?= $data['correct_answer']=="A"?"selected":"" ?>
>
A
</option>

<option
value="B"
<?= $data['correct_answer']=="B"?"selected":"" ?>
>
B
</option>

<option
value="C"
<?= $data['correct_answer']=="C"?"selected":"" ?>
>
C
</option>

<option
value="D"
<?= $data['correct_answer']=="D"?"selected":"" ?>
>
D
</option>

</select>

<button name="update">
    Update Question
</button>

</form>

</div>

</body>
</html>