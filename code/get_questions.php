<?php
session_start();
require_once 'config.php';
require_once 'classes/QuestionBank.php';

header('Content-Type: application/json');

try {
    // Validate and map level parameter
    $levelMap = [
        'Beginner' => 'Beginner',
        'Intermediate' => 'Intermediate',
        'Advanced' => 'Advanced',
        'Master' => 'Master'
    ];
    
    $level = isset($_GET['level']) ? $_GET['level'] : 'Beginner';
    if (!array_key_exists($level, $levelMap)) {
        throw new Exception('Invalid level specified');
    }
    
    // Validate count
    $count = isset($_GET['count']) ? (int)$_GET['count'] : 20;
    if ($count < 1 || $count > 50) {
        throw new Exception('Count must be between 1 and 50');
    }

    $questionBank = new QuestionBank($pdo);
    $questions = $questionBank->getRandomQuestions($levelMap[$level], $count);

    if (empty($questions)) {
        throw new Exception('No questions available for this level');
    }

    echo json_encode([
        'success' => true,
        'level' => $level,
        'count' => count($questions),
        'questions' => $questions
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
