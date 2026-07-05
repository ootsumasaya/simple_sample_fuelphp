
<?php if ($shops): ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Status</th>
        <th>Created at</th>
        <th>Updated at</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
  <?php foreach ($shops as $item): ?>
      <tr>
        <td><?php echo $item->id; ?></td>
        <td><?php echo $item->name; ?></td>
        <td><?php echo $item->get_status_info('label'); ?></td>
        <td><?php echo $item->created_at; ?></td>
        <td><?php echo $item->updated_at; ?></td>
      </tr>
  <?php endforeach; ?>
<?php else: ?>
  <p>No Shops.</p>
<?php endif; ?>
<?php echo Html::anchor('shop/create', 'Add new Shop', array('class' => 'btn btn-success')); ?>

