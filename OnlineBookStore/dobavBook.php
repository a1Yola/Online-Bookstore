<?php
    $host = 'localhost';
    $user = 'mysql';
    $password = 'mysql';
    $database = "internetmagazin";

    if (isset ($_POST["send2"] ) ) 
    {
        if ($_COOKIE['cookie_log_vladel']) 
        {
            $NAME = addslashes(trim($_POST["name"]));
            $CATEGORY =addslashes(trim($_POST["category"]));
            $AUTHOR = addslashes(trim($_POST["author"]));
            $YEAR = addslashes(trim($_POST["year"]));
            $PRICE = addslashes(trim($_POST["price"]));
            $IMAGE = addslashes(trim($_POST["image"]));
            $VOLUME = addslashes(trim($_POST["volume"]));
            $VOZRAST = addslashes(trim($_POST["vozrast"]));
            $DESCRIPTION = addslashes(trim($_POST["description"]));
            $HREF = addslashes(trim($_POST["href"]));

            $error_mess="";
            $type = 'USED';
            $error = false;

            if($NAME =="" || $CATEGORY =="" || $AUTHOR =="" || $YEAR =="" || $PRICE ==""
            || $IMAGE =="" || $VOLUME =="" || $VOZRAST =="" || $DESCRIPTION =="" || $HREF =="") 
            {
                $error_mess="Не все данные введены";
                $error = true; 
                $type = 'NEW';
            }
 
            $Res_inf = "";

            if ($error == false)
            {
                $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");
                
                
                if (empty(mysqli_fetch_assoc(mysqli_query($link,'SELECT name,
                author from books WHERE name="'.$NAME.'" and author= "'.$AUTHOR.'"'))))
                {
                    $query1 = "INSERT INTO books (id, name, category, author, year,
                    volume, vozrast, description, price, image, href
                    ) VALUES (NULL, '".$NAME."', '".$CATEGORY."',
                    '".$AUTHOR."', '$YEAR', '$VOLUME', '$VOZRAST', '$DESCRIPTION',
                    '".$PRICE."', '$IMAGE', '$HREF')";
                    $result_db = mysqli_query ($link, $query1);

                    if($result_db)
                    {
                        $Res_inf = "Новая книга добавлена в продажу";
                        header ('Location: /dobavBook.php');
                    }
                    else
                    {
                        $Res_inf = "Не удалось добавить книгу!";
                        $type = 'NEW';
                    }
                    mysqli_close($link);
                }
                else
                {
                    $Res_inf = "Книга уже есть в продаже!";
                    $type = 'NEW';
                }
            }
            if($type == 'NEW')
            {   
                $style = "error_container_new";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>

        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/DobavBook.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Добавить книгу</title>

    </head>
    
    <body>

        <?php require ("headers/headermain.php")?>

        <div class="<?php echo $style;?>">
                <span class="error_mess"><?=$error_mess?> </span>
                <span class="error_mess"><?=$Res_inf?> </span>
        </div>
        <div class="container1">
            <form class="form1" method="post" id = "form">
                <a class="dobavb">Добавление книги на сайт</a><br><br>
                
                <input class="round" type="text" name="name" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\s]{1,55}$" placeholder="Название">
                <input class="round"type="text" name="category" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\s]{1,25}$" placeholder="Жанр" value="">
                <input class="round"type="text" name="author" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\s]{1,25}$" placeholder="Автор"value="">
                <input class="round"type="number" name="year" placeholder="Год написания" value="">
                <input class="round"type="number" name="volume" placeholder="Объем книги" value="">
                <input class="round"type="number" name="vozrast" placeholder="Возрастное ограничение" value="">
                <input class="round"type="number" name="price" placeholder="Цена" value="">
                <input class="round"type="text" name="image" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\.\/]{1,35}$" placeholder="Ссылка на изображение" value="">
                <input class="round"type="text" name="href" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\.\/]{1,35}$" placeholder="Ссылка на книгу" value="">   
                <input class="round1"type="text" name="description" required pattern = "^[аA-Za-zА-Яа-яЁё0-9\s]+$" placeholder="Описание" value="">
                <div class="input">
                    <input class="round_button" type="submit" name="send2" value="Добавить книгу"></br>
                </div><br>
            </form>
        </div>
    </body>
</html>
