<?php

include "db.php";

// ================= TOTAL USER =================

$userQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM users"
);

$userData = mysqli_fetch_assoc($userQuery);

$totalUsers = $userData['total'];


// ================= TOTAL RESULTS =================

$resultQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM results"
);

$resultData = mysqli_fetch_assoc($resultQuery);

$totalResults = $resultData['total'];


// ================= TOTAL CATEGORY =================

$categoryQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM categories"
);

$categoryData = mysqli_fetch_assoc($categoryQuery);

$totalCategories = $categoryData['total'];


// ================= TOTAL QUESTIONS =================

$questionQuery = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM questions"
);

$questionData = mysqli_fetch_assoc($questionQuery);

$totalQuestions = $questionData['total'];


// ================= STATISTICS =================

$stats = mysqli_query($conn, "

SELECT

    users.username,
    categories.title as category,
    results.correct_count,
    results.total_questions,
    results.created_at

FROM results

JOIN users
ON users.id = results.user_id

JOIN categories
ON categories.id = results.category_id

ORDER BY results.id DESC

");

?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Dashboard</title>

    <meta charset="UTF-8">

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body{

            background: #f5f6fa;

        }

        .card-box{

            border-radius: 20px;

            padding: 25px;

            color: white;

            transition: 0.3s;

        }

        .card-box:hover{

            transform: translateY(-5px);

            opacity: 0.9;

        }

        .title{

            font-size: 18px;

        }

        .number{

            font-size: 40px;

            font-weight: bold;

        }

        a{

            text-decoration: none;

        }

    </style>

</head>

<body>

<div class="container py-5">

    <h1 class="mb-4 fw-bold">
        Admin Dashboard
    </h1>

    <!-- ================= TOP CARDS ================= -->

    <div class="row g-4 mb-5">

        <!-- USERS -->

        <div class="col-md-3">

            <div
                class="card-box bg-primary"
            >

                <div class="title">
                    Total Users
                </div>

                <div class="number">
                    <?php echo $totalUsers; ?>
                </div>

            </div>

        </div>

        <!-- QUIZ PLAYED -->

        <div class="col-md-3">

            <div
                class="card-box bg-success"
            >

                <div class="title">
                    Quiz Played
                </div>

                <div class="number">
                    <?php echo $totalResults; ?>
                </div>

            </div>

        </div>

        <!-- CATEGORY -->

        <div class="col-md-3">

            <a
                href="https://quizzapp-wzzz.onrender.com/add_category.php"
            >

                <div
                    class="card-box bg-warning"
                >

                    <div class="title">
                        Categories
                    </div>

                    <div class="number">
                        <?php echo $totalCategories; ?>
                    </div>

                </div>

            </a>

        </div>

        <!-- QUESTIONS -->

        <div class="col-md-3">

            <a
                href="https://quizzapp-wzzz.onrender.com/create_questions.php"
            >

                <div
                    class="card-box bg-danger"
                >

                    <div class="title">
                        Questions
                    </div>

                    <div class="number">
                        <?php echo $totalQuestions; ?>
                    </div>

                </div>

            </a>

        </div>

    </div>

    <!-- ================= TABLE ================= -->

    <div class="card shadow border-0">

        <div class="card-body">

            <h3 class="mb-4">
                Quiz Statistics
            </h3>

            <table class="table table-bordered table-hover">

                <thead class="table-dark">

                <tr>

                    <th>User</th>

                    <th>Category</th>

                    <th>Correct</th>

                    <th>Total</th>

                    <th>Score</th>

                    <th>Date</th>

                </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($stats)){ ?>

                    <?php

                    $percent = round(
                        (
                            $row['correct_count']
                            /
                            $row['total_questions']
                        ) * 100
                    );

                    ?>

                    <tr>

                        <td>
                            <?php echo $row['username']; ?>
                        </td>

                        <td>
                            <?php echo $row['category']; ?>
                        </td>

                        <td>
                            <?php echo $row['correct_count']; ?>
                        </td>

                        <td>
                            <?php echo $row['total_questions']; ?>
                        </td>

                        <td>

                            <span class="badge bg-primary">

                                <?php echo $percent; ?>%

                            </span>

                        </td>

                        <td>
                            <?php echo $row['created_at']; ?>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>
