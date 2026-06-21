<?php

namespace Fuel\Migrations;

class Add_memo_to_users
{
	public function up()
	{
		\DBUtil::add_fields('users', array(
			'memo' => array('null' => true, 'type' => 'text'),
		));
	}

	public function down()
	{
		\DBUtil::drop_fields('users', array(
			'memo'
		));
	}
}