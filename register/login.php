<?

function generateCode($length=6) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";

    $code = "";

    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {

        $code .= $chars[mt_rand(0,$clen)];
    }

    return $code;

}




mysql_connect("localhost", "user14", "tuser14");

mysql_select_db("carTest5");




    # Вытаскиваем из БД запись, у которой логин равняеться введенному

    $query = mysql_query("SELECT id, password FROM users WHERE login='".mysql_real_escape_string($_POST['login'])."' LIMIT 1");

    $data = mysql_fetch_assoc($query);



    # Соавниваем пароли
//var_dump($data['password']);
//var_dump(md5(md5($_POST['password'])));
    if($data['password'] === md5(md5($_POST['password'])))

    {

        # Генерируем случайное число и шифруем его

        $hash = md5(generateCode(10));

//echo 4322423;



        # Записываем в БД новый хеш авторизации и IP

        mysql_query("UPDATE users SET hash='".$hash."' "." WHERE id='".$data['id']."'");



        # Ставим куки

        setcookie("id", $data['user_id'], time()+60*60*24*30);

        setcookie("hash", $hash, time()+60*60*24*30);



        # Переадресовываем браузер на страницу проверки нашего скрипта

 echo 'allIsGood';

    }

    else

    {

        print "Вы ввели неправильный логин/пароль";

    }



?>
