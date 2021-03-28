<header class="header">
 <div class="container">
 <div class="header__inner">
 <nav class="logo">
 <a class="logo__link" href="index.php">eBooks</a>
 </nav>
 <nav class="nav">
 <?php if ($_COOKIE['cookie_log_vladel']):?>
 <ul class="nav__link" id="navbar"> <li><a
class="nav__link" href="#">Администратор</a>
 <ul>
 <li><a class="nav__link2"
href="dobavBook.php">Добавить книгу</a></li>
 <li><a class="nav__link2"
href="updateBook.php">Изменить книгу</a></li>
 </ul>
 </li> </ul>
 <?php endif;?>
 <a class="nav__link" href="Books.php">Книги</a>
 <a class="nav__link" href="AboutUs.php">О нас</a>
 <?php if ($_COOKIE['cookie_log']):?>
 <a class="nav__link" href="Zakaz.php">Мои заказы</a>
 <a class="nav__link" href="cart.php"><img src="images/cart.png" width="33" height="30" border = "0"></a>
 <?php endif;?>
 <?php if (!$_COOKIE):?>
 <a class="nav__link" href="Voiti.php">Войти</a>
 <a class="nav__link" href="Reg.php">Регистрация</a>
 <?php else:?>
 <a class="nav__link" href="Reg.php">Выход</a>
 <?php endif;?>

 </nav>
 </div>
 </div>
</header>
