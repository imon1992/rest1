<?php

class RestServer
{
    protected $url;
    protected $requestMethod;
    protected $auth;
    protected $contentType;

    public function __construct()
    {
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->url = '/~user14/rest1/server/api/auth/';
//        $this->url = $_SERVER['REQUEST_URI'];
        $this->auth = new Auth();
    }

    public function run()
    {
//        $this->generatePut($x);
        list($s, $user, $REST, $server, $api, $dir, $login, $password) = explode("/", $this->url, 8);
        //        var_dump($login, $password);
//return $this->requestMethod;
        switch ($this->requestMethod) {
        case 'GET':
             $id = $_GET['id'];
             $hash = $_GET['hash'];
//return $id;
//return $hash;
//            setcookie("id", '2', time() + 60 * 60 * 24 * 30,'/','http://rest123');
            return $this->setMethod('get' . ucfirst($dir), $id, $hash);
            break;
        case 'POST':
//            return 'dsfdsf';
            $login = json_decode($_POST['login']);
            $password = json_decode($_POST['password']);
//            return $login;
            return $this->setMethod('post' . ucfirst($dir), $login, $password);
            break;
        case 'PUT':
//            return 111;
            $putData = file_get_contents('php://input');
//            return $putData;
//            $putData = json_decode($putData);
            $loginPswd = $this->generatePut($putData);
//            var_dump($loginPswd['login']);
//            var_dump($loginPswd['password']);
//            var_dump(ucfirst($dir));
            //$login = 'imon';
            //$password = '360557zx';
            return $this->setMethod('put' . ucfirst($dir), $loginPswd['login'], $loginPswd['password']);
            //return $this->setMethod('put' . ucfirst($dir), $login, $password);
            break;
        case 'DELETE':
            return $this->setMethod('delete' . ucfirst($dir), $login, $password);
            break;
        default:
            $this->sendHeaders(501);
        }
    }


    protected function setMethod($classMethod, $login, $password)
    {
//        return $classMethod;
        if (method_exists($this->auth, $classMethod)) {
            if ($login !== null && $password !== null) {

                $result = $this->auth->$classMethod($login, $password);

                if ($result === 'error') {
                    $this->sendHeaders(405);
                } else {
                    $this->sendHeaders(200);
                }
//                if(is_array($result))
//                {
////                    echo 'tutut';
////                    header("Cookie: hash=09f85d68965fdec4c729b2bef0752d78;");
//                    setcookie("id", $result['id'], time() + 60 * 60 );
//                    setcookie("hash", $result['hash'], time() + 60 * 60);
//                    $result = true;
//                }
            } else {
                $result = $this->auth->$classMethod();
//                if(is_array($result))
//                {
//                    setcookie("id", $result['id'], time() + 60 * 60 * 24 * 30,'/');
//                    setcookie("hash", $result['hash'], time() + 60 * 60 * 24 * 30,'/');
//                    $result = true;
//                }
            }
        } else {
            $this->sendHeaders(500);
        }
                    return $result;
    }

    private function generatePut($putData)
    {
        $result =[];
        $putArr = explode('&',$putData);

        foreach($putArr as $value)
        {
            $params = explode('=',$value);
            $result[$params[0]] = json_decode($params[1]);
        }

        return $result;
        //var_dump($result);
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
