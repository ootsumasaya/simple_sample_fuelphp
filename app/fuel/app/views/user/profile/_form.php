<?php echo Form::open(array("class"=>"form-horizontal")); ?>
  <fieldset>
    <div class="form-group">
      <?php echo Form::label('Title', 'title', array('class'=>'control-label')); ?>
      <?php echo Form::input('title', Input::post('title', isset($profile) ? $profile->title : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Title')); ?>
    </div>

    <div class="form-group">
      <?php echo Form::label('Body', 'body', array('class'=>'control-label')); ?>
      <?php echo Form::textarea('body', Input::post('body', isset($profile) ? $profile->body : ''), array('class' => 'col-md-4 form-control', 'placeholder'=>'Body', 'rows' => 5)); ?>
    </div> <div class="form-group">
      <label class='control-label'>&nbsp;</label>
      <?php echo Form::submit('submit', 'Save', array('class' => 'btn btn-primary')); ?>
    </div>
  </fieldset>
<?php echo Form::close(); ?>