<?php
require_once 'config.php';
require_once 'classes/QuestionBank.php';

$questionBank = new QuestionBank($pdo);

// Helper function to shuffle and limit questions
function getRandomQuestions($questions, $count) {
    shuffle($questions);
    return array_slice($questions, 0, $count);
}

// Define questions for each level
$level1Questions = array_merge(
    // Basic Math (50 questions)
    array_map(function($i) { 
        return "What is " . $i . " + " . ($i + 1) . "?";
    }, range(1, 25)),
    array_map(function($i) { 
        return "What is " . $i . " × " . ($i + 1) . "?";
    }, range(1, 25)),
    
    // Basic Geography (50 questions)
    [
        "What is the capital of France?", "What is the capital of Japan?",
        // ...add 48 more geography questions...
    ],
    
    // General Knowledge (50 questions)
    [
        "What is the color of the sky?", "How many days are in a week?",
        // ...add 48 more general knowledge questions...
    ],
    
    // Science (50 questions)
    [
        "What is the closest planet to the Sun?", "What is the chemical symbol for water?",
        // ...add 48 more science questions...
    ],
    
    // History (50 questions)
    [
        "Who was the first President of the United States?", "In which year did World War II end?",
        // ...add 48 more history questions...
    ]
);

$level2Questions = array_merge(
    // Intermediate Math (50 questions)
    array_map(function($i) { 
        return "What is the square root of " . ($i * $i) . "?";
    }, range(1, 50)),
    
    // Science & Technology (50 questions)
    [
        "What is Newton's First Law of Motion?", "How does photosynthesis work?",
        // ...add 48 more science questions...
    ],
    
    // World History (50 questions)
    [
        "Who was Alexander the Great?", "What caused World War I?",
        // ...add 48 more history questions...
    ],
    
    // Literature (50 questions)
    [
        "Who wrote Hamlet?", "What is the theme of To Kill a Mockingbird?",
        // ...add 48 more literature questions...
    ],
    
    // Geography & Culture (50 questions)
    [
        "What are the major tectonic plates?", "What is the longest river in the world?",
        // ...add 48 more geography questions...
    ]
);

$level3Questions = array_merge(
    // Advanced Science (50 questions)
    [
        "Explain quantum entanglement.", "What is the Heisenberg Uncertainty Principle?",
        // ...add 48 more advanced science questions...
    ],
    
    // Advanced Math (50 questions)
    [
        "Explain the Riemann Hypothesis.", "What is the significance of Euler's number?",
        // ...add 48 more advanced math questions...
    ],
    
    // Philosophy & Logic (50 questions)
    [
        "Explain Plato's Theory of Forms.", "What is categorical imperative?",
        // ...add 48 more philosophy questions...
    ],
    
    // Advanced Technology (50 questions)
    [
        "How does quantum computing work?", "Explain blockchain technology.",
        // ...add 48 more technology questions...
    ],
    
    // Research & Methodology (50 questions)
    [
        "What is the scientific method?", "Explain statistical significance.",
        // ...add 48 more research questions...
    ]
);

$questionsByLevel = [
    1 => array_slice($level1Questions, 0, 250),
    2 => array_slice($level2Questions, 0, 250),
    3 => array_slice($level3Questions, 0, 250)
];

// Seed the questions
foreach ($questionsByLevel as $level => $questions) {
    foreach ($questions as $question) {
        $questionBank->addQuestion($question, $level);
    }
    echo "Added " . count($questions) . " questions for level $level\n";
}

echo "Questions seeded successfully!";
