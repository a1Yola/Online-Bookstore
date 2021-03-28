<?
  include 'dobavZakaz.php';

  $host = '127.0.0.1';
  $user = 'reguser';
  $password = '12Ad34';
  $database = "internetmagazin";
  $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

  if ($_COOKIE['cookie_log'] != "")
  {
    $IDpolzovatel = $_COOKIE['cookie_log'];
    $queryot = "SELECT * FROM orders WHERE ID_User = $IDpolzovatel";
    $resultSEL = mysqli_query($link, $queryot);
    $queryotC = "SELECT DISTINCT nomer_order FROM orders WHERE ID_User = $IDpolzovatel";
    $resultSELC = mysqli_query($link, $queryotC);
    $query1="SELECT COUNT(*) FROM (SELECT DISTINCT `nomer_order` FROM orders WHERE ID_User = $IDpolzovatel) AS dt";
    $result1 = mysqli_query($link, $query1);
    $cnt = mysqli_fetch_row($result1)[0];
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

  <head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/Zakaz.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Заказы</title>

  </head>

  <body>
    
    <?php include ('headers/headermain.php');?>

    <div class="container1">
      <?php
      if (mysqli_num_rows($resultSELC) > 0)
      {
          function NUMtoSTRING($NUMBER, $ALPHA =
          '0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ'
          )
          {
            $ALPHA_LEN = mb_strlen($ALPHA, 'UTF-8');
            $STRNG = '';

            while($NUMBER > $ALPHA_LEN)
            {
              $STRNG = mb_substr($ALPHA, $NUMBER % $ALPHA_LEN, 1, 'UTF-8') . $STRNG;
              $NUMBER = floor($NUMBER / $ALPHA_LEN);
            }
            $STRNG = mb_substr($ALPHA, $NUMBER, 1, 'UTF-8') .$STRNG;
            return $STRNG;
          }
          echo "<div class = border_inf>"."<h2>"."Количество заказов: <a class = 'kolzak'>".$cnt."</a></h2>"."</div><br>";
          
          while ($roww = mysqli_fetch_assoc($resultSELC))
          {
            if (mysqli_num_rows($resultSEL) > 0)
            {
              $query = "SELECT SUM(summa) FROM orders WHERE nomer_order = $roww[nomer_order]";
              $result= mysqli_query($link, $query);
              $cnt11 = mysqli_fetch_row($result)[0];
            }
            echo "<div class = 'borderZakaz'><b style = 'font-size: 22px;'>Заказ номер:
            </b><a class='descrat' style = 'font-size: 22px;'>".$roww['nomer_order']."</a><br>";
            $queryzakaz = "SELECT name_book, author_book, href, Key_book, summa FROM orders WHERE ID_User = $IDpolzovatel AND nomer_order = $roww[nomer_order]";
            $reszakaz = mysqli_query($link, $queryzakaz);

            while ($rowzakaz = mysqli_fetch_assoc($reszakaz))
            {
              echo "</br><div style = 'font-size: 18px;'><a style = 'font-weight: bold;'>Книга: </a>";echo $rowzakaz['name_book'];
              echo "</div></br><a style = 'font-weight: bold; padding-bottom: 5px;'>Автор: </a>"; echo $rowzakaz['author_book'];
              echo "</br><a style = 'font-weight: bold; padding-bottom: 5px;'>Цена: </a>"; echo "<a class='descrat'>".$rowzakaz['summa']." Руб.</a>";
              echo "</br><a style = 'font-weight: bold; padding-bottom: 5px;'>Ключ для приложения: </a>"; echo "<a class='descrat'>".NUMtoSTRING($rowzakaz['Key_book'])."</a>";
              echo "</br><a style = 'font-weight: bold;'>Ссылка на скачивание книги: </a><a class = 'link' href=".$rowzakaz['href']." download>".$rowzakaz['name_book']."</a>";
              echo "</br></br></a>";
            }
            echo "<a style = 'font-weight: bold;'>Сумма заказа: </b><a class='descrat'>".$cnt11." Руб.</a></a><br><br>";
            echo "</div>";
          }
      }
      else
        {
          echo "<a style = 'margin-left: 155px;'>У вас нет заказов!</a>";
        }
      }
      ?>
    </div>
  </body>
</html>

<?
/* Код для расшифровки 

function STRINGtoNUM($STRNG, $ALPHA =
'0123456789aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ'
){
 $ALPHA_LEN = mb_strlen($ALPHA, 'UTF-8');
 $STRNG_LEN = mb_strlen($STRNG, 'UTF-8');
 $NUMBER = 0;
 for($S_i = 0; $S_i < $STRNG_LEN; $S_i++)
 $NUMBER += mb_strpos($ALPHA, mb_substr($STRNG, $S_i,
1, 'UTF-8'), 0, 'UTF-8') * pow($ALPHA_LEN, $STRNG_LEN - $S_i -
1);
 return $NUMBER;
}
echo STRINGtoNUM('1JWrBY'); // вернет нам наши
1526892347543
*/
?>
