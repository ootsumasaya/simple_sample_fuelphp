<h2>Edit <span class='muted'>Profile</span></h2>
<br>

<?php echo render('user/profile/_form'); ?>

<p><?php echo Html::anchor("user/{$user->id}/profile", 'Back'); ?></p>
