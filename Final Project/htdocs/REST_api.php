<?php
function get_list($con)
{	
	$result = mysqli_query($con, "SELECT * FROM Platforma");
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) {
		$return_arr[] = $row['nazwa'];
	}
	return $return_arr;
}

function add_game($con, $nazwa, $data_swiat, $data_polska, $gatunek, $wydawca, $s_platforma, $opis, $okladka, $screen, $trailer, $gameplay, $dodal, $dodano_czas)
{
	$myfile = fopen("gprjk".$dodal.".txt", "w") or die("Unable to open file!");
	$txt = $nazwa."\r\n".$data_swiat."\r\n".$data_polska."\r\n".$gatunek."\r\n".$wydawca."\r\n".$s_platforma."\r\n".$opis."\r\n".$okladka."\r\n".$screen."\r\n".$trailer."\r\n".$gameplay."\r\n".$dodal."\r\n".$dodano_czas;
	fwrite($myfile, $txt);
	fclose($myfile);
	$output = shell_exec('java Client gprjk'.$dodal.'.txt add');
	unlink("gprjk".$dodal.".txt");
	return $output;
}

function register($con, $nick, $haslo, $email, $imie, $nazwisko)
{
	$checkusername = mysqli_query($con, "SELECT * FROM Uzytkownik WHERE nick = '$nick'");  
	if(mysqli_num_rows($checkusername) == 1)
		return "300";
	else
	{
		$registerquery = mysqli_query($con, "INSERT INTO Uzytkownik (nick, haslo, email, imie, nazwisko) VALUES('$nick', '$haslo', '$email', '$imie', '$nazwisko')");
		if($registerquery)
			return "200";
		else
			return "400";
	}
}

function login($con, $nick, $haslo)
{
	$checklogin = mysqli_query($con, "SELECT * FROM Uzytkownik WHERE nick = '$nick' AND haslo = '$haslo'");
						 
	if(mysqli_num_rows($checklogin) == 1)
	{
		$row = mysqli_fetch_array($checklogin);
		return "200 ".$nick." ".$row['status_admin'];
	}
	else
		return "400";
}

function delete($con, $nick)
{	
	$checkdelete = mysqli_query($con,"DELETE FROM Uzytkownik WHERE nick = '$nick'" );
	if($checkdelete == 1)
		return "200";
	else
		return "400";
}

function change($con, $nick, $haslo)
{	
	$checkchange = mysqli_query($con, "UPDATE Uzytkownik SET haslo = '$haslo' WHERE nick = '$nick'");
	if($checkchange == 1)
		return "200";
	else
		return "400";
}

function info($con, $nick)
{	
	$result = mysqli_query($con, "SELECT * FROM Uzytkownik WHERE nick = '$nick'");
	$return_arr = array();
	while($row = mysqli_fetch_array($result))
	{
		$return_arr[] = $row['nick']." ".$row['email']." ".$row['imie']." ".$row['nazwisko']." ".$row['status_admin'];
	}
	return $return_arr;
}

function platforms($con, $id_gry)
{
	$platformy = "";
	$lista = mysqli_query($con, "SELECT id_platforma FROM Gra_platforma WHERE id_gra = '$id_gry' AND platforma_zatwierdzone = 1");
	$arr = array();
	while($row = mysqli_fetch_array($lista)) {
		$arr[] = $row[0];
	}
	foreach($arr as $id_platforma)
	{
		$wynik = mysqli_query($con, "SELECT nazwa FROM Platforma WHERE id = '$id_platforma'");
		$nazwa = mysqli_fetch_array($wynik);
		$platformy = $nazwa[0].", ".$platformy;
	}
	$platformy = substr($platformy, 0, -2);
	return $platformy;
}

function get_game($con, $nazwa)
{	
	$nazwa = str_replace("_", " ", $nazwa);
	
	$get_id = mysqli_query($con, "SELECT id, nazwa, zatwierdzone FROM Gra");
	$id = "-1";
	$return_arr = array();
	while($row = mysqli_fetch_array($get_id)) {
		if((strcmp($nazwa, $row['nazwa']) == 0) && ($row['zatwierdzone'] == 1))
			$id = $row['id'];
	}
	
	if ($id != -1)
	{
		$result = mysqli_query($con, "SELECT * FROM Gra JOIN Obrazki ON Gra.id = Obrazki.id_gry WHERE Gra.id = '$id' AND Obrazki.typ = 'okladka'");
		//$result = mysqli_query($con, "SELECT Gra.*, ROUND(AVG(IFNULL(Oceny.ocena,0)),2) as 'srednia' FROM Gra JOIN Oceny JOIN Obrazki ON Gra.id = Obrazki.id_gry AND Oceny.id_gry=Gra.id WHERE Gra.id = '$id'  AND Obrazki.typ = 'okladka'");
		
		while($row = mysqli_fetch_array($result)) {
			//$return_arr[] = $row['id']."|".$row['nazwa']."|". $row['rok_wydania_swiat']."|".$row['rok_wydania_polska']."|".$row['gatunek']."|".$row['wydawca']."|".$row['opis']."|".$row['link']."|".$row['srednia'];
			$return_arr[] = $row['id']."|".$row['nazwa']."|". $row['rok_wydania_swiat']."|".$row['rok_wydania_polska']."|".$row['gatunek']."|".$row['wydawca']."|".$row['opis']."|".$row['link'];
		}
	}
    return $return_arr;
}


