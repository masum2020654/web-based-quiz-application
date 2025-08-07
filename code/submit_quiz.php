<?php
session_start();
include 'db.php';

// First check if user has an active session
if (!isset($_SESSION['session_id'])) {
    $_SESSION['session_id'] = session_id();
}

// Check for existing user or create guest user
$stmt = $pdo->prepare("SELECT id FROM users WHERE session_id = ?");
$stmt->execute([$_SESSION['session_id']]);
$user = $stmt->fetch();

if (!$user) {
    $guest_username = 'Guest_' . substr($_SESSION['session_id'], 0, 8);
    $guest_email = $guest_username . '@temporary.com';
    $guest_password = password_hash('guest' . $_SESSION['session_id'], PASSWORD_DEFAULT);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, session_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$guest_username, $guest_email, $guest_password, $_SESSION['session_id']]);
        $user_id = $pdo->lastInsertId();
    } catch (PDOException $e) {
        // If duplicate entry, try to get existing user id
        if ($e->getCode() == '23000') {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$guest_email]);
            $user = $stmt->fetch();
            $user_id = $user['id'];
        } else {
            throw $e;
        }
    }
} else {
    $user_id = $user['id'];
}

if (!isset($_POST['answers'], $_POST['level'])) {
    header('Location: index.php');
    exit;
}

$level = $_POST['level'];
$answers = $_POST['answers'];
$question_ids = array_keys($answers);

// Fetch correct answers
$in  = str_repeat('?,', count($question_ids) - 1) . '?';
$stmt = $pdo->prepare("SELECT id, correct_option FROM questions WHERE id IN ($in)");
$stmt->execute($question_ids);
$correct = [];
while ($row = $stmt->fetch()) {
    $correct[$row['id']] = $row['correct_option'];
}

// Score calculation
$score = 0;
foreach ($answers as $qid => $ans) {
    if (isset($correct[$qid]) && $correct[$qid] == $ans) {
        $score++;
    }
}

// Store result
$stmt = $pdo->prepare("SELECT id FROM users WHERE session_id = ?");
$stmt->execute([$_SESSION['session_id']]);
$user = $stmt->fetch();
$user_id = $user ? $user['id'] : null;

if (!$user_id) {
    // If no user found, create one
    $stmt = $pdo->prepare("INSERT INTO users (username, session_id) VALUES (?, ?)");
    $stmt->execute(['Guest_' . substr($_SESSION['session_id'], 0, 8), $_SESSION['session_id']]);
    $user_id = $pdo->lastInsertId();
}

try {
    $pdo->beginTransaction();
    
    // Insert result
    $stmt = $pdo->prepare("INSERT INTO results (user_id, level, score, total) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $level, $score, count($question_ids)]);
    $result_id = $pdo->lastInsertId();
    
    // Store each answer with question details
    $stmt = $pdo->prepare("INSERT INTO user_answers (result_id, question_id, selected_option) VALUES (?, ?, ?)");
    foreach ($answers as $qid => $ans) {
        $stmt->execute([$result_id, $qid, $ans]);
    }
    
    $_SESSION['last_result_id'] = $result_id;
    $_SESSION['last_score'] = $score;
    $_SESSION['last_total'] = count($question_ids);
    $_SESSION['last_level'] = $level;
    
    $pdo->commit();
    header('Location: result.php');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Quiz submission error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while saving your results.";
    header('Location: error.php');
    exit;
}
?>
