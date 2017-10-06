<?php

setcookie("dfs",'asd' , time() + 60 * 60 * 24 * 30);
//setcookie("hash", $hash, time() + 60 * 60 * 24 * 30);
var_dump($_COOKIE);
