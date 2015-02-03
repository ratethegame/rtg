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
				$wszystkie = file_get_contents('http://localhost/REST_api.php?action=all_games');
				$wszystkie = json_decode($wszystkie, true);
				if(!empty($wszystkie))
				{
					echo "<h1><center>LISTA GIER W NASZYM SERWISIE:</center></h1><br/>";
					foreach ($wszystkie as $gra)
						echo "<a href='wyswietl_gre.php?nazwa_gry=".$gra["nazwa"]."'>".$gra["nazwa"]."</a><br/><br/>";
					}
				else
					echo "Wystąpił nieoczekiwany błąd. Spróbuj ponownie poźniej.";
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