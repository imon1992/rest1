<?php

class Auth
{

    protected $authSql;

    public function __construct()
    {
        $this->authSql = new AuthSql();
    }

    public function postAuth($login, $password)
    {
        $checkLoginResult = $this->authSql->checkUserLogin($login);
        $err = '';

        if ($checkLoginResult > 0) {
            $err = "login already exists";
        }

        if ($err === '') {
            $password = md5(md5($password));
            $result = $this->authSql->createNewUser($login, $password);
        } else {
            $result = $err;
        }

        return $result;
    }

    public function putAuth($login, $password)
    {
        $idPassword = $this->authSql->getIdPassByLogin($login);

        if ($idPassword[0]['password'] === md5(md5($password))) {
//            session_start();
//            $_SESSION['userid'] = 10;
//            return $_SESSION;
//var_dump($_SESSION['userid']);
//            $result = true;
            $hash = md5($this->generateCode(10));

            $result = $this->authSql->setNewHash($hash, $idPassword[0]['id']);
            if ($result == true) {
                $result =[];
                $result['id'] = $idPassword[0]['id'];
                $result['hash'] = $hash;
//                setcookie("id", $idPassword[0]['id'], time() + 60 * 60 * 24 * 30,'/');
//                setcookie("hash", $hash, time() + 60 * 60 * 24 * 30,'/');
     //$date = date("D, d M Y H:i:s",strtotime('1 January 2015')) . 'GMT';
       //   header("Set-Cookie: {'id'}={'123'}; EXPIRES{$date};");
                //var_dump($_COOKIE);
                //var_dump($x);
                //header('Set-cookie: foo1=bar11');
//                var_dump($_COOKIE);
            }else
            {
                $result = false;
            }


//            $this->checkAuth();
        } else {
            $result = "wrong password";
        }
        return $result;

    }

    public function getAuth($id,$hash)
    {
//        var_dump('cookie   '.$_COOKIE['hash']);
        //var_dump('hash    '.$idHash[0]['hash']);
//        var_dump($_COOKIE);
//        echo $_COOKIE;
//        return $_COOKIE;
//        session_start();
//        return $_SESSION['userid'];
////        var_dump($_SESSION);
//        if(isset($_SESSION['userid']))    {
//            $result =  true;
//        }else{
//            $result =  false;
//        }
//        return $id;
        if ($id !== 'undefined' && $hash !== 'undefined') {
            $idHash = $this->authSql->getIdHashByCookieId($id);

//        var_dump('cookie   '.$_COOKIE['hash']);
//        var_dump('hash    '.$idHash[0]['hash']);
            if (($idHash[0]['hash'] !== $hash) || ($idHash[0]['id'] !== $id))
            {
//                setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
//                setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");

                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = false;
        }
//        var_dump()
        return $result;
    }

    public function deleteAuth()
    {
        $result = session_destroy();
        return $result;
    }

    private function generateCode($length = 6)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0, $clen)];
        }

        return $code;
    }

}

//$c = new Auth();
//$x = $c->getAuth();