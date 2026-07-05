<?php
use Orm\Model;

class Model_Shop extends Model
{
  protected static $_properties = array(
    'id',
    'name' => array(
      'data_type' => 'varchar',
    ),
    'status' => array(
      'data_type' => 'int',
      'default' => 1,
    ),
    'created_at' => array(
      'data_type' => 'timestamp',
    ),
    'updated_at' => array(
      'data_type' => 'timestamp',
    ),
  );

  public static function status_options()
  {
    return array(
      0 => array(
        'label' => '無効',
        'key' => 'disabled',
      ),
      1 => array(
        'label' => '有効',
        'key' => 'active',
      ),
    );
  }

  public static function status_form_options()
  {
    $options = array();
    foreach (static::status_options() as $key => $value)
    {
      $options[$key] = $value['label'];
    }
    return $options;
  }

  public function get_status_info($info_key = 'label')
  {
    $options = static::status_options();
    return isset($options[$this->status][$info_key]) ? $options[$this->status][$info_key] : null;
  }

  # カスタムバリデーションの例
  public static function _validation_check_custom_name($val)
  {
    if ( mb_strlen($val, 'UTF-8') > 20 ) {
      Validation::active()->set_message('check_custom_name', ':labelが上限文字数(20文字)を超えています');
      return false;
    }
    return true;
  }

  public static function validate($factory)
  {
    $val = Validation::forge($factory);
    $val->add_callable('Model_Shop');
    $val->add_field('name', 'Name', 'required|check_custom_name');
    $val->add('status', 'Status')
        ->add_rule('required')
        ->add_rule('numeric_between',0,1);

    return $val;
  }
}
