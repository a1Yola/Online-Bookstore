<?php
  $host = '127.0.0.1';
  $user = 'mysql';
  $password = 'mysql';
  $database = "internetmagazin";

  if(isset($_POST["order"]))
  {
    $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

    $IDpolzovatel = $_COOKIE['cookie_log'];
    $query = "SELECT SUM(price) FROM (SELECT cart.ID, ID_User, ID_Book, price FROM cart, books WHERE ID_Book = books.id) AS korz WHERE ID_User = '$IDpolzovatel'";
    $result= mysqli_query($link, $query);
    $cnt = mysqli_fetch_row($result)[0];

    settype($cnt,"integer");
    date_default_timezone_set('Europe/Moscow');
    $today = date("Y-m-d");
    $Nomer1 = (string)date("Ymdhis");
    $Nomer2 = (string)$IDpolzovatel;
    $Nomer = "$Nomer1$Nomer2";

    if($cnt != 0)
    {
      $query_key = "SELECT books.id FROM books,cart WHERE ID_User = '$IDpolzovatel' AND ID_Book = books.id";
      $result_key = mysqli_query($link, $query_key);

      while ($Nomer3 = mysqli_fetch_assoc($result_key))
      { 
          $IDbook = $Nomer3['id'];
          $KEY = (string)date("his");
          $Nomer4 = "$IDbook$Nomer2$KEY";
          $KEY2 = (int)$Nomer4.rand(1,99);

          $queryProv = "SELECT ID_Book FROM book_keys WHERE ID_Book = '$IDbook' AND ID_User = '$IDpolzovatel'";
          $resultProv = mysqli_query($link, $queryProv);

          if (empty(mysqli_fetch_assoc($resultProv)))
          {
            $queryInsert_key = "INSERT INTO book_keys VALUES (NULL, $KEY2, $IDpolzovatel, $IDbook, '1')";
            $resultInsert_key= mysqli_query($link, $queryInsert_key);
          }
          else
          { 
            $KEYNEW = (string)date("his");
            $NomerK = "$IDbook$Nomer2$KEYNEW";
            $KeyUpdate = (int)$NomerK.rand(99,1);
            $queryUpdate_key = "UPDATE book_keys SET book_keys.key = '$KeyUpdate' WHERE ID_Book = '$IDbook' AND ID_User = '$IDpolzovatel'";
            $resultUpdate_key= mysqli_query($link, $queryUpdate_key);
          }
      }
      
      $query_id = "SELECT ID FROM cart WHERE ID_User = '$IDpolzovatel'";
      $result_id = mysqli_query($link,$query_id);
      
      while ($IDkorzTov = mysqli_fetch_assoc($result_id))
      {
        $IDDkorz = $IDkorzTov['ID'];
        
        $query_order = ("INSERT INTO orders (`id`,`ID_cart`,`ID_User`,`name`,`nomer_order`,`summa`,`name_book`,`author_book`,`href`, `Key_book`, `date_order`)
        VALUES (
        NULL,
        '$IDDkorz',
        '$IDpolzovatel',
        (SELECT name FROM users WHERE ID = '$IDpolzovatel'),
        '$Nomer',
        (SELECT DISTINCT books.price*cart.kolvoCart AS summa FROM books INNER JOIN cart ON cart.ID_User = '$IDpolzovatel' AND cart.ID_Book = books.id AND cart.ID = '$IDDkorz'),
        (SELECT `name` FROM `cart`,`books` WHERE cart.ID = '$IDDkorz' AND ID_Book = books.id),
        (SELECT `author` FROM `cart`,`books` WHERE cart.ID = '$IDDkorz' AND ID_Book = books.id),
        (SELECT books.href FROM books,cart WHERE cart.ID = '$IDDkorz' AND ID_Book = books.id),
        (SELECT book_keys.key FROM book_keys JOIN cart WHERE cart.ID_Book = book_keys.ID_Book AND book_keys.ID_User = '$IDpolzovatel' AND cart.ID = '$IDDkorz'),
        CURRENT_DATE())");
        $result_order = mysqli_query($link,$query_order);
      }
      
      if ($result_order)
      {
      $quaryClear = "DELETE FROM `cart` WHERE ID_User = '$IDpolzovatel'";
      $resultClear = mysqli_query($link, $quaryClear);
      if($resultClear) header("Location: Zakaz.php");
      }
    }
  }
?>
