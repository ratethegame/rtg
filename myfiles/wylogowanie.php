<?php session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Rate the Game</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<!--[if IE 6]><link rel="stylesheet" href="css/ie6-style.css" type="text/css" media="all" /><![endif]-->
<script src="js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="js/fns.js" type="text/javascript"></script>
</head>
<body>
<!-- Page -->
<div id="page" class="shell">
  <!-- Header -->
  <div id="header">
    <!-- Top Navigation -->
    <div id="top-nav">
      <ul>
        <li class="home"><a href="index.php">home</a></li>
        <li><a href="#">pc</a></li>
        <li><a href="#">xone</a></li>
        <li><a href="#">ps4</a></li>
        <li><a href="#">xbox360</a></li>
        <li><a href="#">ps3</a></li>
        <li><a href="#">xbox</a></li>
        <li><a href="#">ps2</a></li>
        <li><a href="#">psp</a></li>
        <li class="last"><a href="#">ds</a></li>
      </ul>
    </div>
    <!-- / Top Navigation -->
    <div class="cl">&nbsp;</div>
    <br>
    <!-- Logo -->

    <div id="logo">
        <img src="css/images/baner6.png" alt="" /> 
    <!-- / Logo -->

    <div class="cl">&nbsp;</div>
        <br>
    <!-- Sort Navigation -->
    <div id="sort-nav">
      <div class="bg-right">
        <div class="bg-left">
          <div class="cl">&nbsp;</div>
          <ul>
            <li class="first active first-active"><a href="#">Recenzje</a><span class="sep">&nbsp;</span></li>
            <li><a href="#">Premierowe gry</a><span class="sep">&nbsp;</span></li>
            <li><a href="#">Top Gry</a><span class="sep">&nbsp;</span></li>
            <li><a href="#">Wszystkie gry</a><span class="sep">&nbsp;</span></li>
			<li><a href="dodaj_gre.php">Dodaj grę</a><span class="sep">&nbsp;</span></li>
          </ul>
          <div class="cl">&nbsp;</div>
        </div>
      </div>
    </div>
    <!-- / Sort Navigation -->
  </div>
  <!-- / Header -->
  <!-- Main -->
  <div id="main">
    <div id="main-bot">
      <div class="cl">&nbsp;</div>
      <!-- Content -->
      <div id="content">
        <div class="block">
          <div class="block-bot">
            <div class="block-cnt">
				
				<!-- TUTAJ MOŻECIE WRZUCAĆ SWOJE ELEMENTY STRONY-->	
				<h1><center>Poprawnie wylogowano z serwisu.</center></h1>
          </div>
        </div>
      </div>
    </div>
    <!-- / Content -->
    <!--  -->
    <div id="sidebar">
      <!-- Search -->
      <div id="search" class="block">
        <div class="block-bot">
          <div class="block-cnt">
            <form action="#" method="post">
              <div class="cl">&nbsp;</div>
              <div class="fieldplace">
                <input type="text" class="field" value="Search" title="Search" />
              </div>
              <input type="submit" class="button" value="GO" />
              <div class="cl">&nbsp;</div>
            </form>
          </div>
        </div>
      </div>
      <!-- / Search -->
      <!-- Sign In -->
      <div id="sign" class="block">
        <div class="block-bot">
          <div class="block-cnt">
            <div class="cl">&nbsp;</div>
            <?php
				if(!empty($_SESSION['Username']))
				{
					echo "<center>Zalogowany jako: ".$_SESSION['Username']."</center><br/>";
					echo "<a href='wylogowanie.php' class='button button-left'>wyloguj się</a> <a href='moje_konto.php' class='button button-right'>moje konto</a>";
				}
				else
					echo "<a href='logowanie.php' class='button button-left'>zaloguj się</a> <a href='rejestracja.php' class='button button-right'>stwórz konto</a>";
			?>
            <div class="cl">&nbsp;</div>
            <p class="center"><a href="#">Pomoc?</a>&nbsp;&nbsp;<a href="#">Zapomniałeś hasła?</a></p>
          </div>
        </div>
      </div>
      <!-- / Sign In -->
      <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt">
              <h3>Top Gry</h3>
            </div>
          </div>
          <div class="image-articles articles">
            <div class="cl">&nbsp;</div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/img1.gif" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">TMNT</a></h4>
                <p>TPP</p>
                <p>PC PS3 XBOX360</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/warthunder.jpg" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">War Thunder</a></h4>
                <p>MMO</p>
                <p>PC PS4</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/img3.gif" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">Steel Fury</a></h4>
                <p>Symulator</p>
                <p>PC</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="cl">&nbsp;</div>
            <a href="#" class="view-all">więcej...</a>
            <div class="cl">&nbsp;</div>
          </div>
        </div>
      </div>
      <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt">
              <h3>Filmy</h3>
            </div>
          </div>
          <div class="image-articles articles">
            <div class="cl">&nbsp;</div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/crysis3.jpg" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">Crysis 3</a></h4>
                <p>Trailer #1 (PL)</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/codmw3.jpg" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">Call of Duty: Modern Warfare 3</a></h4>
                <p>Spec Ops Survival</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="article">
              <div class="cl">&nbsp;</div>
              <div class="image"> <a href="#"><img src="css/images/dgi.jpg" alt="" /></a> </div>
              <div class="cnt">
                <h4><a href="#">Dragon Age: Inkwizycja</a></h4>
                <p>E3 2013 teaser</p>
              </div>
              <div class="cl">&nbsp;</div>
            </div>
            <div class="cl">&nbsp;</div>
            <a href="#" class="view-all">więcej...</a>
            <div class="cl">&nbsp;</div>
          </div>
        </div>
      </div>
      <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt">
              <h3>Ostatnio edytowane</h3>
            </div>
          </div>
          <div class="text-articles articles">
            <div class="article">
              <h4><a href="#">Lego Star Wars</a></h4>
              <small class="date">21.07.09</small>
          
            </div>
            <div class="article">
              <h4><a href="#">Darksiders</a></h4>
              <small class="date">20.07.09</small>
          
            </div>
            <div class="article">
              <h4><a href="#">Grid 2</a></h4>
              <small class="date">19.07.09</small>
       
            </div>
            <div class="article">
              <h4><a href="#">Alan Wake</a></h4>
              <small class="date">15.07.09</small>
       
            </div>
            <div class="cl">&nbsp;</div>
            <a href="#" class="view-all">więcej...</a>
            <div class="cl">&nbsp;</div>
          </div>
        </div>
      </div>
    </div>
    <!-- / Sidebar -->
    <div class="cl">&nbsp;</div>
    <!-- Footer -->
    <div id="footer">
      <div class="navs">
        <div class="navs-bot">
          <div class="cl">&nbsp;</div>
          <ul>
            <li><a href="#">community</a></li>
            <li><a href="#">forum</a></li>
            <li><a href="#">video</a></li>
            <li><a href="#">cheats</a></li>
            <li><a href="#">features</a></li>
            <li><a href="#">downloads</a></li>
            <li><a href="#">sports</a></li>
            <li><a href="#">tech</a></li>
          </ul>
          <ul>
            <li><a href="#">pc</a></li>
            <li><a href="#">xone</a></li>
            <li><a href="#">ps4</a></li>
            <li><a href="#">xbox360</a></li>
            <li><a href="#">ps3</a></li>
            <li><a href="#">xbox</a></li>
            <li><a href="#">ps2</a></li>
            <li><a href="#">psp</a></li>
            <li><a href="#">ds</a></li>
          </ul>
          <div class="cl">&nbsp;</div>
        </div>
      </div>
      <p class="copy">&copy; Design by Team Zbysio</p>
    </div>
    <!-- / Footer -->
  </div>
</div>
<!-- / Main -->
</div>
<!-- / Page -->
</body>
</html>
