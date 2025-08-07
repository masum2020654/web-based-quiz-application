<?php

class QuestionBank {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getRandomQuestions($level, $count = 20) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM questions 
            WHERE level = :level 
            ORDER BY RAND() 
            LIMIT :count
        ");
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
        $stmt->bindParam(':count', $count, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addQuestion($question, $level) {
        $stmt = $this->pdo->prepare("
            INSERT INTO questions (question_text, level) 
            VALUES (:question, :level)
        ");
        $stmt->bindParam(':question', $question);
        $stmt->bindParam(':level', $level);
        return $stmt->execute();
    }
}
