<?php 
/**
 *  core class of controller can create model and view obj
 *  he gets requests from frontend and send its to model or not;
 *  when model returns data controller sends on view, than view 
 *  shows temolate and data in view for user
 */
namespace application\core;
	class Controller
	{
		protected $model;
		protected $view;
		

		public function parseGetData($input)
		{
			$pattern = ['/\.txt/','/\.html/','/\.xml/','/\.json/'];
			$input = preg_replace($pattern,'',$input);
			$data = explode('/',$input);
			return $data;
		}

		public function getPostData()
		{
			return $_POST;
		}

		public function getPutData()
		{
			$arr = array();
            $putdata = file_get_contents('php://input'); 
            $exploded = explode('&', $putdata);  
            
          foreach($exploded as $pair) { 
            $item = explode('=', $pair); 
            if(count($item) == 2) { 
              $arr[urldecode($item[0])] = urldecode($item[1]); 
            } 
          }
          
         return  $arr;
		}

		public function getDeleteParams()
		{
			return $_GET;
		}
	}