<?php
  include 'dobavZakaz.php';

  $host = '127.0.0.1';
  $user = 'reguser';
  $password = '12Ad34';
  $database = "internetmagazin";
  $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

  if ($_COOKIE['cookie_log'] != "")
  {
    $IDBook = $_GET['course_id'];
    $IDpolzovatel = $_COOKIE['cookie_log'];

    if ($_GET['course_id'] != 0)
    {
      header("Location: cart.php");
      $queryProv = "SELECT * FROM cart WHERE ID_Book = '$IDBook' AND ID_User = '$IDpolzovatel'";
      $resultProv = mysqli_query($link, $queryProv);

       if (empty(mysqli_fetch_assoc($resultProv)))
      {
        $queryInser = "INSERT INTO cart(ID, ID_Book, ID_User, kolvoCart) VALUES(NULL, '$IDBook','$IDpolzovatel','1')";
        $resultInser = mysqli_query($link, $queryInser);
      }
    };
  }
    $querySEl = "SELECT * FROM cart,books WHERE ID_Book = books.id AND ID_User = $IDpolzovatel";
    $resultSEL = mysqli_query($link, $querySEl);
    $query1= "SELECT COUNT(*) FROM cart WHERE '$IDpolzovatel' = ID_User";
    $result1= mysqli_query($link, $query1);
    
    if ($_GET['deleteall'] != 0)
    {
      header("Location: cart.php");
      $deletealll = $_GET['deleteall'];
      $query1d = "DELETE FROM cart WHERE ID_Book = $deletealll AND ID_User = $IDpolzovatel";
      $result1d = mysqli_query($link, $query1d);
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Корзина</title>

  </head>

  <body>

    <?php require ('headers/headermain.php');?>
    <div class="container1">
      <?php
      $cnt = mysqli_fetch_row($result1)[0];
      if (mysqli_num_rows($resultSEL) > 0)
      {
        echo "<div class =
        border_info>"."<a class= kolvobook>"."Количество книг в
        корзине:
        ".$cnt."</a><br><br>";
        while ($row = mysqli_fetch_assoc($resultSEL))
        {
          $CartSum = $row['price']*$row['kolvoCart'];
          $Summa = $Summa + $CartSum;
          echo "<div class = borderTovar>
                  <div class = 'cart_loc'>";
          echo "<img class='images' src='".$row['image']."'><br>";
          echo "<div class = 'book_info'>";
          echo "<a class = bookname>".$row['name']."<br><br>";
          echo "<div class='author_cart'><b>Автор: </b>".$row['author']."</div>";
          echo "<div class='category_cart'><b>Жанр: </b>".$row['category']."</div>";
          echo "</a><div class = bookprice>Цена книги: <a class='pricebook'>".$row['price']."&nbsp;Руб.</a>";
          echo "<a class='link2' href='cart.php?deleteall=".$row['ID_Book']."'>Удалить</a></div></div></div></div>";
        }
          echo "<a class = 'summZak'>Сумма заказа: $Summa Руб.</a>";
          echo "<br><br>";
          echo "<form method = 'POST'><a class = 'addtocart' href=\"Books.php\">Добавить в корзину</a>";
          echo "<input class = 'addtocart1' type = 'submit' name = 'order' value = 'Оформить заказ'></form></div>";
      }
      else
      {
        echo "<a class='cartclear'>В вашей корзине пусто!</a>";
      }?>
    </div>
  </body>
</html>
