<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Archive</title>
    <style>
/* Dark Mode Color Palette */
        :root {
            --primary-color: #333333; /* Dark grey */
            --secondary-color: #555555; /* Medium grey */
            --accent-color: #444444; /* Slightly lighter grey */
            --background-light: #222222; /* Very dark background */
            --background-dark: #121212; /* Almost black */
            --text-light: #E0E0E0; /* Light off-white */
            --text-dark: #B0B0B0; /* Soft grey */
            --text-accent: #FF6347; /* Tomato red for accents */
        }

        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(145deg, var(--background-light) 0%, var(--background-dark) 100%);
            color: var(--text-light);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: 100vh;
            padding-top: 60px;
            font-style: italic;
        }

        /* Header */
        header {
            background-color: var(--background-dark);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
            z-index: 100;
        }

        h1 {
            text-align: center;
            color: var(--text-light);
            font-size: 2.5em;
            font-family: 'Roboto Slab', serif;
            text-transform: uppercase;
            font-style: italic;
        }

        /* Main container */
        .container {
            max-width: 1200px;
            width: 90%;
            background-color: rgba(31, 35, 40, 0.85);
            padding: 20px;
            border-radius: 10px;
            margin-top: 80px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        /* Form */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            background-color: rgba(100, 100, 100, 0.2);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(100, 100, 100, 0.3);
        }

        input[type="text"] {
            width: 100%;
            max-width: 350px;
            padding: 12px;
            margin-bottom: 15px;
            border: 2px solid var(--primary-color);
            border-radius: 5px;
            background-color: var(--background-dark);
            color: var(--text-light);
            font-size: 1rem;
            transition: all 0.3s ease-in-out;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 5px var(--accent-color);
        }

        input[type="submit"] {
            padding: 12px 30px;
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: var(--accent-color);
            box-shadow: 0 0 10px rgba(255, 100, 71, 0.5);
        }

        /* Table */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
            background-color: var(--background-dark);
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.4);
        }

        th, td {
            padding: 15px;
            text-align: center;
            color: var(--text-light);
            font-size: 1rem;
        }

        th {
            background-color: var(--primary-color);
            font-size: 1.1rem;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: rgba(41, 46, 54, 0.7);
        }

        tr:hover {
            background-color: var(--primary-color);
            color: var(--text-dark);
            cursor: pointer;
        }

        /* Links */
        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
            text-transform: uppercase;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--accent-color);
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: var(--background-dark);
            color: var(--primary-color);
            margin-top: 40px;
            width: 100%;
            border-top: 3px solid var(--primary-color);
        }

        /* Error Message */
        .error-message {
            color: var(--accent-color);
            font-size: 1.2rem;
            font-weight: bold;
            text-align: center;
            background-color: rgba(255, 100, 71, 0.2);
            border: 2px dashed var(--primary-color);
            padding: 20px;
            margin: 20px auto;
            width: fit-content;
            max-width: 80%;
            border-radius: 6px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            input[type="text"] {
                width: 100%;
                margin-bottom: 10px;
            }

            table {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 1.5em;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1> Vediogames </h1>
    </header>

    <div class="container">
        <?php
        // Connect to database
        $mysqli = new mysqli("localhost", "2440623", "Dharam@123456", "db2440623");

        if ($mysqli->connect_errno) {
            // Reverted to a standard, less dramatic error message
            echo "<p class='error-message'>ERROR: Failed to connect to MySQL: " . $mysqli->connect_error . "</p>";
        }

        // Run SQL query
        $sql = "SELECT * FROM games ORDER BY rating DESC";
        $results = isset($mysqli) && !$mysqli->connect_errno ? $mysqli->query($sql) : null;
        ?>

        <form action="search.php" method="post">
        <input type="text" name="keywords" placeholder="Search for a game...">
        <input type="submit" value="Search"> </form>
	 <a href="add-game-form.php" class="btn btn-primary">Add game here..</a>


        <table>
            <thead>
                <tr>
                    <th> Game Name</th>
                    <th> Release Date</th>
                    <th> IMDB Rating</th>
					
                </tr>
            </thead>
            <tbody>
                <?php
                // Mock data if the connection failed, to show the style
                if (!$results || (isset($results) && $results->num_rows === 0)) {
                    $mock_data = [
                        ['game_name' => 'Desert Runner 404', 'released_date' => '2077-10-23', 'rating' => '9.2'],
                        ['game_name' => 'Spice Harvester: The Board Game', 'released_date' => '1984-12-18', 'rating' => '8.8'],
                        ['game_name' => 'Neon District Protocol', 'released_date' => '2049-05-15', 'rating' => '7.9'],
                        ['game_name' => 'Fremen Tactics Simulator', 'released_date' => '2025-01-01', 'rating' => '9.5']
                    ];
                    foreach ($mock_data as $index => $row):
                ?>
                <tr>
                    <td>
                        <a href="details.php?id=<?= $index + 100 ?>">
                            <?= htmlspecialchars($row['game_name']) ?>
                        </a>
                    </td>
                    <td><?= htmlspecialchars($row['released_date']) ?></td>
                    <td>
                        <span style="color: #FF1493; text-shadow: 0 0 10px rgba(255, 20, 147, 0.9);">
                            <?= htmlspecialchars($row['rating']) ?>
                        </span>
                    </td>
                    <td> <a href="delete.php?id=<?= $index + 100 ?>"
                           onclick="return confirm('Are you sure you want to delete \'<?= htmlspecialchars($row['game_name']) ?>\'?');"
                           class="delete-btn">
                            [Remove]
                        </a>
                    </td>
                </tr>
                <?php
                    endforeach;
                } else {
                    // Original PHP logic if connection succeeded
                    while ($a_row = $results->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <a href="details.php?id=<?= htmlspecialchars($a_row['game_ID']) ?>">
                                <?= htmlspecialchars($a_row['game_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($a_row['released_date']) ?></td>
                        <td>
                            <span style="color: #FF1493; text-shadow: 0 0 10px rgba(255, 20, 147, 0.9);">
                                <?= htmlspecialchars($a_row['rating']) ?>
                            </span>
                        </td>
                        <td> <a href="delete.php?id=<?= htmlspecialchars($a_row['game_ID']) ?>" 
                               onclick="return confirm('Are you sure you want to delete \'<?= htmlspecialchars($a_row['game_name']) ?>\'?');"
                               class="delete-btn">
                                [Remove]
                            </a>
                        </td>
						
					<td> 
                        <a href="edit.php?ID=<?= htmlspecialchars($a_row['game_ID']) ?>" class="edit-btn">
        [Change]
    </a>
                    </td>
                    </tr>
                    <?php endwhile;
                }
                ?>
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; <?= date("Y") ?> **Game Archive** | Data Stable</p> </footer>
</body>
</html>