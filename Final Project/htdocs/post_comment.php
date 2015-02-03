<?php
$user_nickname = $_POST['nickname'];
$comment = $_POST['comment'];
$game_title = $_POST['game_title'];

$comment_length = strlen($comment); 
if($comment_length < 250 && !($game_title == "") && !($comment == ""))
{
	$comment = str_replace(' ', '_', $comment);
	$game_title = str_replace(' ', '_', $game_title);

	$output = file_get_contents('http://localhost/REST_api.php?action=add_comment&game_title='.$game_title.'&user_nickname='.$user_nickname.'&comment='.$comment);
	$checker = substr($output, 0, -1);
	$checker = substr($checker, -3);
						
	if($checker == "200")
	{
		echo "Dziękujemy za dodanie komentarza.";
		header("location: wyswietl_gre.php?nazwa_gry=".$game_title);
	}
	else
	{
		echo 'http://localhost/REST_api.php?action=add_comment&game_title='.$game_title.'&user_nickname='.$user_nickname.'&comment='.$comment;
		echo "<br>CHECKER : ".$checker;
		echo "<br>output : ".$output;
		echo "<center>Błąd!</center><br>";
		echo "<center>Przepraszamy, dodanie komentarza nie powiodło się.{2}</center>";
	}
}
else
{
	//header("location: wyswietl_gre?error=1");
	echo "<center>Błąd!</center><br>";
	echo "<center>Przepraszamy, dodanie komentarza nie powiodło się.{1}</center>";
}
?>