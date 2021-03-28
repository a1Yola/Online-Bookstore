<?php
    $host = 'localhost';
    $user = 'mysql';
    $password = 'mysql';
    $database = "internetmagazin";

    if (isset ($_POST["send2"] ) )
    {
        if ($_COOKIE['cookie_log_vladel'])
        {
            $NAME = trim($_POST["name"]);
            $CATEGORY =trim($_POST["category"]);
            $AUTHOR = trim($_POST["author"]);
            $PRICE = trim($_POST["price"]);
            $KOLVO = trim($_POST["kolvo"]);
            $KEY = trim($_POST["key_book"]);
            $HREF = trim($_POST["href"]);
            $DESCRIPTION = trim($_POST["description"]);
            $error_name="";
            $error_category="";
            $error_author="";
            $error_price="";
            $error_kolvo="";
            $error_href="";
            $error_key = "";
            $error_description = "";

            $error = false;

            if($NAME =="")
            {
                $error_name="Выберите название";
                $error = true;
            }
            if($CATEGORY =="")
            {
                $error_category="Укажите жанр";
                $error = true;
            }
            if($AUTHOR =="")
            {
                $error_author="Укажите автора";
                $error = true;
            }
            if($PRICE =="")
            {
                $error_price="Укажите цену";
                $error = true;
            }
            if($KOLVO =="")
            {
                $error_kolvo="Укажите количество книг";
                $error = true;
            }
            if($KEY == "")
            {
                $error_key="Укажите ключ";
                $error = true;
            }
            if($DESCRIPTION =="")
            {
                $error_description="Укажите описание книги";
                $error = true;
            }
            if($HREF =="")
            {
                $error_href="Укажите ссылку на книгу";
                $error = true;
            }

            $Res_inf = "";

            if ($error == false)
            {
                $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");
                
                if (!empty(mysqli_fetch_assoc(mysqli_query($link,'SELECT * FROM books WHERE name = "'.$NAME.'"'))))
                {
                    $query1 = "UPDATE books SET category = '$CATEGORY', author =
                    '$AUTHOR', price = '$PRICE', kolvo = '$KOLVO', href = '$HREF',
                    key_book = '$KEY', description = '$DESCRIPTION' WHERE name =
                    '$NAME'";
                    $result_db = mysqli_query ($link, $query1);

                    if($result_db)
                    {
                        header('Location: updateBook.php');
                        $Res_inf = "Книга была успешно изменена";
                    }
                    else
                    {
                        $Res_inf = "Не удалось изменить книгу!";
                    }
                    mysqli_close($link);
                }
                else
                {
                $Res_inf = "Книга уже изменена!";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/UpdateBook.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Изменить книгу</title>

    </head>

    <body>

        <?php require ("headers/headermain.php")?>

        <div class="container1">
            <form class="form1" method="post">
                <a class="dobavb">Измененеие книги на сайте</a>
                <br>
                <br>
                <a class="dobavb">Выберите книгу:</a>
                <br>
                <br>
                <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_name?> </span>
                <select name="name"><br/>
                    <option value="0" style=" text-align: center;display:none;">Выберите книгу из списка</option>
        <?php
        $host = '127.0.0.1';
        $user = 'mysql';
        $password = 'mysql';
        $database = "magazin";
        $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

        $query_sp = "SELECT DISTINCT name FROM books";
        $result_sp = mysqli_query($link, $query_sp);

        if (mysqli_num_rows($result_sp) > 0)
        {
            while ( $row = mysqli_fetch_assoc( $result_sp ) )
            {
                echo "<option value=".$row['name' ].">".$row[ 'name' ]."</option>";
            }
            echo "</select><br>";
        }
        mysqli_close($link);
        ?>
                    <br>
                    <a class="dobavb">Введите новые данные:</a>
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_category?> </span>
                    <br>
                    <input class="round" type="text" name="category" placeholder="Жанр" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_author?> </span>
                    <br>
                    <input class="round" type="text" name="author" placeholder="Автор" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_price?> </span>
                    <br>
                    <input class="round" type="number" name="price" placeholder="Цена" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_kolvo?> </span>
                    <br>
                    <input class="round" type="number" name="kolvo" placeholder="Количество" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_href?> </span>
                    <br>
                    <input class="round" type="text" name="href" placeholder="Ссылка на книгу" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_key?> </span>
                    <br>
                    <input class="round" type="number" name="key_book" placeholder="Ключ для книги" value="">
                    <br>
                    <span style="margin-left: 15px; font-size: 16px; color:red"><?=$error_description?> </span>
                    <br>
                    <input class="round" type="text" name="description" placeholder="Описание" value="">
                    <br>
                    <br>
                    <div class="input">
                        <input class="round_button" type="submit" name="send2" value="Изменить книгу"></br>
                    </div>
                    <br>
                    <br>
                    <label style="color:#640002; font-size:22px;"><?=$Res_inf?></label>
            </form>
        </div>
    </body>
</html>