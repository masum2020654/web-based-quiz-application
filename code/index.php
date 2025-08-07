<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to QuizApp</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="landing-hero">
        <div class="hero-content animate__animated animate__fadeIn">
            <h1>Test Your Knowledge</h1>
            <p class="hero-subtitle">Challenge yourself with our interactive quizzes</p>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="cta-buttons">
                    <a href="login.php" class="btn-glow">Get Started</a>
                    <a href="register.php" class="btn-outline">Create Account</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="wave-container">
            <svg class="wave" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120">
                <path fill="#ffffff" fill-opacity="1" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,58.7C960,64,1056,64,1152,58.7C1248,53,1344,43,1392,37.3L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
            </svg>
        </div>
    </div>

    <div class="features-section">
        <h2 class="section-title">Quiz Levels</h2>
        <div class="features-grid">
            <div class="feature-card animate__animated animate__fadeInUp">
                <div class="feature-icon beginner-icon">🌱</div>
                <h3>Beginner</h3>
                <p>Start your journey with basic questions</p>
                <div class="card-overlay">
                    <a href="quiz.php?level=Beginner" class="btn-feature">Start Quiz</a>
                </div>
            </div>
            <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                <div class="feature-icon intermediate-icon">⭐</div>
                <h3>Intermediate</h3>
                <p>Challenge yourself with harder questions</p>
                <div class="card-overlay">
                    <a href="quiz.php?level=Intermediate" class="btn-feature">Start Quiz</a>
                </div>
            </div>
            <div class="feature-card animate__animated animate__fadeInUp" style="animation-delay: 0.4s">
                <div class="feature-icon advanced-icon">🚀</div>
                <h3>Advanced</h3>
                <p>Test your expertise with complex topics</p>
                <div class="card-overlay">
                    <a href="quiz.php?level=Advanced" class="btn-feature">Start Quiz</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
