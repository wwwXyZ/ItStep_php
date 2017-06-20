<?php

class Controller_alert extends Controller
{

    function __construct()
    {
        $this->model = new Model_alert();
        $this->view = new View();
    }

	function action_index()
	{
        $data = $this->model->get_404();
		$this->view->generate('alert_view.php', 'template_view.php', $data, 'header_view.php');
	}

	function action_404()
	{
        $data = $this->model->get_404();
		$this->view->generate('alert_view.php', 'template_view.php', $data, 'header_view.php');
	}


}
