<?php
use Model_Api\Model_Api;

error_reporting(E_ALL);
ini_set('display_errors', '1');
class Controller_Api extends Controller
{

    function __construct()
    {
        $this->model = new Model_Api();
        $this->view = new View();
    }

    function action_index()
    {

    }

    function action_add_user_interes()
    {
        $data = $this->model->add_user_interes((empty($_POST['interes']) ? null : $_POST['interes'] ));
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }
	function action_drop_user($id = null)
    {
        $data = $this->model->drop_user((empty($_POST['id']) ? $id : $_POST['id'] ));
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }
	
    function action_add_user()
    {
        $data = $this->model->add_user(
			(empty($_POST['nick']) ? null : $_POST['nick'] ),
			(empty($_POST['phone']) ? null : $_POST['phone'] ),
			(empty($_POST['age']) ? null : $_POST['age'] ),
			(empty($_POST['interests']) ? null : $_POST['interests'] )
			);
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }
    function action_update_user()
    {
        $data = $this->model->update_user(
			(empty($_POST['nick']) ? null : $_POST['nick'] ),
			(empty($_POST['phone']) ? null : $_POST['phone'] ),
			(empty($_POST['age']) ? null : $_POST['age'] ),
			(empty($_POST['interests']) ? null : $_POST['interests'] ),
			(empty($_POST['id']) ? null : $_POST['id'] )
			);
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }

    function action_get_user($value = 3, $page = 0)
    {
        $data = $this->model->get_users($value, $page);
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }

    function action_get_users_count()
    {
        $data = $this->model->get_users_count();
        $this->view->generate('api_view.php', 'template_api_view.php', $data, null);
    }



}
