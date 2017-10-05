<?php
namespace application\controllers;
use application\core as core;
use application\api\cars as cars;
use application\models as model;

class ControllerCars extends core\Controller
{
	public function __construct($class)
	{
		//$modelName = 'application\models\\Model' . $class;
		$viewName = 'application\api\cars\\' . $class;

		//$this->model = new $modelName;
		$this->view = new $viewName;
	}

	public function actionGet($input)
	{
		$data = $this->parseGetData($input);
		$this->view->getCars($input,$data);
	}

	public function actionPost($input)
	{
		$data = $this->getPostData();
		$this->view->postCars($input,$data);	
	}

	public function actionPut($input)
	{
		$data = $this->getPutData();
		$this->view->putCars($input,$data);		
	}

	public function actionDelete($input)
	{
		$data = $this->getDeleteParams();
		$this->view->deleteCars($input,$data);	
    }


}