function get_game_list_adv($con, $nazwa, $gatunek, $wydawca)
{
	$nazwa = str_replace("_", " ", $nazwa);
	$gatunek = str_replace("_", " ", $gatunek);
	$wydawca = str_replace("_", " ", $wydawca);

	$result = mysqli_query($con, "SELECT * FROM Gra WHERE (nazwa LIKE '%$nazwa%')AND(gatunek LIKE '%$gatunek%')AND(wydawca LIKE '%$wydawca%')");
	
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) {
		if($row['zatwierdzone'] == 1)
			$return_arr[] = $row['nazwa'];
	}
	return $return_arr;
}

function get_game_list($con, $nazwa)
{	
	$nazwa = str_replace("_", " ", $nazwa);
	$result = mysqli_query($con, "SELECT * FROM Gra WHERE nazwa LIKE '%$nazwa%'");
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) {
		if($row['zatwierdzone'] == 1)
			$return_arr[] = $row['nazwa'];
	}
	return $return_arr;
}


function top_n($con, $liczba)
{
	$result = mysqli_query($con, "CALL top_n($liczba)") or die("Query fail: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)){
		$game_list[] = array("nazwa" => $row[0], "srednia" => $row[1], "oceniajacych" => $row[2], "link" => $row[3], "gatunek" => $row[4], "id" => $row[5], "opis" => $row[6]); 
	}
  return $game_list;
}

function top_n_platform($con, $liczba, $platforma)
{
	$result = mysqli_query($con, "CALL top_n_platform($liczba,'$platforma')") or die("Query fail: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)){
		$game_list[] = array("nazwa" => $row[0], "srednia" => $row[1],"platforma" =>$row[2], "oceniajacych" => $row[3], "link" => $row[4], "gatunek" => $row[5], "id" => $row[6]); 
	}
  return $game_list;
}

function new_games($con)
{
	$result = mysqli_query($con, "SELECT Gra.nazwa, Gra.dodano_czas, Obrazki.link FROM Gra JOIN Obrazki ON Gra.id = Obrazki.id_gry WHERE Gra.zatwierdzone = 1 AND Obrazki.typ = 'okladka' ORDER BY Gra.dodano_czas DESC LIMIT 3");
	while($row = mysqli_fetch_array($result)) {
		$return_arr[] = array("nazwa" => $row[0], "czas" => $row[1], "link" => $row[2]);
	}
	return $return_arr;
}

function all_games($con)
{
	$result = mysqli_query($con, "SELECT nazwa FROM Gra WHERE zatwierdzone = 1 ORDER BY nazwa");
	while($row = mysqli_fetch_array($result)) {
		$return_arr[] = array("nazwa" => $row[0]);
	}
	return $return_arr;
}

function add_comment($game_title, $user_nickname, $comment)
{
	$myfile = fopen("gprjk".$user_nickname.".txt", "w") or die("Unable to open file!");
	$txt = $game_title."\r\n".$user_nickname."\r\n".$comment;
	fwrite($myfile, $txt);
	fclose($myfile);
	$output = shell_exec('java Client gprjk'.$user_nickname.'.txt koment');
	unlink("gprjk".$user_nickname.".txt");
	return $output;
}

function add_rate($game_title, $user_nickname, $rate)
{
	$myfile = fopen("gprjk".$user_nickname.".txt", "w") or die("Unable to open file!");
	$txt = $game_title."\r\n".$user_nickname."\r\n".$rate;
	fwrite($myfile, $txt);
	fclose($myfile);
	$output = shell_exec('java Client gprjk'.$user_nickname.'.txt ocen');
	unlink("gprjk".$user_nickname.".txt");
	return $output;
}

function findElement($con, $sql, $element) 
{
	$find_game = mysqli_query($con, $sql);
	if($find_game == FALSE) 
	{
		die(mysql_error());
	}
	$gameRow = mysqli_fetch_assoc($find_game);
	$game_name = $gameRow[$element];
	return $game_name;
}

