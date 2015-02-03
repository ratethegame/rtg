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
		<?php	
		$platformy = json_decode(file_get_contents('http://localhost/REST_api.php?action=get_list'), true);
		foreach($platformy as $platforma)
			echo "<li><a href='gry_na_platforme.php?platforma=".$platforma."'>".$platforma."</a></li>";
		?>		
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
            <li><a href="premierowe_gry.php">Premierowe gry</a><span class="sep">&nbsp;</span></li>
            <li><a href="top_gry.php">Top Gry</a><span class="sep">&nbsp;</span></li>
            <li><a href="wszystkie_gry.php">Wszystkie gry</a><span class="sep">&nbsp;</span></li>
			<li><a href="dodaj_gre.php">Dodaj grę</a><span class="sep">&nbsp;</span></li>
			<?php
				if(!empty($_SESSION['Status'])){
					if($_SESSION['Status'] == 1)
					echo "<li><a href='panel.html' target='_blank'>Panel</a><span class='sep'>&nbsp;</span></li>";
				}
          ?>
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
			<!--PAGE CONTENT-->
			<?php
			if(!empty($_GET["nazwa_gry"]))
			{
				$nazwa = str_replace(" ", "_", $_GET["nazwa_gry"]);
				$info=file_get_contents('http://localhost/REST_api.php?action=get_game&nazwa='.$nazwa);
				$info = json_decode($info, true);
				if(!empty($info))
				{
				// zmienne do dodano ocene
					$game_title = $_GET["nazwa_gry"];
					$user_nickname = "";
					if(!empty($_SESSION['Username']))
					    $user_nickname = $_SESSION['Username'];
					$game_title = str_replace(' ', '_', $game_title); //do wyszukania oceny

					$users_rate_from_db = file_get_contents('http://localhost/REST_api.php?action=find_rate&game_title='.$game_title.'&user_nickname='.$user_nickname);
					$game_title = str_replace('_', ' ', $game_title);
					$zmienna_check1="";$zmienna_check2="";$zmienna_check3="";$zmienna_check4="";$zmienna_check5="";
					switch ($users_rate_from_db) {
						case '1':
							$zmienna_check1 = "checked";
							break;
						case '2':
							$zmienna_check2 = "checked";
							break;
						case '3':
							$zmienna_check3 = "checked";
							break;
						case '4':
							$zmienna_check4 = "checked";
							break;
						case '5':
							$zmienna_check5 = "checked";
							break;
						default:
							break;
					}
					
					$output = explode("|", $info[0]);
					$platformy=file_get_contents('http://localhost/REST_api.php?action=platforms&id_gry='.$output[0]);
					$average=file_get_contents('http://localhost/REST_api.php?action=find_average&nazwa='.$nazwa);
					echo "<table border='0' width='100%' height='100%'>";
					echo "<tr align='left' valign='middle'>";
					echo "<td width='35%' height='50%'>";
					echo "<img src='$output[7]' alt=$output[1]/>";
					echo "</td>";
					echo "<td width='65%' height='50%'>"; 
					echo "<font size='6' color='white'><b> $output[1] </b></font><br/><br/>";
					echo "<h3>Ocena: $average</h3>";
					echo "<br/>";
					echo "<p>Platformy: ".$platformy."</p><br/>";
					echo "<font size='2'> Premiera: </font><br/><br/><p>$output[2] (Świat) </p><br/>";
					echo "<p> $output[3] (Polska) </p><br/>"; 
					echo "<p> Gatunek: $output[4] </p><br/>";  
					echo "<p> Producent: $output[5] </p>";
					
					if(!empty($_SESSION['Username']))
					{
						$_SESSION['gameName'] = $output[1];
			?>
				<form action="post_rate.php" method="post"><br>
					<span class="star-rating">
					<input type="radio" name="rating" value="1" id="1" <?php echo $zmienna_check1 ?>><i></i>
					<input type="radio" name="rating" value="2" id="2" <?php echo $zmienna_check2 ?>><i></i>
					<input type="radio" name="rating" value="3" id="3" <?php echo $zmienna_check3 ?>><i></i>
					<input type="radio" name="rating" value="4" id="4" <?php echo $zmienna_check4 ?>><i></i>
					<input type="radio" name="rating" value="5" id="5" <?php echo $zmienna_check5 ?>><i></i>
					</span>
					<strong class="choice">Wybierz ocenę</strong>
					<script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
					<script>$(':radio').change( function(){ $('.choice').text( this.value + ' stars' );} )</script>
				<?php
					$radio='checked';	
					if(!empty($_SESSION['Username']))
						echo "<input type=submit id=rate value=Oceń>";
					else
						echo "<br/><a href='logowanie.php' class='button button-left'><font color=red>Zaloguj się by skomentować grę<color><br/></a><br/>"; 
				?>	
				</form>
				<?php
					}
					else
						echo "<br/><br/><a href='logowanie.php' class='button button-left'><font color=red>Zaloguj się by ocenić grę<color></a>";			
						echo "</td>"; 
						echo "</tr>"; 
						echo "<tr align='left' valign='middle'>"; 
						echo "<td colspan='2'> <br><br>";
						echo "<p><font size='3'> $output[6] </font></p>"; 
						echo "</td> </tr></table><br><br>";

						echo "<center><h2>GALERIA</h2><center><br/>";
						$obrazki= json_decode(file_get_contents('http://localhost/REST_api.php?action=get_pictures&nazwa='.$nazwa), true);
						$i=1;
						if(!empty($obrazki))
						{
							foreach($obrazki as $obrazek)
							{
								echo "<center><h2><a href='".$obrazek."' target='_blank'>obrazek".$i."</a></h2><center><br>";
								$i++;
							}
						}
						$filmiki = json_decode(file_get_contents('http://localhost/REST_api.php?action=get_movie&nazwa='.$nazwa), true);
						echo "<br/><center><h2>FILMIKI</h2><center><br/>";
						$i=1;
						if(!empty($filmiki))
						{
							foreach($filmiki as $filmik)
							{
								echo "<center><h2><a href='".$filmik."' target='_blank'>filmik".$i."</a></h2><center><br>";
								$i++;
							}
						}
				}
				else
					echo "<center><h1>Brak gry w bazie!</h1></center>";
			}
			else
			{
				if(!empty($_POST["nazwa_gry"]) && empty($_POST["gatunek"]) && empty($_POST["wydawca"]) && empty($_POST["platforma"]))
				{
					$nazwa = str_replace(" ", "_", $_POST["nazwa_gry"]);
					$list=file_get_contents('http://localhost/REST_api.php?action=get_game_list&nazwa='.$nazwa);
					$list = json_decode($list, true);
					if(!empty($list))
					{
						echo "<center><h1>Lista gier dla frazy '".$_POST["nazwa_gry"]."':</h1></center><br/><br/>";
						foreach ($list as $wynik)
							echo "<a href='wyswietl_gre.php?nazwa_gry=".$wynik."'>".$wynik."</a><br/>";
					}
					else
						echo "<center><h1>Brak gry w bazie!</h1></center>";
				}
				else
				{
					if((!empty($_POST["nazwa_gry"])) || (!empty($_POST["gatunek"])) || (!empty($_POST["wydawca"])))
					{
						$nazwa = str_replace(" ", "_", $_POST["nazwa_gry"]);
						$gatunek = str_replace(" ", "_", $_POST["gatunek"]);
						$wydawca = str_replace(" ", "_", $_POST["wydawca"]);
						$list=file_get_contents('http://localhost/REST_api.php?action=get_game_list_adv&nazwa='.$nazwa.'&gatunek='.$gatunek.'&wydawca='.$wydawca);
						$list = json_decode($list, true);
						if(!empty($list))
						{
							echo "<center><h1>Lista gier na podstawie podanych kryteriów:</h1></center><br/><br/>";
							foreach ($list as $wynik)
								echo "<a href='wyswietl_gre.php?nazwa_gry=".$wynik."'>".$wynik."</a><br/>";
						}
						else
							echo "<center><h1>Brak gry w bazie!</h1></center>";
					}
					else
						echo "<center><h1>Nie wpisano żadnej nazwy. Spróbuj jeszcze raz.</h1></center>";
				}
			}
			?>
          </div>
        </div>
		<div>
		<?php
		  if(!empty($info))
		  {
			echo "<br><br><br><br><br><br><br><center><h1>Komentarze:</h1></center>";
			$game_title = str_replace(' ', '_', $game_title);
			echo "<form>";
			$all_comments = file_get_contents('http://localhost/REST_api.php?action=show_comments&game_title='.$game_title);
			$all_comments = json_decode($all_comments, true);
			if(!empty($all_comments))
			{
				foreach($all_comments as $pojedynczy_komentarz)
				{
					$komentarze = explode("|", $pojedynczy_komentarz);
					echo "<fieldset><br>";
					echo "<legend>&nbsp&nbsp $komentarze[0] &nbsp&nbsp";
					switch ($komentarze[1]) 
					{
						case '1':
							echo "&#9733&#9734&#9734&#9734&#9734";
							break;
						case '2':
							echo "&#9733&#9733&#9734&#9734&#9734";
							break;
						case '3':
							echo "&#9733&#9733&#9733&#9734&#9734";
							break;
						case '4':
							echo "&#9733&#9733&#9733&#9733&#9734";
							break;
						case '5':
							echo "&#9733&#9733&#9733&#9733&#9733";
							break;
						default:
							echo "&#9734&#9734&#9734&#9734&#9734";
							break;
					}
					echo "&nbsp&nbsp</legend>";
					echo "<p> $komentarze[2] </p>";
					echo "<br></fieldset>";
					echo "<br>";
				}
				echo "</form>";
				$game_title = str_replace('_', ' ', $game_title);
			}
			else
			{
				echo "</form>";
				echo "<br/><h1><center>BRAK KOMENTARZY!</center></h1>";
			}		
			
			if(isset($_GET['error']))
				echo "Limit znaków wynosi 250!";
			echo "<br/><br/><h2>&nbsp&nbspWpisz swój komentarz:</h2>";
			?>
				
			<form action="post_comment.php" method="post"><br>
				<table border='0' width='100%' height='100%'>
					<tr align='center' valign='middle'> 
						<td width='35%' height='50%' colspan='2'><br>
							<textarea name="comment" cols="77" rows="5" maxlength="249"></textarea>
						</td>		
					<tr align='center' valign='middle'>
						<td>
							<textarea name="nickname" cols="35" rows="1" style="display:none;"><?php if(!empty($_SESSION['Username'])) echo "".$_SESSION['Username'];?></textarea>
						</td>
						<td>
							<textarea name="game_title" cols="35" rows="1" style="display:none;"><?php if(!empty($game_title)) echo "$game_title";?></textarea>
						</td>
					</tr>
					<tr align='center' valign='middle'> 
						<td colspan='2'>
						<?php
							if(!empty($_SESSION['Username']))
								echo "<input type=submit id=comment value=Skomentuj>";
							else
								echo "<br><a href='logowanie.php' class='button button-left'><font color=red>Zaloguj się by skomentować grę<color><br></a><br>";
							?>
						</td>
					</tr>
				</table>
			</form>
			<?php
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
            <form action="wyswietl_gre.php" method="post">
              <div class="cl">&nbsp;</div>
              <div class="fieldplace">
                <input type="text" name="nazwa_gry" class="field" value="Search" title="Search" />
              </div>
              <input type="submit" class="button" value="GO" />
			  <center><a href="szukanie_zaawansowane.php">Wyszukiwanie zaawansowane</a></center>
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
					echo "<a href='logowanie.php' class='button button-left'>zaloguj się</a> <a href='register.html' class='button button-right'>stwórz konto</a>";
			?>
			<div class="cl">&nbsp;</div>
          </div>
        </div>
      </div>
      <!-- / Sign In -->
	  <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt"> <a href="top_gry.php" class="view-all">więcej...</a>
              <h3>Top Gry</h3>
              <div class="cl">&nbsp;</div>
            </div>
          </div>
			<div id="slider">
				<div class="buttons"><span class="prev">prev</span> <span class="next">next</span> </div>
				<div class="holder">
					<div class="content">
                    <ul>
					<?php
						$slider = json_decode(file_get_contents('http://localhost/REST_api.php?action=top_n&number=10'), true);
						if(!empty($slider))
						{
							foreach ($slider as $game)
							{
								echo "<li class='fragment'>
								<div class='image'>
									<a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."'><img src=".$game["link"]." alt=''  height='293' width='226'/></a>
								</div>
								<div class='cnt'>
									<div class='cl'>&nbsp;</div>
									<div class='side-a'>
									<h2><a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."' style='color: #212121'>".$game["nazwa"]."</a></h2>
									<ul class='rating'>";
										if(1 >= $game["srednia"] && $game["srednia"] > 0)
										{
											echo "<li><span class='star full-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li>
											<li><span class='votes'>".$game["oceniajacych"]." votes</span></li>";
										}
										if(2 >= $game["srednia"] && $game["srednia"] > 1)
										{
											echo "<li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li>
											<li><span class='votes'>".$game["oceniajacych"]." votes</span></li>";
										}
										if(3 >= $game["srednia"] && $game["srednia"] > 2)
										{
											echo "<li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li>
											<li><span class='votes'>".$game["oceniajacych"]." votes</span></li>";
										}
										if(4 >= $game["srednia"] && $game["srednia"] > 3)
										{
											echo "<li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star empty-star'>&nbsp;</span></li>
											<li><span class='votes'>".$game["oceniajacych"]." votes</span></li>";
										}
										if(5 >= $game["srednia"] && $game["srednia"] > 4)
										{
											echo "<li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li><li><span class='star full-star'>&nbsp;</span></li>
											<li><span class='votes'>".$game["oceniajacych"]." votes</span></li>";
										}
									echo "</ul>
									</div>
									<div class='cl'>&nbsp;</div>
								</div>
								</li>";
							}
						}
					?>
					</ul>
					</div>
				</div>
			</div>
        </div>
      </div>
	  
      <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt">
              <h3>Ostatnio dodane</h3>
            </div>
          </div>
          <div class="image-articles articles">
            <div class="cl">&nbsp;</div>
			<?php
				$nowe = json_decode(file_get_contents('http://localhost/REST_api.php?action=new_games'), true);
				foreach($nowe as $game)
				{
					echo "<div class='article'>
						<div class='cl'>&nbsp;</div>
						<div class='image'><a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."'><img src=".$game["link"]." alt='' /></a></div>
						<div class='cnt'>
						<h4><a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."'>".$game["nazwa"]."</a></h4>
						<p>Dodano: ".$game["czas"]."</p>
						</div>
						<div class='cl'>&nbsp;</div>
					</div>";
				}
			?>
            <div class="cl">&nbsp;</div>
          </div>
        </div>
      </div>
	  <div class="block">
        <div class="block-bot">
          <div class="head">
            <div class="head-cnt">
              <h3>Najczęściej oceniane</h3>
            </div>
          </div>
          <div class="image-articles articles">
            <div class="cl">&nbsp;</div>
			<?php
				$oceniane = json_decode(file_get_contents('http://localhost/REST_api.php?action=top_rate'), true);
				foreach ($oceniane as $game)
				{
					echo "<div class='article'>
						<div class='cl'>&nbsp;</div>
						<div class='image'><a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."'><img src=".$game["link"]." alt='' /></a></div>
						<div class='cnt'>
						<h4><a href='wyswietl_gre.php?nazwa_gry=".$game["nazwa"]."'>".$game["nazwa"]."</a></h4>
						<p>".$game["gatunek"]."</p>";
						$platformy = file_get_contents('http://localhost/REST_api.php?action=platforms&id_gry='.$game["id"]);
					echo "<p>".$platformy."</p>
						</div>
						<div class='cl'>&nbsp;</div>
					</div>";
				}
			?>
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
			<?php
				$platformy = json_decode(file_get_contents('http://localhost/REST_api.php?action=get_list'), true);
				foreach($platformy as $platforma)
					echo "<li><a href='gry_na_platforme.php?platforma=".$platforma."'>".$platforma."</a></li>";
			?>
          </ul>
          <div class="cl">&nbsp;</div>
        </div>
      </div>
      <p class="copy">&copy; Design by Z.P, Ł.M, M.H, J.P, T.P</p>
    </div>
    <!-- / Footer -->
  </div>
</div>
<!-- / Main -->
</div>
<!-- / Page -->
</body>
</html>