<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Books.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Книги</title>
    
  </head>

  <body>
    <?php require 'headers/headermain.php'; ?>
    <div class="intro_2">
      <form class="searchcss" name="search" method="post" action="#">
        <select class="select__op" name="searchtype">
          <option value="Все">Все</option>
          <option value="Название">Название</option>
          <option value="Автор">Автор</option>
          <option value="Жанр">Жанр</option>
        </select>
        <input class="search_string" type="search" name="query" placeholder="Поиск книг" autocomplete="off">
        <input class="button_search" name="value_search" type="submit" value="Найти">
      </form>
    </div>
    <div class= respoi>
      <div class= respoi__items>
        <?php
        $IDpolzovatel = $_COOKIE['cookie_log'];
        $mysqli = new mysqli("localhost","mysql","mysql",'internetmagazin');
        $resultkatalog = $mysqli->query("SELECT * FROM `books` ORDER BY name");
        if(isset($_POST["value_search"]))
        {
          $value_search = filter_var(trim($_POST['query']),FILTER_SANITIZE_STRING);
          $value_kategory = $_POST['searchtype'];
          $flag=true;
          if (!$value_search) die ('<div class="texterror">Ничего не найдено. Извините!</div>');
          
          if ($mysqli->connect_error)
          {
            die('Ошибка : ('. $mysqli->connect_errno .') '.
            $mysqli->connect_error);
          }
          switch($value_kategory)
          {
            case "Все":
            $result = $mysqli->query("SELECT * FROM `books` WHERE name
            like '%".$value_search."%' || author like '%".$value_search."%'
            || category like '%".$value_search."%'");
            break;
            case "Название":
            $result = $mysqli->query("SELECT * FROM `books` WHERE name like '%".$value_search."%'");
            break;
            case "Автор":
            $result = $mysqli->query("SELECT * FROM `books` WHERE author like '%".$value_search."%'");
            break;
            case "Жанр":
            $result = $mysqli->query("SELECT * FROM `books` WHERE category like '%".$value_search."%'");
            break;
          }
          while ($row = mysqli_fetch_assoc($result))
          {
            $flag=false;
          ?>
            <br>
            <div class="searchimg"><a href="descripBook.php?id_book=<? echo $row['id']?>">
              <? echo "<img class='images' src='".$row['image']."'>"?></a>
              <div class="searchnm"><?php echo $row['name'] ?></div>
              <div class="searchat"><?php echo $row['author'] ?></div>
              <br>
              <div class="searchpr"><?php echo $row['price']." &#8381; ";
                if ($_COOKIE['cookie_log']):?><a class="link" href="cart.php?course_id=<?php echo $row['id'] ?>">В корзину</a><?php endif;?>
              </div>
              <?php 
                if (!$_COOKIE): echo '<div class="searchpr1"><a class="link2" href="Reg.php">Чтобы купить войдите или зарегистрируйтесь</a></div>'; endif;
              ?>
              <br>
              <?php 
                if ($_COOKIE['cookie_log_vladel']):?><a class="link" href="delete.php?del=<?php echo $row['id'] ?>">Удалить</a><?php endif;?>
              <br>
              <br>
            </div>
            <?php
          }
          
          if($flag)
          {
            echo '<div class="texterror">Ничего не найдено. Извините!</div>';
          }
        }
        else
        {
          while ($row = mysqli_fetch_assoc($resultkatalog))
          {
            $flag=false;
            ?>
            <br>
            <div class="searchBook"><a class="descripBook__link" href="descripBook.php?id_book=<? echo $row['id']?>">
            <? echo "<img class='images' src='".$row['image']."'>"?></a>
              <div class="searchnm"><?php echo $row['name'] ?></div>
              <div class="searchat"><?php echo $row['author'] ?></div>
              <br>
              <div class="searchpr"><?php echo $row['price']." &#8381; ";?>
              <?
              // $queryProv = "SELECT book_keys.ID_Book FROM book_keys,cart WHERE cart.ID_Book = book_keys.ID_Book AND book_keys.ID_User = '$IDpolzovatel'";
              // $resultProv = mysqli_query($mysqli, $queryProv);
              // if (empty(mysqli_fetch_assoc($resultProv)))
              // {
              if($_COOKIE['cookie_log']):?>
                <a class="link" href="cart.php?course_id=<?php echo $row['id'] ?>">В корзину</a>
              <? endif;/*}*/?>
              </div>
              <?php if (!$_COOKIE): 
                echo '<div class="searchpr1"><a class="link2" href="Reg.php">Чтобы купить войдите или
                зарегистрируйтесь</a></div>';
              endif;?>
              <br>
              <?php if ($_COOKIE['cookie_log_vladel']):?>
                <a class="link" href="delete.php?del=<?php echo $row['id'] ?>">Удалить</a><?php
              endif;?>
              <br>
              <br>
            </div>
            <?
          }
        }
        ?>
      </div>
    </div>
  </body>
</html>