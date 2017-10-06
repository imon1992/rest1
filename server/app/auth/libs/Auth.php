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
            $hash = md5($this->generateCode(10));

            $result = $this->authSql->setNewHash($hash, $idPassword[0]['id']);
            if ($result == true) {
                setcookie("id", $idPassword[0]['id'], time() + 60 * 60 * 24 * 30);
                setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);
            }


//            $this->checkAuth();
        } else {
            $result = "wrong password";
        }
        return $result;

    }

    public function getAuth($login = false,$password = false)
    {
        if (isset($_COOKIE['id']) && isset($_COOKIE['hash'])) {
            $idHash = $this->authSql->getIdHashByCookieId($_COOKIE['id']);

//        var_dump('cookie   '.$_COOKIE['hash']);
//        var_dump('hash    '.$idHash[0]['hash']);
            if (($idHash[0]['hash'] !== $_COOKIE['hash']) or ($idHash[0]['id'] !== $_COOKIE['id']))
            {
                setcookie("id", "", time() - 3600 * 24 * 30 * 12, "/");
                setcookie("hash", "", time() - 3600 * 24 * 30 * 12, "/");

                $result = false;
            } else {
                $result = true;
            }
        } else {
            $result = 'cookies is off';
        }
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
