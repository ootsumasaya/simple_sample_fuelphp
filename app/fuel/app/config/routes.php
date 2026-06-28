<?php
return array(
	'_root_'  => 'welcome/index',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	'user/:user_id/profile(/(create|edit|delete|view))?(/:any)?' => 'user/profile/$3$4',
);
