<?php
 $host = '127.0.0.1';
 $user = 'reguser';
 $password = '12Ad34';
 $database = "internetmagazin";
 $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

if ($_COOKIE['cookie_log_vladel'] != "")
{
    $del = $_GET['del'];

    if($_GET['del'] != 0)
    {
        $query = "DELETE FROM books WHERE books.id = $del";
        $result = mysqli_query($link, $query);
    }
    if($result)
    {
        header("location: /Books.php");
    }
}

mysqli_close($link);
?>
