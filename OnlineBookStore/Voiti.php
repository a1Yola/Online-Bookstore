<?php
  $host = '127.0.0.1';
  $user = 'mysql';
  $password = 'mysql';
  $database = "internetmagazin";

  if(isset($_POST["send"]))
  {
    setcookie("cookie_log", '');
    setcookie("cookie_log_vladel", '');
    $uspass= trim($_POST["uspass"]);
    $usemail= trim($_POST["usemail"]);

    $error = false;
    $Res_inf = "";
    $type = 'USED';

    if($usemail =="" || $uspass =="")
    {
      $Res_inf="Не все данные введены!";
      $error = true;
      $type = 'NEW';
    }
    
    if ($error == false)
    {
      $link = mysqli_connect($host, $user, $password, $database) or die ("Невозможно подключение к MySQL");
        
      if (!empty($IDpolzovatel = mysqli_fetch_assoc(mysqli_query($link, 'SELECT * from users WHERE email = "'.$usemail.'" AND password = "'.$uspass.'" AND root = "USER"'))))
      {
        setcookie("cookie_log", $IDpolzovatel['ID'], time()+60*60*24);
        $Res_inf = "";
        header ('location: /');
        mysqli_close($link);
        if ( !$link ) $Res_inf = "";
      }
      elseif (!empty($IDpolzovatel = mysqli_fetch_assoc(mysqli_query($link, 'SELECT * from users
      WHERE email = "'.$usemail.'" AND password = "'.$uspass.'" AND root = "ADMIN"'))))
      {
        setcookie("cookie_log_vladel", $IDpolzovatel['ID'], time()+60*60*24);
        $Res_inf = "";
        header ('location: /');
        mysqli_close($link);
        if ( !$link ) $Res_inf = "";
      }
      else
      {
        $Res_inf = "Не правильно введена почта или пароль!";
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
    <link rel="stylesheet" href="css/Voiti.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Raleway&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Вход</title>

  </head>

  <body>

    <?php require ('headers/header2.php');?>

    <div class="<?php echo $style;?>">
                <span class="error_mess"><?=$Res_inf?> </span>
    </div>
    <main class= "log_container">
      <div class = "result_output">
        <form class="form_reg" name= "form_reg" action="" method="post">
          <label class="logLabel">Вход</label>
          <div>
            <p>Ваш email:</p>
            <input placeholder="Почта" name="usemail" type="email" required
                pattern="^[a-zA-Z0-9\.\_\-]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]{2,64}">
          </div>
          <div>
            <p>Ваш пароль:</p>
            <input placeholder="Пароль" name="uspass" type="password"/>
          </div>
          <div class="logButton">
            <button class="buttonLogIn" type="submit" name="send">Войти</button>
          </div>
          <p class="regtext">Еще не зарегистрированы?<a href= "Reg.php">Регистрация</a>!</p>
        </form>
      </div>
    </main>
  </body>
</html>
