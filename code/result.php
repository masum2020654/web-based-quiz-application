<?php 
session_start();
include 'db.php';

if (!isset($_SESSION['last_result_id'])) {
    $_SESSION['error'] = "No quiz result found.";
    header('Location: error.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Result - QuizApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'navbar.php'; ?>
<section class="result-section">
    <h2>Quiz Result</h2>
    <div class="result-card">
        <h3>Quiz Summary</h3>
        <p><b>Level:</b> <?php echo htmlspecialchars($_SESSION['last_level']); ?></p>
        <p><b>Score:</b> <?php echo $_SESSION['last_score']; ?> / <?php echo $_SESSION['last_total']; ?></p>
        <p><b>Percentage:</b> <?php echo round(($_SESSION['last_score'] / $_SESSION['last_total']) * 100, 1); ?>%</p>
        
        <?php if (isset($_SESSION['last_result_id'])): 
            $stmt = $pdo->prepare("
                SELECT 
                    q.question,
                    q.correct_option,
                    q.option_a,
                    q.option_b,
                    q.option_c,
                    q.option_d,
                    ua.selected_option
                FROM user_answers ua
                JOIN questions q ON q.id = ua.question_id
                WHERE ua.result_id = ?
                ORDER BY ua.id
            ");
            $stmt->execute([$_SESSION['last_result_id']]);
            while ($row = $stmt->fetch()): ?>
                <div class="question-result <?php echo $row['selected_option'] === $row['correct_option'] ? 'correct' : 'incorrect'; ?>">
                    <p class="question-text"><?php echo htmlspecialchars($row['question']); ?></p>
                    <p class="your-answer">Your answer: Option <?php echo $row['selected_option']; ?> - <?php echo htmlspecialchars($row['option_' . strtolower($row['selected_option'])]); ?></p>
                    <p class="correct-answer">Correct answer: Option <?php echo $row['correct_option']; ?> - <?php echo htmlspecialchars($row['option_' . strtolower($row['correct_option'])]); ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
        
        <div class="result-actions">
            <a href="quiz.php?level=<?php echo urlencode($_SESSION['last_level']); ?>" class="btn">Try Again</a>
            <a href="index.php" class="btn">Back to Home</a>
        </div>
    </div>
    <?php unset($_SESSION['last_score'], $_SESSION['last_total'], $_SESSION['last_level'], $_SESSION['last_result_id']); ?>
</section>
</body>
</html>
