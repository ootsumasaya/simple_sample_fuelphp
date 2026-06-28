<h2>Listing <span class='muted'>Users</span></h2>
<br>
<?php echo Form::open(array('action' => 'user/index', 'method' => 'get', 'class' => 'form-inline')); ?>
	<div class="form-group">
		<?php echo Form::input('q_name', Input::get('q_name', ''), array('class' => 'form-control', 'placeholder' => 'Search by name')); ?>
	</div>
	<div class="form-group">
		<?php echo Form::input('q_memo', Input::get('q_memo', ''), array('class' => 'form-control', 'placeholder' => 'Search by memo')); ?>
	</div>
	<div class="form-group">
		<?php echo Form::submit('search', 'Search', array('class' => 'btn btn-primary')); ?>
	</div>
<?php echo Form::close(); ?>

<?php if ($users): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Memo</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($users as $item): ?>		<tr>
			<td><?php echo $item->id; ?></td>
			<td><?php echo $item->name; ?></td>
			<td><?php echo $item->memo; ?></td>
			<td>
				<div class="btn-toolbar">
					<div class="btn-group">
						<?php echo Html::anchor('user/view/'.$item->id, '<i class="icon-eye-open"></i> View', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('user/edit/'.$item->id, '<i class="icon-wrench"></i> Edit', array('class' => 'btn btn-default btn-sm')); ?>						<?php echo Html::anchor('user/delete/'.$item->id, '<i class="icon-trash icon-white"></i> Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure?')")); ?>					</div>
				</div>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Users.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('user/create', 'Add new User', array('class' => 'btn btn-success')); ?>

</p>
