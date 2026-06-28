<h2>Editing <span class='muted'>User</span></h2>
<br>
<?php if ( ! empty($errors)): ?>
		<div class="alert alert-danger">
				<ul>
						<?php foreach ($errors as $error): ?>
								<li><?php echo $error; ?></li>
						<?php endforeach; ?>
				</ul>
		</div>
<?php endif; ?>

<?php echo Form::open(array("class"=>"form-horizontal")); ?>
	<?php echo Fieldset::forge('user')->add_model($user)->populate($user, true)->build(); ?>
<?php echo Form::close(); ?>

<?php echo Html::anchor('user/view/'.$user->id, 'View'); ?> |
<?php echo Html::anchor('user', 'Back'); ?></p>
