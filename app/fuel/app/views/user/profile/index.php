<?php if ($profiles): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Body</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($profiles as $item): ?>		<tr>
			<td><?php echo $item->id; ?></td>
			<td><?php echo $item->title; ?></td>
			<td><?php echo $item->body; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor("user/{$user->id}/profile/view/".$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo Html::anchor("user/{$user->id}/profile/edit/".$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>
            <?php echo Html::anchor("user/{$user->id}/profile/delete/".$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>
          </div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Profiles.</p>

<?php endif; ?><p>
	<?php echo Html::anchor("user/{$user->id}/profile/create", 'Add new Profile', array('class' => 'btn btn-success')); ?>

</p>
