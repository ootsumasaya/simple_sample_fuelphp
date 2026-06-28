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

		if ( ! $data['user'] = Model_User::find($id, array('related' => array('profiles'))))
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

		if ( ! $user = Model_User::find($id, array('related' => array('profiles'))))
		{
			Session::set_flash('error', 'Could not find user #'.$id);
			Response::redirect('user');
		}

		// Fieldsetの生成
		$form = Fieldset::forge('user',array('validation_instance' => Model_User::validate('user')))->add_model($user);

		// 関連モデルを追加
		$form
			->add(Fieldset::forge('tabular')
			->set_tabular_form('Model_Profile', 'profiles', $user, 0)
			->set_fieldset_tag(false));

		// submitボタンを追加
		$form->add('submit', '' , array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary'));

		// 既存の値をフォームに初期値として流し込む
		$form->populate($user);

		$errors = array();

		if (Input::method() == 'POST')
		{
			// validate the input
			// WARNING: set_tabular_formによるforgeにModel_Profileのバリデーションを設定する方法がないため、
			// $form->validation()->run() としても子モデルのバリデーションは実行されない。
			// そのため、子モデルは個別でバリデーションを実行する。
			// （一応_propertiesにバリデーションを移植したり、
			//   set_tabular_formによって生成された各行のFieldsetをループしてルールを移植することも可能のようだが、
			//   今回は個別で実行にする）
			// (親モデルはforgeでバリデーションのインスタンスを渡すことができるため$form->validation()->run()で問題ない)
			// Debug::dump($form->validation()->field('name')->rules);
			// Debug::dump(Model_User::validate('test_user')->field('name')->rules);
			// Debug::dump($form->validation()->run(), Model_User::validate('test_user2')->run());
			// (子モデルのバリデーションは空になる)
			// $first_row_fieldset = array_values($form->instance('tabular')->field())[0];
			// $first_field_key = array_keys($first_row_fieldset->validation()->field())[0];
			// Debug::dump($first_row_fieldset->validation()->field($first_field_key)->rules);
			// Debug::dump(Model_Profile::validate('test_profile')->field('title')->rules);
			if ( ! $form->validation()->run())
			{
				$errors = array_merge($errors, $form->validation()->error());
			}
			foreach (Input::post('profiles', array()) as $id => $row)
			{
				if ( ! empty($row['_delete']))
				{
					continue;
				}
				$val = Model_Profile::validate('edit_profile_' . $id);
				if ( ! $val->run($row))
				{
					$errors = array_merge($errors, $val->error());
				}
			}

			// フォームで入力されたデータを取得
			$data = Input::post();
			// if validated, save the updates
			if ( empty($errors))
			{
				// update the user record, and any comment record changes
				$user->from_array($data);

				// do we need to delete tabular form records?
				foreach ($data['profiles'] as $id => $row)
				{
					if ($id and ! empty($row['_delete']))
					{
						unset($user->profiles[$id]);
					}
				}
				if ($user->save())
				{
					// display a save-succesful message here and redirect away
					Session::set_flash('success', 'User updated successfully.');
					Response::redirect("user/view/{$user->id}");
				}
				else
				{
					// display an error message, save was not succesful
					Session::set_flash('error', 'Could not update user.');
				}
			}
			else
			{
				// inform the user validation failed
				Session::set_flash('error', 'Validation failed.');
			}
		}
		Debug::dump($form);

		$data['user'] = $user;
		$data['errors'] = $errors;

		$this->template->title = "Users";
		$this->template->content = View::forge('user/edit', $data, false);
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
