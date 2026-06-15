<?php
require_once __DIR__ . '/includes/header.php';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $messageText = trim($_POST['message'] ?? '');

    if ($name && $email && $messageText) {
        $stmt = $pdo->prepare('INSERT INTO contacts (name, email, message, created_at) VALUES (?, ?, ?, NOW())');
        $stmt->execute([$name, $email, $messageText]);
        $message = 'Thank you! Your message was sent successfully. We will contact you soon.';
    } else {
        $message = 'Please fill in all fields before sending your message.';
    }
}
?>

<section class="section">
    <h2>Contact Us</h2>
    <div class="contact-grid">
        <div class="contact-card">
            <?php if ($message): ?>
                <div class="form-success"><?php echo sanitize($message); ?></div>
            <?php endif; ?>
            <form method="post" action="contact.php" class="contact-form">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="Enter your name" required>

                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>

                <label>Message</label>
                <textarea name="message" rows="6" placeholder="Write your message here..." required></textarea>

                <button class="btn" type="submit">Send Message</button>
            </form>
        </div>
        <div class="contact-details">
            <h3>Our Contact Details</h3>
            <p>Email: support@glowbeauty.com</p>
            <p>Phone: +91 98765 43210</p>
            <p>Address: 25 Beauty Street, Salem, Tamil Nadu, India</p>
            <p>Working Hours: Mon - Sat (9:00 AM - 8:00 PM)</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
