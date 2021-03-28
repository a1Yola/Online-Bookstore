<?php
    setcookie("cookie_log", $IDpolzovatel['ID'], time()-60*60*24);
    setcookie("cookie_log_vladel", $IDpolzovatel['ID'], time()-60*60*24);
    header ('location: /');
?>