function find_rate($con, $game_title, $user_nickname)
{
	$users_rate_from_db ="";
	$game_title = str_replace('_', ' ', $game_title);

	if(!($user_nickname=="") && !($game_title==""))
	{
		$name = $user_nickname;
		$sql = "SELECT * FROM Uzytkownik WHERE nick='$name'";
		$user_id = findElement($con, $sql, 'id');
		
		$sql = "SELECT * FROM Gra WHERE nazwa='$game_title'";
		$game_id = findElement($con, $sql, 'id');
		
		$sql = "SELECT * FROM Oceny WHERE id_uzytkownika='$user_id' AND id_gry='$game_id'";
		$users_rate_from_db = findElement($con, $sql, 'ocena');
	}
	return $users_rate_from_db;
}

function show_comments($con, $game_title)
{
	$users_rate_from_db ="";
	$game_title = str_replace('_', ' ', $game_title);
	$comment_array="";

	if(!($game_title==""))
	{
		$sql = "SELECT * FROM Gra WHERE nazwa='$game_title'";
		$game_id = findElement($con, $sql, 'id');
		
		$sql = "SELECT * FROM Komentarze";
		$find_comments = mysqli_query($con, $sql);
		if($find_comments == FALSE) 
		{
			die(mysql_error());
		}
		while($row = mysqli_fetch_assoc($find_comments))
		{
			$comment_gameID = $row['id_gry'];
			$comment_userID = $row['id_uzytkownika'];
			$comment = $row['komentarz'];

			$element = 'nazwa';
			$sql = "SELECT * FROM Gra WHERE id='$comment_gameID'";
			$game_name = findElement($con, $sql, $element);
			

			$sql = "SELECT * FROM Oceny WHERE id_uzytkownika='$comment_userID' AND id_gry='$game_id'"; //ocena uzytkownika
			$users_rate_from_db = findElement($con, $sql, 'ocena');


			$element = 'nick';
			$sql = "SELECT * FROM Uzytkownik WHERE id='$comment_userID'";
			$user_name = findElement($con, $sql, $element);

			if($game_name == $game_title && !($comment == ""))
			{
				$comment_array[] = $user_name."|".$users_rate_from_db."|".$comment;
			}
		}
	}
	return $comment_array;
}

function premiere($con, $liczba)
{
	$result = mysqli_query($con, "SELECT Gra.nazwa, Gra.rok_wydania_swiat, Gra.opis, Obrazki.link FROM Gra JOIN Obrazki ON Gra.id = Obrazki.id_gry WHERE Gra.zatwierdzone = 1 AND Obrazki.typ = 'okladka' ORDER BY Gra.rok_wydania_swiat DESC LIMIT ".$liczba);
	while($row = mysqli_fetch_array($result)) {
		$return_arr[] = array("nazwa" => $row[0], "czas" => $row[1], "opis" => $row[2], "link" => $row[3]);
	}
	return $return_arr;
}

function top_rate($con)
{
	$result = mysqli_query($con, "CALL top_rate()") or die("Query fail: " . mysqli_error());
	while ($row = mysqli_fetch_array($result)){
		$game_list[] = array("id" => $row[0], "nazwa" => $row[1], "gatunek" => $row[3], "link" => $row[4]); 
	}
  return $game_list;
}

function games_on_platform($con, $platforma)
{
	$platforma = str_replace('_', ' ', $platforma);
	$id_platforma = mysqli_query($con, "SELECT id FROM Platforma WHERE nazwa = '$platforma'");
	while ($row = mysqli_fetch_array($id_platforma)){
		$id_p = $row[0]; 
	}
	$id_gier = mysqli_query($con, "SELECT id_gra FROM Gra_platforma WHERE id_platforma = '$id_p' AND platforma_zatwierdzone = 1");
	while ($row2 = mysqli_fetch_array($id_gier)){
		$id_g[] = $row2[0]; 
	}
	$return_arr = array();
	foreach($id_g as $id)
	{
		$result = mysqli_query($con, "SELECT nazwa FROM Gra WHERE id = '$id' AND zatwierdzone = 1");
		while ($row3 = mysqli_fetch_array($result)){
			$return_arr[] = $row3[0]; 
		}
	}
	return $return_arr;
}

function act($con)
{
	$result = mysqli_query($con, "CALL dtemp()") or die("Query fail: " . mysqli_error());
	$result = mysqli_query($con, "CALL dgra_p()") or die("Query fail: " . mysqli_error());
	$result = mysqli_query($con, "CALL temp()") or die("Query fail: " . mysqli_error());
	$result = mysqli_query($con, "CALL gra_p()") or die("Query fail: " . mysqli_error());
}

