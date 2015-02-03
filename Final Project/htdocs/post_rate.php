<?php session_start();
	$user_nickname = $_SESSION['Username'];
	$rate = $_POST['rating'];
	$game_title = $_SESSION['gameName'];
	echo "asdbadfasdf";
	if(!($rate == ""))
	{
		echo "asdbadfasdf";
		$game_title = str_replace(' ', '_', $game_title);

		$output = file_get_contents('http://localhost/REST_api.php?action=add_rate&game_title='.$game_title.'&user_nickname='.$user_nickname.'&rate='.$rate);
		$checker = substr($output, 0, -1);
		$checker = substr($checker, -3);

		if($checker == "200")
		{
			header("location: wyswietl_gre.php?nazwa_gry=".$game_title);
			echo "<br><center>Dziękujemy za dodanie oceny.</center>";
		}
		else
		{
			echo "<center>Błąd2!</center><br>";
			echo "<center>Przepraszamy, dodanie oceny nie powiodło się.</center>";
		}
	}
	else
	{
		//header("location: wyswietl_gre?error=1");
		echo "<center>Błąd1!</center><br>";
		echo "<center>Przepraszamy, dodanie oceny nie powiodło się.</center>";
	}
?>