<?php
namespace Model_Api;

use Database;
use Main_Model\Model;

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Model_Api extends Model
{
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

    public function get_user_interes() {
		$interests = self::get_interests()['interests'];
		return [
			'interests' => $interests
		];
	}
	public function get_users_count() {
		
		global $db;
		$query = <<<SQL
SELECT 
	COUNT(`id`) count
  FROM 
    `users`
SQL;
		$count = $db->query($query)->fetchArray()['count'];
		return [
			'count' => $count
			];
	}
	
    public function drop_user($user_id = null) {
		global $db;
		$user_id = (int)htmlentities(trim(stripslashes($user_id)), ENT_QUOTES);
		if(
			empty($user_id) ||
			!is_numeric($user_id) ||
			$user_id <= 0
		) {
			return [
				'error' => 'no input params!'
			];
			die();
		}
		if (!$this->check_user_by_id($user_id)) {
			return [
				'error' => 'User not found!'
			];
			die();
		}
		$query = "DELETE FROM `users_interests_active` WHERE `user_id` = {$user_id};";
		$db->query($query);
		$query = "DELETE FROM `users` WHERE `id` = {$user_id};";
		$db->query($query);
		if ($this->check_user_by_id($user_id))
			return [
				'response' => 'Error!'
			];
		else
			return [
				'response' => 'OK'
			];

			
	
		
		
	}
	
    public function get_users($value = 5, $page = 0)
    {
		if(!empty($_GET['nick']))
			$nick = htmlentities(trim(stripslashes($_GET['nick'])), ENT_QUOTES);
		if(!empty($_GET['phone']))
			$phone = htmlentities(trim(stripslashes($_GET['phone'])), ENT_QUOTES);
		if(!empty($_GET['age']))
			$age = htmlentities(trim(stripslashes($_GET['age'])), ENT_QUOTES);
		if(!empty($_GET['interests']))
			$interests = $_GET['interests'];
		if(!empty($nick)) {
			$q['nick'] = "u.nick LIKE '%{$nick}%' AND";
		} else
			$q['nick'] = '';
		if(!empty($phone))
			$q['phone'] = "u.phone LIKE '%{$phone}%' AND";
		else
			$q['phone'] = '';
		if(!empty($age))
			$q['age'] = "u.age = '{$age}' AND";
		else
			$q['age'] = '';
		if(!empty($interests) && is_array($interests)){
				$tmp = '';
				foreach($interests as $key => $val) {
					$interests[$key] = htmlentities(trim(stripslashes($val)), ENT_QUOTES);
					$tmp .= "'{$interests[$key]}',";
				}
				$tmp = substr($tmp, 0, -2).'\'';
//				die($tmp);
				$q['interes'] = <<<SQL
u.id IN (SELECT 
		u.id 
	  FROM 
		`users` u,	
		`users_interests` i,
		`users_interests_active` a 
	  WHERE a.interes_id IN ({$tmp})
	  AND
		a.user_id = u.id AND
		a.interes_id = i.id
	  ) AND
SQL;
		} else
			$q['interes'] = '';
		
        $value = htmlentities(trim(stripslashes($value)), ENT_QUOTES);
		$value = (int)$value;
        $page = htmlentities(trim(stripslashes($page)), ENT_QUOTES);
		$page = (int)$page;
		if(
			!empty($value) &&
			is_numeric($value) &&
			$value > 0 &&
			is_numeric($page)
		) {
			$page = $page * $value;
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
	{$q['interes']}
	a.user_id = u.id AND
	a.interes_id = i.id
  GROUP BY
	u.id
  ORDER BY
	`u`.`id`
  ASC
  LIMIT {$page}, {$value}
SQL;
//echo '<pre>';
//die($query);
		}
        if (!empty($query)) {
			global $db;
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

			return [
					'users' => $all_user_data
				];
			
			

            return [
                'exist' => (bool)$response
            ];
        }
        return [
            'error' => 'no input params!'
        ];
    }

    public function add_user_interes($interes = null)
    {
		global $db;
		if (empty($interes))
			return [
				'error' => 'no input params!'
			];
        $interes = htmlentities(trim(stripslashes($interes)), ENT_QUOTES);
		
		$query = <<<SQL
SELECT 
	`id` 
  FROM 
    `users_interests` 
  WHERE 
	`interes` = '{$interes}'
SQL;
		$response = $db->query($query)->fetchArray()['id'];
		if (!empty($response))
			return [
				'error' => 'dublicate!'
			];
		
			$query = <<<SQL
INSERT INTO 
	`users_interests` 
		('interes') 
	VALUES 
		('{$interes}');
SQL;
		
		$response = $db->query($query);
		$inserted_id = $db->query('SELECT last_insert_rowid() id')->fetchArray()['id'];
		return [
				'id' => $inserted_id
			];
	}

    public function add_user(
		$nick = null,
		$phone = null,
		$age = null,
		$interests = null,
		$id = null
		)
    {
        $nick = htmlentities(trim(stripslashes($nick)), ENT_QUOTES);
        $phone = htmlentities(trim(stripslashes($phone)), ENT_QUOTES);
        $age = htmlentities(trim(stripslashes($age)), ENT_QUOTES);
		if(!is_null($id)) {
			$id = (int)htmlentities(trim(stripslashes($id)), ENT_QUOTES);
			if(
				!is_numeric($id) ||
				$id <= 0
				)
				return [
					'error' => 'wrong id!'
				];
		}
		
		//phone
		$phone = (int)$phone;
		if (empty($phone) || $phone <= 0) {
			return [
				'error' => 'phone can`t be empty!'
			];
			die();
		}
		elseif (strlen($phone) > 30 || strlen($phone) < 5 ) {
			return [
				'error' => 'wrong phone!'
			];
			die();
		}
		//age
		$age = (int)$age;
		if (empty($age) || $age <= 0) {
			return [
				'error' => 'age can`t be empty!'
			];
			die();
		}
		elseif ($age > 666 || $age < 6){
			return [
				'error' => 'wrong age!'
			];
			die();
		}
		//interests
		if (is_array($interests)){
			foreach ($interests as $key => $value)
				$interests[$key] = htmlentities(trim(stripslashes($value)), ENT_QUOTES);
			$interests = array_unique($interests); // remove dublicate
		} else {
			return [
				'error' => 'interes must been in array!'
			];
			die();
		}
		//nick
		if(strlen($nick) < 3 || strlen($nick) > 30) {
			return [
				'error' => 'wrong nick!'
			];
			die();
		}
			
		if($_POST) {
			global $db;

			$nick_id = $db->query("SELECT id FROM `users` WHERE nick='{$nick}';")->fetchArray()['id'];
			if(!empty($nick_id))
				return [
					'error' => 'Existable nick!'
				];
			
			foreach ($interests as $key => $value){
				$query = "SELECT id FROM `users_interests` WHERE id={$value};";
				$response = $db->query($query)->fetchArray()['id'];
				if (empty($response)) {
					return [
						'error' => 'No interests found!'
					];
					die();
				}
			}
			//INSERT USER
			if(!is_null($id))
				$query = <<<SQL
INSERT INTO 
	`users`
		(`id`, 'nick', 'phone', 'age', 'date') 
	VALUES 
		('{$id}', '{$nick}', '{$phone}', '{$age}', date('now'))
SQL;
			else
				$query = <<<SQL
INSERT INTO 
	`users`
		('nick', 'phone', 'age', 'date') 
	VALUES 
		('{$nick}', '{$phone}', '{$age}', date('now'))
SQL;

		$response = $db->query($query);
		$user_id = $db->query('SELECT last_insert_rowid() id')->fetchArray()['id'];
			
			//INSERT INTERESTS
			foreach ($interests as $key => $value) {
				$query = "INSERT INTO `users_interests_active` ('user_id', 'interes_id') VALUES ({$user_id}, {$value});";
				$db->query($query);
			}

			return [
				'id' => $user_id
			];	
		} else {
			return [
				'error' => 'no input params!'
			];
		}
	}

	public function update_user(
		$nick = null,
		$phone = null,
		$age = null,
		$interests = null,
		$id = null
		)
	{
		$id = (int)htmlentities(trim(stripslashes($id)), ENT_QUOTES);
		if($this->check_user_by_id($id)) {
			$this->drop_user($id);
			$this->add_user(
				$nick,
				$phone,
				$age,
				$interests,
				$id
			);
		}
	}
	
}
