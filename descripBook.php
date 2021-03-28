<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/DescripBook.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Описание книги</title>

</head>

<body>
    
    <?php include ('headers/headermain.php');?>
    <div class="container1">
        <?php
        $host = 'localhost';
        $user = 'mysql';
        $password = 'mysql';
        $database = "internetmagazin";
        $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");
        $IDBook = $_GET['id_book'];
        if ($_GET['id_book'] != 0)
        {
            $query = "SELECT * FROM books WHERE id = '$IDBook'";
            $result = mysqli_query($link, $query);
            
            if (mysqli_num_rows($result) > 0)
            {
                while ($row = mysqli_fetch_assoc($result))
                {
                    echo "<div class='borderBook'>";
                    echo "<br><div class='descimg'><img class='images' src='".$row['image']."'></div>";
                    echo "<div class='info_descrip'>";
                    echo "<div class='descnm'>"; echo $row['name']."</div><br>";
                    echo "<div class='authorbook'>Автор: "; echo "<a class='descrat'>".$row['author']."</a></div>";
                    echo "<div class='authorbook'>Жанр: "; echo "<a class='descrat'>".$row['category']."</a></div><br>";
                    echo "<div class='authorbook'>Возрастное ограничение: "; echo "<a class='pricebook'>".$row['vozrast']."+</a></div>";
                    echo "<div class='authorbook'>Год написания: "; echo "<a class='pricebook'>".$row['year']."</a></div>";
                    echo "<div class='authorbook'>Объем: "; echo "<a class='pricebook'>".$row['volume']." Страниц</a></div><br>";
                    echo "<div class='authorbook'>Цена: "; echo "<a class='pricebook'>".$row['price']." Pуб ";
                    if ($_COOKIE['cookie_log']): echo "<br><br><a
                    class='link' href='cart.php?course_id=".$row['id']."'>В
                    корзину</a>";
                    endif; echo "</div>";
                    if (!$_COOKIE): echo "<br><div
                    class='searchpr1'><a class='link2' href='Reg.php'>Чтобы купить
                    войдите или зарегистрируйтесь</a></div><br>"; endif;
                    if ($_COOKIE['cookie_log_vladel']): echo "<br><a
                    class='link'
                    href='delete.php?del=".$row['id']."'>Удалить</a><br>";
                    endif;
                    echo "<br><div class='authorbook'>Описание: ";
                    echo "<br><br><a class='descrat'>".$row['description']."</a></div><br>";
                    echo "</div></div></div>";
                }
            }
        }
        ?>
    </div>
    <?php require ("footer.php")?>
</body>
</html>
