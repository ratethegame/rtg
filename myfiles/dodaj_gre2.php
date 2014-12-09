<?php session_start(); ?>
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
				<?php
					$nazwa = $_POST['nazwa'];
					$data_swiat = $_POST['rok_s']."-".$_POST['miesiac_s']."-".$_POST['dzien_s'];
					$data_polska = $_POST['rok_p']."-".$_POST['miesiac_p']."-".$_POST['dzien_p'];
					$gatunek = $_POST['gatunek'];
					$wydawca = $_POST['wydawca'];
					$opis = $_POST['opis'];
					$dodal = $_SESSION['Username'];
					$dodano_czas = date('Y-m-dH:i:s');
					$s_platforma = "";
					$okladka = $_POST['okladka'];
						
					if(!empty($_POST['screen']))
						$screen = $_POST['screen'];
					else
						$screen = "NULL";
					
					if(!empty($_POST['trailer']))
						$trailer= $_POST['trailer'];
					else
						$trailer = "NULL";
						
					if(!empty($_POST['gameplay']))
						$gameplay = $_POST['gameplay'];
					else
						$gameplay = "NULL";
						
					if(!empty($_POST['platforma']))
					{
						foreach($_POST['platforma'] as $platforma)
						{
							$s_platforma = $s_platforma . $platforma . ";";
						}
						$s_platforma = substr($s_platforma, 0, -1);

						$nazwa = str_replace(' ', '_', $nazwa);
						$gatunek = str_replace(' ', '_', $gatunek);
						$wydawca = str_replace(' ', '_', $wydawca);
						$opis = str_replace(' ', '_', $opis);
						$dodal = str_replace(' ', '_', $dodal);
						/*
						echo $nazwa."<br/>";
						echo $data_swiat."<br/>";
						echo $data_polska."<br/>";
						
						echo $gatunek."<br/>";
						
						echo $wydawca."<br/>";
						echo $s_platforma."<br/>";
						
						echo $opis."<br/>";
						echo $okladka."<br/>";
						echo $screen."<br/>";
						echo $trailer."<br/>";
						echo $gameplay."<br/>";
						
						echo $dodal."<br/>";
						echo $dodano_czas."<br/>";
						*/
						$output = shell_exec('java Client '.$nazwa.' '.$data_swiat.' '.$data_polska.' '.$gatunek.' '.$wydawca.' '.$s_platforma.' '.$opis.' '.$okladka.' '.$screen.' '.$trailer.' '.$gameplay.' '.$dodal.' '.$dodano_czas);
						//echo $output;
						$checker = substr($output, 0, -1);
						//echo "output = "; echo $output;
						//echo "checker = "; echo $checker;
						
						if($checker == "200")
						{
							echo "<br/><h1><b><center>Dziękujemy za dodanie nowej gry!</center></b></h1><br/><br/>
								<small><center>Twoja gra trafiła do bazy gier niezatwierdzonych. 
								W ciągu 24 godzin administratorzy zwryfikują Twoja grę i w przypadku braku zastrzeżeń wprowadzona gra trafi do naszego serwisu. 
								W razie potrzeby skontaktuj się z naszymi administratorami.</center></small>";
						}
						else
						{
							echo "<center><h1>Wystąpił nieoczekiwany błąd.</h1><br/><a href=\"dodaj_gre.php\">Spróbuj jeszcze raz</a>.</center>";
						}
					}
					else
					{
						echo "<center>Nie wybrano żadnej platformy. Sróbuj jeszcze raz</center>";
					}
				?>		
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
