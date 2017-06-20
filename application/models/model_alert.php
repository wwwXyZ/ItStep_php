<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

class Model_alert extends Main_Model\Model
{

    public function get_404()
    {
        session_start();
        return array(
            'content_title' => 'Ошибка 404',
            'content_body' => 'Страница на сайте не найдена',
            'page' => '404',
			'title' => 'Страница не найдена'
        );
    }

    public function get_new_user()
    {
        session_start();
        $this->check_session();
       if(
           !empty($_SERVER['HTTP_REFERER']) &&
           parse_url($_SERVER['HTTP_REFERER'])['path'] == \Main_Model\Model::REGISTRATION_PATCH//fun crutch
       )
        return array(
            'content_title' => 'Регистрация завершена',
            'content_body' => 'Вы можете начать полноценно пользоваться сайтом уже сейчас — вход в систему выполнен.<br>Рекомендуем вам <a href="/edit_profile">дополнить свой профиль</a> самоописанием и другими персональными данными.',
            'page' => 'new_user',
            'header' => [
                'title' => 'Шаг сделан!',
                'mobile_title' => 'Шаг сделан!'
            ]
        );
       else
           \Main_Model\Model::check_session(true);
    }

}
