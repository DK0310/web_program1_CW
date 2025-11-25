
<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div style="max-width: 500px; margin: 0 auto;">
    <h2 style="margin-bottom: 1em; color: #333;">Verify Your Email</h2>
    
    <p style="margin-bottom: 1.5em; color: #666; line-height: 1.6;">
        We've sent a 6-digit verification code to <strong><?= htmlspecialchars($_SESSION['reset_email'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
    </p>

    <form method="post" action="" id="verifyForm">
        <label for="code">Verification Code</label>
        <input 
            type="text" 
            name="code" 
            id="code" 
            required 
            pattern="\d{6}"
            maxlength="6"
            autocomplete="off"
            style="font-size: 1.3em; letter-spacing: 0.3em; text-align: center;"
        >
        <small style="display: block; margin-top: 0.5em; color: #666;">
            Enter the 6-digit code sent to your email
        </small>
        
        <div style="margin-top: 1.5em;">
            <button type="submit" class="btn" style="width: 100%;">Verify Code</button>
        </div>
    </form>

    <div style="margin-top: 2em; padding-top: 1.5em; border-top: 1px solid #e9ecef; text-align: center;">
        <p style="color: #666; margin-bottom: 0.5em;">Didn't receive the code?</p>
        <a href="send_code.php" class="btn">Request New Code</a>
    </div>
</div>
