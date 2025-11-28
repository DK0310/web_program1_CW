<!-- Back button -->
<div style="margin-bottom: 1.5em;">
    <a href="<?= $backUrl ?>" class="btn secondary" style="display:inline-flex;align-items:center;gap:6px;">
        <span style="font-size:1.2em;">←</span> <?= $backText ?>
    </a>
</div>

<div class="profile-card">
    
    <!-- Profile Header -->
    <div class="profile-header">
        <?php if (!empty($upAvatarPath) && file_exists($upAvatarPath)): ?>
            <img src="<?= htmlspecialchars($upAvatarPath, ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" class="profile-avatar-img">
        <?php else: ?>
            <div class="profile-avatar-placeholder">
                <?= strtoupper(substr($user['name'] ?? 'A', 0, 1)) ?>
            </div>
        <?php endif; ?>
        
        <div class="profile-info">
            <h2 class="profile-name">
                <?= htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8') ?>
            </h2>
            <div class="profile-email">
                <span style="font-size:1.1em;">✉</span>
                <?= htmlspecialchars($user['email'] ?? 'No email', ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
    </div>
    
    <!-- About Section -->
    <div class="profile-about">
        <h3>
            <span style="font-size:1.2em;">📝</span> About
        </h3>
        <div class="profile-about-content">
            <?php if (!empty($user['description'])): ?>
                <?= nl2br(htmlspecialchars($user['description'], ENT_QUOTES, 'UTF-8')) ?>
            <?php else: ?>
                <span style="color:#aaa;font-style:italic;">This user hasn't written anything about themselves yet.</span>
            <?php endif; ?>
        </div>
    </div>
    
</div>
