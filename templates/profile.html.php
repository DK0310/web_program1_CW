<?php if (!empty($error)): ?>
    <div class="errors"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>
<?php if (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<h2>My Profile</h2>
<form action="" method="post">
    <label for="name">Name</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($user['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"><br><br>

    <input class="btn" type="submit" value="Save">
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