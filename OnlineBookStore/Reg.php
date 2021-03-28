<?php
    $host = '127.0.0.1';
    $user = 'mysql';
    $password = 'mysql';
    $database = "internetmagazin";

    if(isset($_POST["send1"]))
    {
        $usname= addslashes(trim($_POST["username"]));
        $usemail= addslashes(trim($_POST["useremail"]));
        $uspass= addslashes(trim($_POST["userpass"]));
        $uspass2 = addslashes(trim($_POST["userpass2"]));
        $usphone= addslashes(trim($_POST["userphone"]));

        $Res_inf = "";
        $error = false;
        $type = 'USED';

        if($usname =="" || $usemail =="" || $uspass =="" || $uspass2 =="" || $usphone =="") 
        {
            $Res_inf="Не все данные введены!";
            $error = true; 
            $type = 'NEW';
        }
        if($uspass !== $uspass2) 
        {
            $Res_inf="Пароли не совпадают!";
            $error = true; 
            $type = 'NEW';
        }

        if ($error == false)
        {
            $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");

            if (empty(mysqli_fetch_assoc(mysqli_query($link,'SELECT email from users WHERE email = "'.$usemail.'"'))))
            {
                $query = "INSERT INTO users(name, email, password, phone) VALUES('".$usname."',
                '".$usemail."','".$uspass."', '".$usphone."')";
                $result = mysqli_query($link, $query);

                if ($result) 
                {
                    $Res_inf = "";
                    header("location:/Voiti.php");
                }
                else 
                {
                    $Res_inf = "Регистрация не успешна!";
                    $type = 'NEW';
                }

                mysqli_close($link);

                if ( !$link ) $Res_inf = "";
            }
            else
            {
                $Res_inf = "Данная почта уже зарегистрирована!";
                $type = 'NEW';
            }
        }

        if($type == 'NEW')
        {   
            $style = "error_container_new";
        }
    }   
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

    <head>

        <meta charset="utf-8">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/Reg.css">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Регистрация</title>
        

    </head>

    <body>

        <?php require ("headers/header.php") ?>

        <div class="<?php echo $style;?>">
                <span class="error_mess"><?=$Res_inf?> </span>
        </div>
        <div class="container_reg">

            <?php if (!$_COOKIE):?>
            <form action="#" method="post" enctype="multipart/formdata" autocomplete="off">
                <section class="section_reg">
                    <label class="regLabel">Регистрация</label>
                    <div>
                        <p>Введите имя:</p>
                        <input id="name" placeholder="Имя" tabindex="1" name="username" type="text" required
                            pattern="^[А-Яа-яЁёa-zA-Z\s]{1,20}$" title="Только буквы латиница и кириллица" />
                    </div>
                    <div>
                        <p>Введите Email:</p>
                        <input id="email" placeholder="Почта" tabindex="5" name="useremail" type="email" required
                            pattern="^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]{2,64}" />
                    </div>
                    <div>
                        <p>Введите пароль:</p>
                        <input id="pass" placeholder="Пароль" tabindex="3" name="userpass" type="password" required 
                            pattern="(?=^.{4,}$)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?!.*\W).*$" 
                            title="Пароль должен содержать минимум 4 символа, без пробеллов и с одной заглавной буквой"/>
                    </div>
                    <div>
                        <p>Повторите пароль:</p>
                        <input id="pass2" placeholder="Повторите пароль" tabindex="6" name="userpass2" type="password" required 
                            pattern="(?=^.{4,}$)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?!.*\s)(?!.*\W).*$" 
                            title="Пароль должен содержать минимум 4 символа, без пробеллов, с одной заглавной буквой и совпадать с предыдущем"/>
                    </div>
                    <div>
                        <p>Укажите номер телефона:</p>
                        <input id="phone" placeholder="Номер телефона" tabindex="4" name="userphone" type="tel" required
                            pattern="^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$" 
                            title="Номер должен содержать 11 цифр без пробеллов, начиная с +7,7 или 8" />
                    </div>
                    <div class="regButton">
                        <button id="butt" tabindex="8" name="send1" type="submit">Зарегистрироваться</button>
                    </div>
                        <p class="regtext">Уже зарегистрированы?<a href="Voiti.php">Войти!</a></p>
                </section>
            </form>
            <?php else:?>
                <p class="vtext">Чтобы выйти нажмите <a class="exitbt" href="exit.php">«Выход»</a></p>
            <?php endif;?>
        </div>
    </body>
</html>