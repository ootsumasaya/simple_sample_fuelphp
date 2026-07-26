
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
        <td><?php echo Form::button(
          'change_status',
          $item->get_change_to_status_info('label').'化',
          array(
            'data-id'  => $item->id,
            'data-status' => !($item->status) ? 1 : 0,
            'data-url' => 'shop/changeStatus',
            'class' => "btn btn-".(!($item->status) ? 'primary' : 'danger')." js-status-change"
          )
        ) ?></td>
      </tr>
  <?php endforeach; ?>
<?php else: ?>
  <p>No Shops.</p>
<?php endif; ?>
<?php echo Html::anchor('shop/create', 'Add new Shop', array('class' => 'btn btn-success')); ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
$(function () {
  $(document).on("click", '.js-status-change', function () {
    $.ajax({
      type: 'post',
      url: $(this).data('url'),
      dataType: 'json',
      data: {
        id: $(this).data('id'),
        status: $(this).data('status')
      }
    })
    .done(function(data){
      window.alert(data.message);
      location.reload();
    })
    .fail(function(data){
      window.alert(data.message);
    })
  return false;
  })
})
</script>

