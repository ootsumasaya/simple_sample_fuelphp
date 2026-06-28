<h2>Viewing <span class='muted'>User#<?php echo $user->id; ?></span></h2>

<p>
	<strong>Name:</strong>
	<?php echo $user->name; ?>
</p>
<p>
	<strong>Memo:</strong>
	<?php echo $user->memo; ?>
</p>

<h2>Viewing <span class='muted'>Profiles</span></h2>
<?php foreach ($user->profiles as $item): ?>
	<p>
		<strong>Title:</strong>
		<?php echo $item->title; ?>
	</p>
	<p>
		<strong>Body:</strong>
		<?php echo $item->body; ?>
	</p>
<?php endforeach; ?>

<?php echo Html::anchor('user/edit/'.$user->id, 'Edit'); ?> |
<?php echo Html::anchor('user', 'Back'); ?>