<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of ALL my Books!!!</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #f0f8ff, #e6f7ff);
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #004080;
            color: white;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
            font-size: 2.5em;
        }
        form {
            text-align: center;
            margin: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 2px solid #004080;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #004080;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0066cc;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #004080;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f9ff;
        }
        tr:hover {
            background-color: #d9f0ff;
        }
        a {
            color: #004080;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
            color: #0066cc;
        }
        footer {
            text-align: center;
            padding: 15px;
            background-color: #004080;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <header>
        <h1>List of ALL my Games!!!</h1>
    </header>

    <?php
    // Connect to database
    $mysqli = new mysqli("localhost", "2440623", "Dharam@123456", "db2440623");

    if ($mysqli->connect_errno) {
        echo "<p style='color:red; text-align:center;'>Failed to connect to MySQL: " . $mysqli->connect_error . "</p>";
        exit();
    }

    // Run SQL query
    $sql = "SELECT * FROM Vediogames ORDER BY rating DESC";
    $results = $mysqli->query($sql);
    ?>

    <form action="search.php" method="post">
        <input type="text" name="keywords" placeholder="Search for a book...">
        <input type="submit" value="Go!">
    </form>

    <table>
        <thead>
            <tr>
                <th>Game Name</th>
                <th>Released Date</th>
                <th>Rating (IMDB)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($a_row = $results->fetch_assoc()): ?>
            <tr>
                <td>
                    <a href="details.php?id=<?= htmlspecialchars($a_row['game_ID']) ?>">
                        <?= htmlspecialchars($a_row['game_name']) ?>
                    </a>
                </td>
                <td><?= htmlspecialchars($a_row['released_date']) ?></td>
                <td><?= htmlspecialchars($a_row['rating']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <footer>
        <p>&copy; <?= date("Y") ?> My Game Collection</p>
    </footer>
</body>
</html>