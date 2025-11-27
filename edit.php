<?php
// edit.php - Edit a game record

// DB connection (same credentials you used elsewhere)
$mysqli = new mysqli("localhost", "2440623", "Dharam@123456", "db2440623");
if ($mysqli->connect_errno) {
    die("<p class='error-message'>ERROR: Failed to connect to MySQL: " . $mysqli->connect_error . "</p>");
}

// Accept either ?ID= or ?id=
if (isset($_GET['ID'])) {
    $id = intval($_GET['ID']);
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    die("No game selected.");
}

// Fetch existing game data
$stmt = $mysqli->prepare("SELECT game_ID, game_name, game_description, released_date, rating FROM games WHERE game_ID = ?");
if (!$stmt) { die("Prepare failed: " . $mysqli->error); }
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Game not found.");
}
$game = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // field names changed to game_description
    $name         = trim($_POST['game_name']);
    $description  = trim($_POST['game_description']);  // changed
    $release_date = trim($_POST['released_date']);
    $rating       = trim($_POST['rating']);

    // Basic validation
    if ($name === '' || $description === '' || $release_date === '' || $rating === '') {
        $error = "All fields are required.";
    } else {
        $update = $mysqli->prepare("
            UPDATE games
            SET game_name = ?, game_description = ?, released_date = ?, rating = ?
            WHERE game_ID = ?
        ");

        if (!$update) {
            die("Prepare failed: " . $mysqli->error);
        }

        // Bind parameters
        $update->bind_param("ssssi", $name, $description, $release_date, $rating, $id);

        if ($update->execute()) {
            $update->close();
            header("Location: games.php");
            exit;
        } else {
            $error = "Error updating: " . $mysqli->error;
            $update->close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Game</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
<style>
body { font-family: 'Orbitron', sans-serif, 'Consolas', monospace; background: linear-gradient(145deg,#292E36 0%,#1F2328 100%); color:#EAE0CF; margin:0; padding:0; }
.navbar { background:rgba(31,35,40,0.98); border-bottom:3px solid #FF1493; padding:20px; text-align:center; font-size:1.5em; }
.container { max-width:800px; margin:40px auto; padding:20px; }
.card { background:rgba(31,35,40,0.9); padding:30px; border-radius:10px; border:1px solid rgba(0,206,209,0.2); }
label { color:#00CED1; display:block; margin-top:15px; font-weight:bold; }
input, textarea { width:100%; padding:12px; margin-top:5px; background:#1F2328; color:#EAE0CF; border:2px solid #FF1493; border-radius:5px; box-sizing:border-box; }
button { padding:12px 25px; background:#00CED1; color:#1F2328; border:none; border-radius:8px; cursor:pointer; margin-top:20px; font-weight:bold; }
.back-btn { display:inline-block; margin-top:20px; padding:10px 20px; background:#444953; color:#EAE0CF; text-decoration:none; border-radius:6px; }
.error { color:#ffb3b3; margin-top:10px; }
</style>
</head>
<body>
<div class="navbar"><h2>✏ Edit Game Record</h2></div>
<div class="container">
    <div class="card">
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="game_name">Game Name:</label>
            <input type="text" id="game_name" name="game_name" value="<?= htmlspecialchars($game['game_name']) ?>" required>

            <label for="game_description">Game Description:</label>
            <textarea id="game_description" name="game_description" rows="5" required><?= htmlspecialchars($game['game_description']) ?></textarea>

            <label for="released_date">Release Date:</label>
            <input type="date" id="released_date" name="released_date" value="<?= htmlspecialchars($game['released_date']) ?>" required>

            <label for="rating">Rating:</label>
            <input type="text" id="rating" name="rating" value="<?= htmlspecialchars($game['rating']) ?>" required>

            <button type="submit">💾 Save Changes</button>
        </form>

        <a href="games.php" class="back-btn">⬅ Back to List</a>
    </div>
</div>
</body>
</html>
