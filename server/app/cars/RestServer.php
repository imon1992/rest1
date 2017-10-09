<?php

class RestServer
{
    protected $url;
    protected $requestMethod;
    protected $cars;
    protected $contentType;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = $_SERVER['REQUEST_URI'];
        $this->cars = new Cars();
    }

    public function run()
    {
        list($s, $user, $REST, $server, $api, $dir, $params) = explode("/", $this->url, 7);
        
        switch ($this->requestMethod) {
            case 'GET':
                $returnFormat = explode(".", $this->url);
                if ($returnFormat[1] === null) {
                    $returnFormat = 'json';
                } else {
                    $returnFormat = $returnFormat[1];
                }
                return $this->setMethod('get' . ucfirst($dir), $returnFormat, $params);
                break;
            case 'POST':
                $this->sendHeaders(501);
                break;
            case 'PUT':
                $this->sendHeaders(501);
                break;
            case 'DELETE':
                $this->sendHeaders(501);
                break;
            default:
                $this->sendHeaders(501);
        }
    }

    private function generateParams($paramStr)
    {
       
        //var_dump($paramStr);
        if (stristr($paramStr, '.') == true && stristr($paramStr, '/') == true) 
        {
            $params = explode('/',$paramStr);
            return $params[0];
        }
        if (stristr($paramStr, '.') == true && stristr($paramStr, '=') == false) 
        {
            return false;
        }
        if ($paramStr === '') {
            return false;
        }
        if (stristr($paramStr, '=') === false) {
            return $paramStr;
        } else {
            $paramsArr = [];
            $params = explode('/', $paramStr);
            //$params = explode('&', $paramStr[0]);

            if (is_array($params)) {

                foreach ($params as $value) {
                    $keyVal = explode('=', $value);
                    $paramsArr[$keyVal[0]] = $keyVal[1];
                }
                array_pop($paramsArr);
            } else {
                $params = explode('=', $params);
                $paramsArr[$params[0]] = $params[1];
            }
            return $paramsArr;
        }
    }

    protected function setMethod($classMethod, $returnFormat, $paramsStr)
    {
        $params = $this->generateParams($paramsStr);
        if (method_exists($this->cars, $classMethod)) {
            $result = $this->cars->$classMethod($returnFormat, $params);
            if ($result === 'unsupported format') {
                $this->sendHeaders(405);
            } else {
                $this->sendHeaders(200);
                return $result;
            }
        } else {
            $this->sendHeaders(500);
        }
    }

    private function sendHeaders($errorCode)
    {
        header("HTTP/1.1 $errorCode " . $this->getStatusMessage($errorCode));
    }

    private function getStatusMessage($code)
    {
        $status = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($status[$code]) ? $status[$code] : $status[500];
    }
}
