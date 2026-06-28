<?php
class Controller_User extends Controller_Template
{

	public function action_index()
	{
		$q_name = trim(Input::get('q_name', ''));
		$q_memo = trim(Input::get('q_memo', ''));
		$query = Model_User::query();
		if ($q_name !== '' || $q_memo !== '')
    {
        // 今回は「名前（name）」および「メモ（memo）」の部分一致検索の例
        $query->where_open()
              ->where('name', 'LIKE', "%{$q_name}%")
              ->where('memo', 'LIKE', "%{$q_memo}%")
              ->where_close();
    }
		$data['users'] = $query->get();

		$this->template->title = "Users";
		$this->template->content = View::forge('user/index', $data);

	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('user');

		if ( ! $data['user'] = Model_User::find($id))
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('user');
		}

		$this->template->title = "User";
		$this->template->content = View::forge('user/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_User::validate('create');

			if ($val->run())
			{
				$user = Model_User::forge(array(
					'name' => Input::post('name'),
					'memo' => Input::post('memo'),
				));

				if ($user and $user->save())
				{
					Session::set_flash('success', 'Added user #'.$user->id.'.');

					Response::redirect('user');
				}

				else
				{
					Session::set_flash('error', 'Could not save user.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Users";
		$this->template->content = View::forge('user/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('user');

		if ( ! $user = Model_User::find($id))
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('user');
		}

		$val = Model_User::validate('edit');

		if ($val->run())
		{
			$user->name = Input::post('name');
			$user->memo = Input::post('memo');

			if ($user->save())
			{
				Session::set_flash('success', 'Updated user #' . $id);

				Response::redirect('user');
			}

			else
			{
				Session::set_flash('error', 'Could not update user #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$user->name = $val->validated('name');
				$user->memo = $val->validated('memo');
				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('user', $user, false);
		}

		$this->template->title = "Users";
		$this->template->content = View::forge('user/edit');

	}

	public function action_delete($id = null)
	{
		is_null($id) and Response::redirect('user');

		if ($user = Model_User::find($id))
		{
			$user->delete();

			Session::set_flash('success', 'Deleted user #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete user #'.$id);
		}

		Response::redirect('user');

	}

}
