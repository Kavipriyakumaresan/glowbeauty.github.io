<?php
require_once __DIR__ . '/includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    if ($name && $email && $password && $confirmPassword) {
        if ($password !== $confirmPassword) {
            $error = 'Passwords do not match.';
        } else {
            $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ?');
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'This email is already registered.';
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, created_at) VALUES (?, ?, ?, NOW())');
                $stmt->execute([$name, $email, $hash]);
                header('Location: login.php');
                exit;
            }
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>

<section class="section">
    <h2>Register</h2>
    <div class="auth-card">
        <?php if ($error): ?>
            <div class="form-error"><?php echo sanitize($error); ?></div>
        <?php endif; ?>
        <form method="post" action="register.php">
            <label>Full Name</label>
            <input type="text" name="name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button class="btn" type="submit">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
