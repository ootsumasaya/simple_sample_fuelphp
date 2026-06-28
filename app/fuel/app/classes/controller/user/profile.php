<?php
class Controller_User_Profile extends Controller_Template
{

  public function action_index()
  {
    $user_id = $this->param('user_id');
    is_null($user_id) and Response::redirect('user');

    if ( ! $data['user'] = Model_User::find($user_id))
    {
      Session::set_flash('error', 'Could not find user #'.$user_id);
      Response::redirect('user');
    }

    $data['profiles'] = Model_Profile::query()->where('user_id', $user_id)->get();

    $this->template->title = "{$data['user']->name}'s Profiles";
    $this->template->content = View::forge('user/profile/index', $data);

  }

  public function action_view($id = null)
  {
    $user_id = $this->param('user_id');
    is_null($user_id) and Response::redirect('user');
    $data['user'] = Model_User::find($user_id);

    if ( ! $data['profile'] = Model_Profile::query()
        ->where('id', $id)
        ->where('user_id', $user_id)
        ->get_one())
    {
        Session::set_flash('error', 'Could not find profile #'.$id);
        Response::redirect("user/{$user_id}/profile");
    }

    $this->template->title = "{$data['user']->name}'s Profile";
    $this->template->content = View::forge('user/profile/view', $data);

  }

  public function action_create()
  {
    $user_id = $this->param('user_id');
    is_null($user_id) and Response::redirect('user');

    if ( ! $data['user'] = Model_User::find($user_id))
    {
      Session::set_flash('error', 'Could not find user #'.$user_id);
      Response::redirect('user');
    }

    if (Input::method() == 'POST')
    {
      $val = Model_Profile::validate('create');

      if ($val->run())
      {
        $profile = Model_Profile::forge(array(
          'title' => Input::post('title'),
          'body' => Input::post('body'),
          'user_id' => $user_id,
        ));

        if ($profile and $profile->save())
        {
          Session::set_flash('success', 'Added profile #'.$profile->id.'.');

          Response::redirect("user/{$user_id}/profile");
        }

        else
        {
          Session::set_flash('error', 'Could not save profile.');
        }
      }
      else
      {
        Session::set_flash('error', $val->error());
      }
    }

    $this->template->title = "Create {$data['user']->name}'s Profile";
    $this->template->content = View::forge('user/profile/create', $data);
  }

  public function action_edit($id = null)
  {
    $user_id = $this->param('user_id');
    is_null($user_id) and Response::redirect('user');

    if ( ! $data['user'] = Model_User::find($user_id))
    {
      Session::set_flash('error', 'Could not find user #'.$user_id);
      Response::redirect('user');
    }

    if ( ! $data['profile'] = Model_Profile::query()
        ->where('id', $id)
        ->where('user_id', $user_id)
        ->get_one())
    {
        Session::set_flash('error', 'Could not find profile #'.$id);
        Response::redirect("user/{$user_id}/profile");
    }

    $val = Model_Profile::validate('edit');

    if ($val->run())
    {
      $data['profile']->title = Input::post('title');
      $data['profile']->body = Input::post('body');

      if ($data['profile']->save())
      {
        Session::set_flash('success', 'Updated profile #' . $id);

        Response::redirect("user/{$user_id}/profile");
      }

      else
      {
        Session::set_flash('error', 'Could not update profile #' . $id);
      }
    }

    else
    {
      if (Input::method() == 'POST')
      {
        $data['profile']->title = $val->validated('title');
        $data['profile']->body = $val->validated('body');

        Session::set_flash('error', $val->error());
      }

      $this->template->set_global('profile', $data['profile'], false);
    }

    $this->template->title = "Edit {$data['user']->name}'s Profile";
    $this->template->content = View::forge('user/profile/edit', $data);

  }

  public function action_delete($id = null)
  {
    $user_id = $this->param('user_id');
    is_null($user_id) and Response::redirect('user');

    if ( ! $data['user'] = Model_User::find($user_id))
    {
      Session::set_flash('error', 'Could not find user #'.$user_id);
      Response::redirect('user');
    }

    if ($profile = Model_Profile::query()
        ->where('id', $id)
        ->where('user_id', $user_id)
        ->get_one())
    {
      $profile->delete();

      Session::set_flash('success', 'Deleted profile #'.$id);
    }

    else
    {
      Session::set_flash('error', 'Could not delete profile #'.$id);
    }

    Response::redirect("user/{$user_id}/profile");

  }
}