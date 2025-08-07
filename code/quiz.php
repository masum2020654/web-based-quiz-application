<?php
session_start();
include 'db.php';

// Validate level parameter
$allowed_levels = ['Beginner', 'Intermediate', 'Advanced', 'Master'];
$level = isset($_GET['level']) && in_array($_GET['level'], $allowed_levels) ? $_GET['level'] : 'Beginner';

$time_limits = [
    'Beginner' => 5,
    'Intermediate' => 7,
    'Advanced' => 10,
    'Master' => 12
];
$minutes = $time_limits[$level] ?? 5;

// User tracking
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'User' . rand(1000,9999);
    $_SESSION['session_id'] = session_id();
    // Insert user if not exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE session_id = ?");
    $stmt->execute([$_SESSION['session_id']]);
    if (!$stmt->fetch()) {
        $stmt = $pdo->prepare("INSERT INTO users (username, session_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['username'], $_SESSION['session_id']]);
    }
}

// Fetch questions
$stmt = $pdo->prepare("SELECT * FROM questions WHERE level = ? ORDER BY RAND() LIMIT 20");
$stmt->execute([$level]);
$questions = $stmt->fetchAll();

// Validate questions exist
if (empty($questions)) {
    $_SESSION['error'] = "No questions available for this level.";
    header('Location: error.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($level); ?> Quiz - QuizApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="quiz-section">
    <h2><?php echo htmlspecialchars($level); ?> Level Quiz</h2>
    <div class="timer" id="timer"><?php echo $minutes; ?>:00</div>
    <form id="quizForm" action="submit_quiz.php" method="POST">
        <input type="hidden" name="level" value="<?php echo htmlspecialchars($level); ?>">
        <?php foreach ($questions as $i => $q): ?>
            <div class="question-card">
                <p class="question"><b>Q<?php echo $i+1; ?>:</b> <?php echo htmlspecialchars($q['question']); ?></p>
                <div class="options">
                    <label><input type="radio" name="answers[<?php echo $q['id']; ?>]" value="A" required> <?php echo htmlspecialchars($q['option_a']); ?></label>
                    <label><input type="radio" name="answers[<?php echo $q['id']; ?>]" value="B"> <?php echo htmlspecialchars($q['option_b']); ?></label>
                    <label><input type="radio" name="answers[<?php echo $q['id']; ?>]" value="C"> <?php echo htmlspecialchars($q['option_c']); ?></label>
                    <label><input type="radio" name="answers[<?php echo $q['id']; ?>]" value="D"> <?php echo htmlspecialchars($q['option_d']); ?></label>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="submit-btn">Submit Quiz</button>
    </form>
</section>
<script>
let totalSeconds = <?php echo $minutes * 60; ?>;
let timer = document.getElementById('timer');
let quizForm = document.getElementById('quizForm');
let interval = setInterval(function() {
    let min = Math.floor(totalSeconds / 60);
    let sec = totalSeconds % 60;
    timer.textContent = min + ':' + (sec < 10 ? '0' : '') + sec;
    if (totalSeconds <= 0) {
        clearInterval(interval);
        alert('Time is up! Submitting your quiz.');
        quizForm.submit();
    }
    totalSeconds--;
}, 1000);
</script>
<script src="script.js"></script>
</body>
</html>
