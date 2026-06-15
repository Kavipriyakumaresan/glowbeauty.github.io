<?php
require_once __DIR__ . '/includes/header.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if ($email && $password) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            header('Location: index.php');
            exit;
        }
        $error = 'Invalid email or password.';
    } else {
        $error = 'Please enter both email and password.';
    }
}
?>

<section class="section">
    <h2>Login</h2>
    <div class="auth-card">
        <?php if ($error): ?>
            <div class="form-error"><?php echo sanitize($error); ?></div>
        <?php endif; ?>
        <form method="post" action="login.php">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button class="btn" type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register now</a></p>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
