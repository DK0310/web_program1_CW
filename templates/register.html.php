<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($showVerifyForm)): ?>
    <!-- Verification Code Form -->
    <div class="card verify-card" style="max-width: 420px; margin: 20px auto; padding: 2em; background: linear-gradient(135deg, #f8faff 0%, #eaf0ff 100%); border-radius: 16px; box-shadow: 0 6px 32px rgba(74,108,247,0.12);">
        <h3 style="text-align:center; color:#4a6cf7; margin-bottom:1em;">📧 Verify Your Email</h3>
        <p style="text-align:center; color:#666; margin-bottom:1.5em;">
            We sent a 6-digit code to <strong><?= htmlspecialchars($_SESSION['register_data']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </p>
        
        <form action="" method="post">
            <label for="code">Enter Verification Code</label>
            <input type="text" name="code" id="code" required maxlength="6" pattern="[0-9]{6}" 
                   placeholder="000000" 
                   style="text-align:center; font-size:1.5em; letter-spacing:8px; font-weight:bold;">
            <br><br>
            <input class="btn" type="submit" name="verify_code" value="Verify & Create Account" style="width:100%;">
        </form>
        
        <p style="text-align:center; margin-top:1.5em; font-size:0.9em; color:#888;">
            Code expires in 5 minutes.<br>
            <a href="register.php" style="color:#4a6cf7;">← Start over</a>
        </p>
    </div>
<?php else: ?>
    <!-- Registration Form -->
    <form action="" method="post">
        <label for="name">Username <span style="color:red;">*</span></label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

        <label for="email">Email <span style="color:red;">*</span></label>
        <input type="email" name="email" id="email" required value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <small style="color:#666; display:block; margin-top:4px;">We'll send a verification code to this email.</small>
        <br><br>

        <label for="password">Password <span style="color:red;">*</span></label>
        <input type="password" name="password" id="password" required><br><br>

        <label for="password_confirm">Confirm Password <span style="color:red;">*</span></label>
        <input type="password" name="password_confirm" id="password_confirm" required><br><br>

        <input class="btn" type="submit" name="send_code" value="Send Verification Code">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
<?php endif; ?>