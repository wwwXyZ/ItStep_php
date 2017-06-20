<?php
use Model_User\Model_User;

error_reporting(E_ALL);
ini_set('display_errors', '1');

class Controller_User extends Controller
{

    function __construct()
    {
        $this->model = new Model_User();
        $this->view = new View();
    }

    function action_get_users($page = 0)
    {
        $data = $this->model->get_users($page);
        $this->view->generate('user_view.php', 'template_view.php', $data);
    }
	
	function action_get($page = 0)
    {
        $data = $this->model->get_users((empty($page) ? 0 : $page ));
        $this->view->generate('users_view.php', 'template_view.php', $data);
    }
	
	function action_add()
    {
        $data = $this->model->get_users((empty($page) ? 0 : $page ));
        $this->view->generate('user_add_view.php', 'template_view.php', $data);
    }
		
	function action_update($user_id = null)
    {
        $data = $this->model->get_users((empty($page) ? 0 : $page ));
        $data += $this->model->get_user_by_id((empty($user_id) ? null : $user_id ));
        $this->view->generate('user_update_view.php', 'template_view.php', $data);
    }
	
    function action_index($page = 0)
    {
        //$this->action_get_users($page);
        //$this->action_search($page);
		header('Location: /user/get/0/');
    }

    function action_edit()
    {
        $data = $this->model->edit();
        $this->view->generate('user_edit_view.php', 'template_view.php', $data, 'header_view.php');
    }
	function action_add_interes()
    {
		$data = [
			'title' => 'Добавить интерес'
		];
        $this->view->generate('user_add_interes_view.php', 'template_view.php', $data, 'header_view.php');
    }
	
    function action_search()
    {
        $data = $this->model->search();
		$data += $this->model->get_users(0);
        $this->view->generate('user_search_view.php', 'template_view.php', $data, 'header_view.php');
    }

    function action_auth()
    {
        $data = $this->model->auth(
            empty($_POST['login']) ? null : $_POST['login'],
            empty($_POST['password']) ? null : $_POST['password'],
            Controller::get_client_ip()
        );
        $data += $this->model->get_header($data);
        $this->view->generate('auth_view.php', 'template_view.php', $data, 'header_onlyMobile_view.php');
    }

    function action_exit()
    {
        $data = $this->model->logout();
        $this->view->generate('tower_view.php', 'template_view.php', $data, null, null);
    }

}
