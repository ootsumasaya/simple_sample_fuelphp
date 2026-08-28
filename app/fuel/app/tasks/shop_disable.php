<?php
namespace Fuel\Tasks;

class Shop_Disable
{
  # 昨日以前に作成されたshopをdisableにする
  public static function run($message = "hello")
  {
    $active_shops = \Model_Shop::query()
      ->where('status', '=', 1)
      ->where('created_at', '<=', date('Y-m-d 23:59:59', strtotime('yesterday')))
      ->get();

    foreach ($active_shops as $shop) {
      $shop->status = 0;
      if ($shop->validate('')->run($shop->to_array())){
        $shop->save();
        echo $shop->name . $shop->status . $shop->created_at . "\n";
      } else {
        echo "Validation failed: " . $shop->name . "\n";
      }
    }
  }
}