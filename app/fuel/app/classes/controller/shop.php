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
}