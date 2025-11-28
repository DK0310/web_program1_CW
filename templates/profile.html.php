<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h2>My Profile</h2>

<?php if (!empty($showEmailVerifyForm)): ?>
    <!-- Email Verification Form -->
    <div class="card verify-card" style="max-width: 450px; margin: 20px auto; padding: 2em; background: linear-gradient(135deg, #f8faff 0%, #eaf0ff 100%); border-radius: 16px; box-shadow: 0 6px 32px rgba(74,108,247,0.12);">
        <h3 style="text-align:center; color:#4a6cf7; margin-bottom:1em;">📧 Verify New Email</h3>
        <p style="text-align:center; color:#666; margin-bottom:1.5em;">
            We sent a 6-digit code to:<br>
            <strong style="color:#4a6cf7;"><?= htmlspecialchars($_SESSION['email_change_data']['new_email'] ?? '', ENT_QUOTES, 'UTF-8') ?></strong>
        </p>
        
        <form action="" method="post">
            <label for="email_code">Enter Verification Code</label>
            <input type="text" name="email_code" id="email_code" required maxlength="6" pattern="[0-9]{6}" 
                   placeholder="000000" 
                   style="text-align:center; font-size:1.5em; letter-spacing:8px; font-weight:bold; width:100%; margin-bottom:1em;">
            <input class="btn" type="submit" name="verify_email_code" value="Verify & Update Email" style="width:100%;">
        </form>
        
        <form action="" method="post" style="margin-top:1em;">
            <button class="btn secondary" type="submit" name="cancel_email_change" value="1" style="width:100%;">Cancel Email Change</button>
        </form>
        
        <p style="text-align:center; margin-top:1em; font-size:0.85em; color:#888;">
            Code expires in 5 minutes.
        </p>
    </div>
<?php else: ?>
    <!-- Profile Display and Edit Form -->
    <div class="profile-card" style="display:flex;align-items:center;gap:2em;margin-bottom:2em;">
    <?php 
    $avatarPath = '';
    if (!empty($user['user_image'])) {
        // Handle both cases: with and without 'images/' prefix
        if (strpos($user['user_image'], 'images/') === 0) {
            $avatarPath = $user['user_image'];
        } else {
            $avatarPath = 'images/' . $user['user_image'];
        }
    }
    ?>
    <?php if (!empty($user['user_image']) && file_exists($avatarPath)): ?>
        <img src="<?= htmlspecialchars($avatarPath, ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="avatar-img" style="width:80px;height:80px;border-radius:50%;object-fit:cover;box-shadow:0 2px 8px rgba(74,108,247,0.10);">
    <?php else: ?>
        <div class="avatar" style="width:80px;height:80px;border-radius:50%;background:#eaf0ff;color:#4a6cf7;display:flex;align-items:center;justify-content:center;font-size:2.5em;font-weight:700;box-shadow:0 2px 8px rgba(74,108,247,0.10);">
            <?= strtoupper(substr($user['name'] ?? 'A',0,1)) ?>
        </div>
    <?php endif; ?>
    <div>
        <div style="font-size:1.3em;font-weight:600;">Name: <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?></div>
        <div style="color:#555;">Email: <?= htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') ?></div>
    </div>
</div>
<form action="" method="post" enctype="multipart/form-data" style="max-width:420px;">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="width:100%;margin-bottom:1em;">

    <label for="email">Email</label>
    <input type="email" name="email" id="email" required value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" style="width:100%;margin-bottom:0.3em;">
    <small style="color:#666; display:block; margin-bottom:1em;">Changing email requires verification via code sent to new email.</small>

    <label for="user_image">Profile Image</label>
    <input type="file" name="user_image" id="user_image" accept="image/*" style="margin-bottom:1em;">

    <label for="description">Short Description</label>
    <textarea name="description" id="description" rows="3" style="width:100%;margin-bottom:1em;"><?= htmlspecialchars($user['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

    <input class="btn" type="submit" value="Save Changes">
</form>

<hr style="margin: 2em 0; border: none; border-top: 1px solid #e9ecef;">

<h3 style="color: #dc3545; margin-bottom: 1em;">Danger Zone</h3>
<div style="padding: 1.5em; background: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; margin-bottom: 1em;">
    <h4 style="margin-top: 0; color: #856404;">Delete Account</h4>
    <p style="margin-bottom: 1em; color: #856404;">
        Once you delete your account, there is no going back. This will permanently delete:
    </p>
    <ul style="margin-left: 1.5em; margin-bottom: 1em; color: #856404;">
        <li>Your profile information</li>
        <li>All your questions</li>
        <li>All your comments</li>
    </ul>
    <p style="color: #856404; font-weight: bold;">This action cannot be undone!</p>
</div>

<button 
    class="btn btn-danger" 
    onclick="document.getElementById('delete-form').style.display='block'; this.style.display='none';"
    type="button">
    Delete My Account
</button>

<form id="delete-form" action="" method="post" style="display:none; margin-top: 1em; padding: 1.5em; background: #f8d7da; border: 1px solid #dc3545; border-radius: 8px;">
    <h4 style="color: #721c24; margin-top: 0;">Confirm Account Deletion</h4>
    <p style="color: #721c24; margin-bottom: 1em;">
        Please enter your password to confirm you want to permanently delete your account.
    </p>
    
    <label for="confirm_password">Your Password</label>
    <input type="password" name="confirm_password" id="confirm_password" required placeholder="Enter your password"><br><br>

    <div style="display: flex; gap: 10px;">
        <input type="hidden" name="delete_account" value="1">
        <input class="btn btn-danger" type="submit" value="Yes, Delete My Account" onclick="return confirm('Are you absolutely sure? This cannot be undone!');">
        <button type="button" class="btn ghost" onclick="document.getElementById('delete-form').style.display='none'; document.querySelector('.btn-danger:not(#delete-form .btn-danger)').style.display='inline-block';">Cancel</button>
    </div>
</form>
<?php endif; ?>