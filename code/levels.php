<?php 
include 'db.php';

// Get level statistics
$stmt = $pdo->prepare("
    SELECT level, 
           COUNT(DISTINCT user_id) as total_players,
           AVG(score/total * 100) as avg_score
    FROM results 
    GROUP BY level
");
$stmt->execute();
$stats = [];
while ($row = $stmt->fetch()) {
    $stats[$row['level']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Levels - QuizApp</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h1 class="page-title">Quiz Levels</h1>
        
        <div class="levels-grid">
            <div class="level-card">
                <div class="level-header beginner">
                    <h2>Beginner</h2>
                    <span class="time">5 minutes</span>
                </div>
                <div class="level-content">
                    <p>Perfect for those just starting out. Basic knowledge questions across various topics.</p>
                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Beginner']) ? number_format($stats['Beginner']['total_players']) : 0; ?></span>
                            <span class="stat-label">Players</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Beginner']) ? number_format($stats['Beginner']['avg_score'], 1) : 0; ?>%</span>
                            <span class="stat-label">Avg Score</span>
                        </div>
                    </div>
                    <a href="quiz.php?level=Beginner" class="btn btn-primary">Start Quiz</a>
                </div>
            </div>

            <div class="level-card">
                <div class="level-header intermediate">
                    <h2>Intermediate</h2>
                    <span class="time">7 minutes</span>
                </div>
                <div class="level-content">
                    <p>For those ready for a challenge. Questions require deeper understanding.</p>
                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Intermediate']) ? number_format($stats['Intermediate']['total_players']) : 0; ?></span>
                            <span class="stat-label">Players</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Intermediate']) ? number_format($stats['Intermediate']['avg_score'], 1) : 0; ?>%</span>
                            <span class="stat-label">Avg Score</span>
                        </div>
                    </div>
                    <a href="quiz.php?level=Intermediate" class="btn btn-primary">Start Quiz</a>
                </div>
            </div>

            <div class="level-card">
                <div class="level-header advanced">
                    <h2>Advanced</h2>
                    <span class="time">10 minutes</span>
                </div>
                <div class="level-content">
                    <p>Test your expertise with complex questions and detailed topics.</p>
                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Advanced']) ? number_format($stats['Advanced']['total_players']) : 0; ?></span>
                            <span class="stat-label">Players</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Advanced']) ? number_format($stats['Advanced']['avg_score'], 1) : 0; ?>%</span>
                            <span class="stat-label">Avg Score</span>
                        </div>
                    </div>
                    <a href="quiz.php?level=Advanced" class="btn btn-primary">Start Quiz</a>
                </div>
            </div>

            <div class="level-card">
                <div class="level-header master">
                    <h2>Master</h2>
                    <span class="time">12 minutes</span>
                </div>
                <div class="level-content">
                    <p>For true masters. The most challenging questions await.</p>
                    <div class="level-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Master']) ? number_format($stats['Master']['total_players']) : 0; ?></span>
                            <span class="stat-label">Players</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo isset($stats['Master']) ? number_format($stats['Master']['avg_score'], 1) : 0; ?>%</span>
                            <span class="stat-label">Avg Score</span>
                        </div>
                    </div>
                    <a href="quiz.php?level=Master" class="btn btn-primary">Start Quiz</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
