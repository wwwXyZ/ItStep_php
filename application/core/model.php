<?php
namespace Main_Model;

use Database;

include_once("bd.php");

class Model
{
    const REGISTRATION_PATCH = '/user/registration';


    public function get_data()
    {
        // todo
    }

    public function encrypt_password($password)
    {
        return hash('sha256', "(*j98" . md5(hash('sha256', hash('ripemd160', $password . "%_R0o,\\s-+b")) . "f<809")) . strrev(hash('haval160,4', "\"J*(j" . $password . "fee$4t"));//Security Encryption
    }
	
	public function get_interests() {
		global $db;
				$query = <<<SQL
SELECT 
	id, 
	interes
  FROM 
	`users_interests`
SQL;
		$response = $db->query($query);
		$all_interests = [];
		while ($interes_data = $response->fetchArray()) {
			$all_interests[] = [
				'id' => $current_interes_data[$interes_data['id']] = $interes_data['id'],
				'interes' => $current_interes_data[$interes_data['interes']] = $interes_data['interes'],
			];
		}
		return array( 
			'interests' => $all_interests
		);
		
	}
}
