<?php if (!empty($error)): ?>
    <div class="errors center" style="margin-bottom: 1.5em; padding: 1em; background: #ffeaea; color: #d32f2f; border-radius: 8px; border: 1px solid #f8d7da; font-size: 1.05em; text-align: center; box-shadow: 0 2px 8px rgba(211,47,47,0.08);">
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="success center" style="margin-bottom: 1.5em; padding: 1em; background: #eaf7ff; color: #1976d2; border-radius: 8px; border: 1px solid #b3e5fc; font-size: 1.05em; text-align: center; box-shadow: 0 2px 8px rgba(25,118,210,0.08);">
        <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
    </div>
<?php endif; ?>

<div class="card verify-card" style="max-width: 420px; margin: 40px auto; box-shadow: 0 6px 32px rgba(74,108,247,0.12); border-radius: 16px; background: linear-gradient(135deg, #f8faff 0%, #eaf0ff 100%); padding: 2.5em 2em;">
    <h2 class="center" style="margin-bottom: 1em; color: #4a6cf7; font-weight: 700; letter-spacing: 0.02em; font-size: 2em;">Verify Your Email</h2>
    <p style="margin-bottom: 2em; color: #555; line-height: 1.7; text-align: center; font-size: 1.08em;">
        Please enter the 6-digit verification code sent to your email address.<br>
        <span style="color:#4a6cf7; font-weight:500;">Check your inbox and spam folder.</span>
    </p>
    <form method="post" action="" id="verifyForm" style="margin-bottom: 0; display: flex; flex-direction: column; gap: 1.2em; align-items: center;">
        <input type="text" name="code" maxlength="6" pattern="[0-9]{6}" required placeholder="Enter code" style="width: 60%; padding: 0.8em 1em; font-size: 1.15em; border-radius: 8px; border: 1px solid #e0e7ff; background: #fff; box-shadow: 0 1px 4px rgba(74,108,247,0.04); text-align: center; letter-spacing: 0.15em; margin-bottom: 0.5em;">
        <button class="btn" type="submit" style="width: 70%; font-size: 1.1em; padding: 0.8em 0; border-radius: 8px; background: linear-gradient(90deg,#4a6cf7 0%,#6a82fb 100%); color: #fff; font-weight: 600; box-shadow: 0 2px 8px rgba(74,108,247,0.12); border: none; transition: background 0.2s;">Verify</button>
    </form>
    <div style="margin-top: 2em; padding-top: 1.5em; border-top: 1px solid #e9ecef; text-align: center; color: #888; font-size: 0.98em;">
        Didn't receive the code? <a href="forgot.php" style="color: #4a6cf7; text-decoration: underline; font-weight: 500;">Resend</a>
    </div>
</div>
