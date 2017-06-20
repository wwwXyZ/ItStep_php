<?php
namespace Model_User;

use Database;
use DateTime;
use Main_Model\Model;

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Model_User extends Model
{
    public function get_users($page_number = 0)
    {
		$users_count = 3;
		global $db;
		$page_number = htmlentities(trim(stripslashes($page_number)), ENT_QUOTES);
        $page_number = (int)$page_number;

		if(!empty($_GET['nick']))
			$nick = htmlentities(trim(stripslashes($_GET['nick'])), ENT_QUOTES);
		if(!empty($_GET['phone']))
			$phone = htmlentities(trim(stripslashes($_GET['phone'])), ENT_QUOTES);
		if(!empty($_GET['age']))
			$age = htmlentities(trim(stripslashes($_GET['age'])), ENT_QUOTES);
		if(!empty($nick)) {
			$q['nick'] = "u.nick LIKE '%{$nick}%' AND";
		} else
			$q['nick'] = '';
		if(!empty($phone))
			$q['phone'] = "u.phone LIKE '%{$phone}%' AND";
		else
			$q['phone'] = '';
		if(!empty($age))
			$q['age'] = "u.age LIKE '{$age}' AND";
		else
			$q['age'] = '';
		
		$query = <<<SQL
SELECT 
	u.id, 
	u.nick, 
	u.phone, 
	u.age,
	GROUP_CONCAT(i.interes, ', ') AS interes
  FROM 
	`users` u,
	`users_interests` i,
	`users_interests_active` a
  WHERE
	{$q['nick']}
	{$q['phone']}
	{$q['age']}
	a.user_id = u.id AND
	a.interes_id = i.id
  GROUP BY 
	u.id
  ORDER BY 
	`u`.`id` 
  ASC 
  LIMIT {$page_number}, {$users_count}
SQL;
		$response = $db->query($query);

		$all_user_data = [];
		while ($user_data = $response->fetchArray()) {
			$all_user_data[] = array(
				'id' => $current_user_data[$user_data['id']] = $user_data['id'],
				'nick' => $current_user_data[$user_data['nick']] = $user_data['nick'],
				'phone' => $current_user_data[$user_data['phone']] = $user_data['phone'],
				'age' => $current_user_data[$user_data['age']] = $user_data['age'],
				'interests' => $current_user_data[$user_data['interes']] = (explode(", ",$user_data['interes']))
			);
			
		}

		$interests = self::get_interests()['interests'];
		
		return array( 
			'page_number' => $page_number,
			'users' => $all_user_data,
			'interests' => $interests,
			'page' => 'users',
			'title' => 'Пользователи'
		);
	}

    public function edit($user_id = null)
    {
		
		
		return array( 
			'page' => 'users',
			'title' => 'Изменить пользователя'
		);
    }
    public function search()
    {
		
		
		return array( 
			'page' => 'users',
			'title' => 'Поиск'
		);
    }

    public function logout()
    {
        session_start();
        $login_last_input = $_SESSION['login_last_input'];
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        $_SESSION['login_last_input'] = $login_last_input;
        $this->check_session();
    }
		public function check_user_by_id($id = null) {
		global $db;
		$query = <<<SQL
SELECT 
	`id` 
  FROM 
    `users` 
  WHERE 
	`id` = '{$id}'
SQL;
		$response = $db->query($query)->fetchArray()['id'];
		if (empty($response))
			return false;
		else
			return true;
	}
	public function get_user_by_id($user_id = null) {
		global $db;
		if (empty($user_id))
			return array(
					'id' => '',
					'nick' => '',
					'phone' => '',
					'age' => '',
					'interests' => ''
				);
		$id = (int)htmlentities(trim(stripslashes($user_id)), ENT_QUOTES);
		if($this->check_user_by_id($id)) {
			$query = <<<SQL
SELECT 
	u.id, 
	u.nick, 
	u.phone, 
	u.age,
	GROUP_CONCAT(a.interes_id, ', ') AS interes_id
  FROM 
	`users` u,
	`users_interests` i,
	`users_interests_active` a
  WHERE
	a.user_id = u.id AND
	a.interes_id = i.id AND
	u.id = {$id}
  GROUP BY 
	u.id
SQL;
			$response = $db->query($query)->fetchArray();
			
			return array(
				'id' => $id,
				'nick' => $response['nick'],
				'phone' => $response['phone'],
				'age' => $response['age'],
				'interes_id' => $response['interes_id']
			);
		} else
			return array(
				'id' => '',
				'nick' => '',
				'phone' => '',
				'age' => '',
				'interests' => ''
			);
	}

}