function get_movie($con, $nazwa)
{
	$nazwa = str_replace("_", " ", $nazwa);
	$result = mysqli_query($con, "SELECT * FROM Filmiki WHERE id_gry = (SELECT id FROM Gra WHERE nazwa = '$nazwa')");
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) 
	{
		if($row['filmiki_zatwierdzone'] == 1)
			$return_arr[] = $row['link_f'];
	}
	return $return_arr;
}

function get_pictures($con, $nazwa)
{
	$nazwa = str_replace("_", " ", $nazwa);
	$result = mysqli_query($con, "SELECT * FROM Obrazki WHERE id_gry = (SELECT id FROM Gra WHERE nazwa = '$nazwa')");
	$return_arr = array();
	while($row = mysqli_fetch_array($result)) 
	{
		if($row['obrazki_zatwierdzone'] == 1)
			$return_arr[] = $row['link'];
	}
	return $return_arr;
}

function find_average($con, $game_title)
{
	$game_average ="";
	$game_title = str_replace('_', ' ', $game_title);

	if(!($game_title==""))
	{
		$sql = "SELECT * FROM Gra WHERE nazwa='$game_title'";
		$game_id = findElement($con, $sql, 'id');
		
		$sql = "SELECT ROUND(AVG(IFNULL(o.ocena,0)),2) 'srednia' FROM Oceny o WHERE o.id_gry ='$game_id'";
		$game_average = findElement($con, $sql, 'srednia');
	}
	return $game_average;
}



//BAZA DANYCH
$dbhost = "db4free.net";
$dbname = "rtgbase"; 
$dbuser = "adminrtg";
$dbpass = "ratethegame"; 
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

switch ($_GET['action'])
{
	case "get_list":
		$value = get_list($con);
		exit(json_encode($value));
	break;
	case "add_game":
		$value = add_game($con, $_GET['nazwa'], $_GET['data_swiat'], $_GET['data_polska'], $_GET['gatunek'], $_GET['wydawca'], $_GET['s_platforma'], $_GET['opis'], $_GET['okladka'], $_GET['screen'], $_GET['trailer'], $_GET['gameplay'], $_GET['dodal'], $_GET['dodano_czas']);
		exit($value);
	break;
	case "register":
		$value = register($con, $_GET['nick'], $_GET['haslo'], $_GET['email'], $_GET['imie'], $_GET['nazwisko']);
		exit($value);
	break;
	case "login":
		$value = login($con, $_GET['nick'], $_GET['haslo']);
		exit($value);
	case "delete":
		$value = delete($con, $_GET['nick']);
		exit($value);
	case "change":
		$value = change($con, $_GET['nick'], $_GET['haslo']);
		exit($value);
	case "info":
		$value = info($con, $_GET['nick']);
		exit(json_encode($value));
	case "platforms":
		$value = platforms($con, $_GET['id_gry']);
		exit($value);
	case "get_game":
		$value = get_game($con, $_GET['nazwa']);
		exit(json_encode($value));
	case "get_game_list":
		$value = get_game_list($con, $_GET['nazwa']);
		exit(json_encode($value));
	case "get_game_list_adv":
		$value = get_game_list_adv($con, $_GET['nazwa'], $_GET['gatunek'], $_GET['wydawca']);
		exit(json_encode($value));
	case "top_n":
		$value = top_n($con, $_GET["number"]);
		exit(json_encode($value));
	case "top_n_platform":
		$value = top_n_platform($con, $_GET["number"], $_GET["platform"]);
		exit(json_encode($value));
	case "new_games":
		$value = new_games($con);
		exit(json_encode($value));
	case "all_games":
		$value = all_games($con);
		exit(json_encode($value));
	case "add_comment":
		$value = add_comment($_GET['game_title'], $_GET['user_nickname'], $_GET['comment']);
		exit($value);
	case "add_rate":
		$value = add_rate($_GET['game_title'], $_GET['user_nickname'], $_GET['rate']);
		exit($value);
	case "find_rate":
		$value = find_rate($con, $_GET['game_title'], $_GET['user_nickname']);
		exit($value);
	case "show_comments":
		$value = show_comments($con, $_GET['game_title']);
		exit(json_encode($value));
	case "premiere":
		$value = premiere($con, $_GET['liczba']);
		exit(json_encode($value));
	case "top_rate":
		$value = top_rate($con);
		exit(json_encode($value));
	case "games_on_platform":
		$value = games_on_platform($con, $_GET['platforma']);
		exit(json_encode($value));
	case "act":
		act($con);
		break;
	case "get_pictures":
		$value = get_pictures($con, $_GET['nazwa']);
		exit(json_encode($value));
	case "get_movie":
		$value = get_movie($con, $_GET['nazwa']);
		exit(json_encode($value));
	case "find_average":
		$value = find_average($con, $_GET['nazwa']);
		exit($value);
	default:
		$value = "400";
		exit($value);
	break;
}
?>