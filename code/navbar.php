<nav class="navbar">
    <div class="navbar-container">
        <a href="index.php" class="navbar-brand">QuizApp</a>
        <div class="navbar-links">
            <a href="index.php">Home</a>
            <a href="levels.php">Levels</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="nav-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="nav-btn">Login</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
        </ul>
    </div>
</nav>
