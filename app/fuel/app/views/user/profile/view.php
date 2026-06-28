<h2>Viewing <span class='muted'>#<?php echo $profile->id; ?></span></h2>

<p>
	<strong>Title:</strong>
	<?php echo $profile->title; ?>
</p>
<p>
	<strong>Body:</strong>
	<?php echo $profile->body; ?>
</p>

<?php echo Html::anchor("user/{$user->id}/profile/edit/{$profile->id}", 'Edit'); ?> |
<?php echo Html::anchor("user/{$user->id}/profile", 'Back'); ?>