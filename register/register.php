<?

//var_dump($_POST['password']);
//var_dump($_POST);

mysql_connect("localhost", "user14", "tuser14");

mysql_select_db("carTest5");

    $err = array();

    if(count($err) == 0)

    {
        $password = md5(md5(trim($_POST['password'])));
        $login = $_POST['login'];


        mysql_query("INSERT INTO users SET login='".$login."', password='".$password."'");

    }


?>