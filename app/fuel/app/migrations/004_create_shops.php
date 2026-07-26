<?php

namespace Fuel\Migrations;

/*
mysql> describe shops;
+------------+------------------+------+-----+-------------------+-----------------------------+
| Field      | Type             | Null | Key | Default           | Extra                       |
+------------+------------------+------+-----+-------------------+-----------------------------+
| id         | int(11) unsigned | NO   | PRI | NULL              | auto_increment              |
| name       | varchar(255)     | NO   |     | NULL              |                             |
| status     | int(1)           | NO   |     | 1                 |                             |
| created_at | timestamp        | NO   |     | CURRENT_TIMESTAMP |                             |
| updated_at | timestamp        | NO   |     | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+------------+------------------+------+-----+-------------------+-----------------------------+
*/

class Create_shops
{
  public function up()
  {
    \DBUtil::create_table('shops', array(
      'id' => array('type' => 'int', 'unsigned' => true, 'null' => false, 'auto_increment' => true, 'constraint' => '11'),
      'name' => array('type' => 'varchar', 'null' => false, 'constraint' => '255'),
      'status' => array('type' => 'int', 'default' => 1, 'null' => false, 'constraint' => '1'),
      'created_at' => array('type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP'), 'null' => false),
      'updated_at' => array('type' => 'timestamp', 'default' => \DB::expr('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'), 'null' => false),
    ), array('id'));
  }

  public function down()
  {
    \DBUtil::drop_table('shops');
  }
}