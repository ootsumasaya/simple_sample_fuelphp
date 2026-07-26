<?php
class Controller_Shop extends Controller_Template
{
  public function action_index()
  {
    $data['shops'] = Model_Shop::find('all');
    $this->template->title = "Shops";
    $this->template->content = View::forge('shop/index', $data);
  }

  public function action_create()
  {
    $shop = Model_Shop::forge();
    if (Input::method() == 'POST')
    {
      $val = $shop->validate('create');

      if ($val->run())
      {
        $fields = $val->validated();
        $shop = $shop->set($fields);
        if ($shop and $shop->save())
        {
          Session::set_flash('success', 'Added shop #'.$shop->id.'.');
          Response::redirect("shop");
        } else {
          Session::set_flash('error', 'Could not save shop.');
        }
      } else {
        Session::set_flash('error', $val->error());
      }
    }

    $data['shop'] = $shop;
    $this->template->title = "Create Shop";
    $this->template->content = View::forge('shop/create', $data, false);
  }

  public function action_changeStatus()
  {
    if( !Input::is_ajax()){
      Response::redirect('shop/index');
    }

    $response = Response::forge();
    $response->set_header('Content-Type', 'application/json');
    $id = Input::post('id');
    $status = Input::post('status');

    $shop = Model_Shop::find($id);
    if (!$shop){
      $response->body(json_encode([
        'status' => 'error',
        'message' => '対象の店舗が見つかりません'
      ]));
      return $response;
    }

    $val = Model_Shop::validate('changeStatus');
    $shop->status = $status;

    if ($val->run($shop->to_array())){
      $fields = $val->validated();
      $shop->status = $fields['status'];
      $shop->save();

      $response->body(json_encode([
        'status' => 'success',
        'message' => "ステータスを".($shop->get_status_info('label'))."化しました"
      ]));
      return $response;
    } else {
      $errors = $val->error();
      $response->body(json_encode([
        'status' => 'error',
        'message' => implode("\n",$errors)
      ]));
      return $response;
    }
  }
}