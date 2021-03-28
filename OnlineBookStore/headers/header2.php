<header class="header">
 <div class="container">
 <div class="header__inner">
 <nav class="logo">
 <a class="logo__link" href="index.php">eBooks</a>
 </nav>
 <nav class="nav">
 <?php if ($_COOKIE['cookie_log_vladel']):?>
 <a class="nav__link" href="admin.php">Администратор</a>
 <?php endif;?>
 <a class="nav__link" href="Books.php">Книги</a>
 <a class="nav__link" href="AboutUs.php">О нас</a>
 <?php if (!$_COOKIE):?>
 <a class="nav__link" href="Reg.php">Регистрация</a>
 <?php else:?>
 <a class="nav__link" href="Reg.php">Выход</a>
 <?php endif;?>
 <?php if ($_COOKIE['cookie_log']):?>
 <a class="nav__link" href="#"><img class="cartimg"
src="images/cart2.png" width="38"
 height="35" border = "0"></a>
 <?php endif;?>
 </nav>
 </div>
 </div>
</header>
