<?php
// Connection to the database
require_once __DIR__ . '/../../db/Database.php';

// New instance of the Database class and connection to the database
$db = new Database();
if (!$db->connectToDB('kidsGames')) {
    die($db->getLastErrorMessage());
}

// Initialize the game with 6 lives if necessary.
session_start();
if (!isset($_SESSION['lives'])) {
  $_SESSION['lives'] = 6;
}

// Fetch registrationOrder for the logged-in user in order to be able to insert it into the score table.
$sql = "SELECT registrationOrder FROM player WHERE id = ?";
$stmt = $db->prepare($sql);
$stmt->bind_param("i", $_SESSION['player_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if ($user === null) {
    die('No user found with the provided ID.');
}
$registrationOrder = $user['registrationOrder'];

// Function to randomize the letters.
function shuffleLetters() {
  $letters = range('Z', 'A'); // Changed to shuffle in descending order
  shuffle($letters);
  return array_slice($letters, 0, 6);
}

// Function to check if the player's letters are correct and in descending order.
function checkAnswer($userLetters, $shuffledLetters) {
    foreach ($userLetters as $userLetter) {
    if (!in_array(strtoupper($userLetter), $shuffledLetters)) {
      return false;
    }
  }
  
  $sortedLetters = $userLetters;
  rsort($sortedLetters); // Changed to check descending order
  return $userLetters === $sortedLetters;
}

// Verification if the form was submitted.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if the abandon button was clicked
  if (isset($_POST['abandon'])) {
    // Define the values for game_status and lives_used
    $game_status = "incomplet";
    $lives_used = 6 - $_SESSION['lives'];

    // Insert data into the score table
    $sql = "INSERT INTO score (livesUsed, scoreTime, result, registrationOrder) VALUES (?, NOW(), ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("iss", $lives_used, $game_status, $registrationOrder);
    $stmt->execute();

    // Restore lives to 6
    $_SESSION['lives'] = 6;

    // Redirect to UserMenu.php
    header("Location: UserMenu.php");
    exit;
  } else {
    // Get the letters from the player.
    $userLetters = $_POST['letters'];

    // Get the shuffled letters.
    $shuffledLetters = $_SESSION['shuffledLetters'];

    // Verify if the letters are correct and in order.
    if (checkAnswer($userLetters, $shuffledLetters)) { // Replace with the correct function for Question 2
      $message = "Correct – Your letters have been correctly ordered in ascending order.";

      // Next question button.
      $nextQuestionButton = '<button onclick="location.href=\'Question_3.php\'">Next Question</button>'; // Redirect to the next question
      
    } else {
      $message = "Incorrect – Your letters were not correctly arranged in ascending order or you entered a letter that was not shown.";
      // Deduct the player's lives if makes mistake.
      $_SESSION['lives']--;
      // Verify if the player still has lives.
      if ($_SESSION['lives'] <= 0) {
        // Game Over and redifine the the lives to 6.
        $message .= " Game Over!";
        $tryAgainButton = '<button onclick="location.href=\'Question_1.php\'">Try again</button>'; // Redirect to the current question
        $quitButton = '<button onclick="location.href=\'UserMenu.php\'">Quit</button>'; // Add this line
        $_SESSION['lives'] = 6;
    
        // Insert data into the score table
        $sql = "INSERT INTO score (livesUsed, scoreTime, result, registrationOrder) VALUES (?, NOW(), ?, ?)";
        $stmt = $db->prepare($sql);
        $game_status = "échec"; // Set game_status to 'Game Over'
        $lives_used = 6;
        $stmt->bind_param("iss", $lives_used, $game_status, $registrationOrder);
        $stmt->execute();
    }
    }
  }
}

// Shuffle the letters and store them in the session.
$_SESSION['shuffledLetters'] = shuffleLetters();
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Level 2: Order the letters in descending order</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
<h1>Level 2</h1>
<h2>Order the letters in descending order</h2>

<!-- Abandon button -->
<?php if (!isset($tryAgainButton)) : ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <button type="submit" name="abandon">Abandon</button>
</form>
<?php endif; ?>

<?php if (!isset($tryAgainButton) && !isset($nextQuestionButton)) : ?>
<h4>Shuffled Letters:
<?php
// Display the shuffled letters.
foreach ($_SESSION['shuffledLetters'] as $letter) {
  echo "$letter ";
}
?>
</h4>
<?php endif; ?>

<!-- Display the lives during the game. -->
<?php if (!isset($tryAgainButton)) : ?>
  <p>(Lives: <?php echo $_SESSION['lives']; ?>)</p>
<?php endif; ?>


<!-- Display output message. -->
<?php if (isset($message)) : ?>
  <p><?php echo $message; ?></p>
<?php endif; ?>

<!-- Display the buttons "Next Question", "Try Again" and "Quit" in each situation. -->
<?php if (isset($nextQuestionButton)) echo $nextQuestionButton; ?>
<?php if (isset($tryAgainButton)) echo $tryAgainButton; ?>
<?php if (isset($quitButton)) echo $quitButton; ?>

<br><br> 

<!-- Display the form only during the game. -->
<?php if (!isset($tryAgainButton) && !isset($nextQuestionButton)) : ?>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <?php
  // Display input fields.
  for ($i = 0; $i < 6; $i++) {
    echo '<label for="letter' . ($i + 1) . '">Letter ' . ($i + 1) . ':</label>';
    echo '<input type="text" id="letter' . ($i + 1) . '" name="letters[]" maxlength="1" required><br><br>';
  }
  ?>
  <button type="submit">Submit</button>
</form>
<?php endif; ?>

</body>
</html>
