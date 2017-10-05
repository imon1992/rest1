<?php
namespace application\api\cars;
use application\core as core;

class Cars extends core\View
{
    public function getCars($input = '', $data = ''){
        $this->formatOutput($input, $data);
    }

    public function postCars($input = '', $data = ''){
    	$this->formatOutput($input, $data);
    }

    public function putCars($input = '', $data = ''){
    	$this->formatOutput($input, $data);
    }

    public function deleteCars($input = '', $data = ''){
    	$this->formatOutput($input, $data);
    }
}

