<?php

require 'Slim/Slim.php';

$app = new Slim();

//routes resource URIs to callback functions


$app->contentType('application/json;charset=utf-8');


$app->get('/games', 'getGames');
$app->get('/games/:id',	'getGame');
$app->get('/games/search/:query', 'findByName');

$app->put('/games/:id', 'updateGame');
$app->delete('/games/:id',	'deleteGame');

$app->get('/users', 'getUsers');
$app->post('/users', 'addUser');

$app->run();



function getUsers() {
	
	$sql = "select * from Uzytkownik ORDER BY nick";
	try{
		$db = getConnection();
		$stmt = $db->query($sql);  
		$games = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"user": ' . (json_encode($games)) . '}';


	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getGames() {
	
	$sql = "select Gra.*, Obrazki.link as 'okladka', Filmiki.link_f as 'trailer', gra_p.platformy as 'platformy' FROM Gra inner join Obrazki on Gra.id=Obrazki.id_gry left join Filmiki on Gra.id=Filmiki.id_gry left join gra_p on Gra.id=gra_p.id_gry ORDER BY Gra.nazwa";
	try {
		$db = getConnection();
		$stmt = $db->query($sql);  
		$games = $stmt->fetchAll(PDO::FETCH_OBJ);

		$db = null;
		echo '{"game": ' . (json_encode($games)) . '}';


	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getGame($id) {
	$sql = "select Gra.*, Obrazki.link as 'okladka', Filmiki.link_f as 'trailer', gra_p.platformy as 'platformy' FROM Gra inner join Obrazki on Gra.id=Obrazki.id_gry left join Filmiki on Gra.id=Filmiki.id_gry left join gra_p on Gra.id=gra_p.id_gry WHERE Gra.id=:id";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$game = $stmt->fetchObject();  
		$db = null;
		echo json_encode($game); 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}


function addUser() {
//	error_log('addUser\n', 3, '/var/tmp/php.log');
	$request = Slim::getInstance()->request();
	$game = json_decode($request->getBody());
	$sql = "INSERT INTO Uzytkownik (nick, haslo, email, imie, nazwisko) VALUES (:nick, :haslo, :email, :imie, :nazwisko)";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("nick", $game->nick);
		$stmt->bindParam("haslo", $game->haslo);
		$stmt->bindParam("email", $game->email);
		$stmt->bindParam("imie", $game->imie);
		$stmt->bindParam("nazwisko", $game->nazwisko);
		$stmt->execute();
		$game->id = $db->lastInsertId();
		$db = null;
		echo json_encode($game); 
	} catch(PDOException $e) {
		//error_log($e->getMessage(), 3, '/var/tmp/php.log');
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function updateGame($id) {
	$request = Slim::getInstance()->request();
	$body = $request->getBody();
	$game = json_decode($body);
	$sql = "UPDATE Gra, Obrazki  SET Gra.nazwa=:nazwa, Gra.gatunek=:gatunek, Gra.wydawca=:wydawca, Gra.rok_wydania_swiat=:rok_wydania_swiat, Gra.rok_wydania_polska=:rok_wydania_polska, Gra.dodal=:dodal, Gra.zatwierdzone=:zatwierdzone, Gra.opis=:opis, Gra.dodano_czas=:dodano_czas, Obrazki.link=:okladka WHERE Gra.id=:id and Gra.id=Obrazki.id_gry";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);  
		$stmt->bindParam("nazwa", $game->nazwa);
		$stmt->bindParam("gatunek", $game->gatunek);
		$stmt->bindParam("wydawca", $game->wydawca);
		$stmt->bindParam("rok_wydania_swiat", $game->rok_wydania_swiat);
		$stmt->bindParam("rok_wydania_polska", $game->rok_wydania_polska);
		$stmt->bindParam("dodal", $game->dodal);
		$stmt->bindParam("zatwierdzone", $game->zatwierdzone);
		$stmt->bindParam("opis", $game->opis);	
		$stmt->bindParam("dodano_czas", $game->dodano_czas);
		$stmt->bindParam("okladka", $game->okladka);
		$stmt->bindParam("id", $id);
		$stmt->execute();
		$db = null;
		echo json_encode($game); 
	} catch(PDOException $e) {
		echo 'Taki użytkownik już istnieje'; 
	}
}


function deleteGame($id) {
	$sql0 = "SET foreign_key_checks = 0";
	$sql1 = "DELETE FROM Obrazki where id_gry=:id" ;
	$sql2 = "DELETE FROM Gra WHERE id=:id";
	$sql3 = "DELETE FROM Gra_platforma WHERE id_gra=:id";
	$sql4 = "SET foreign_key_checks = 1";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql0);  
		$stmt1 = $db->prepare($sql1);  
		$stmt2 = $db->prepare($sql2);
		$stmt3 = $db->prepare($sql3);
		$stmt4 = $db->prepare($sql4);  
		$stmt->bindParam("id", $id);
		$stmt1->bindParam("id", $id);
		$stmt2->bindParam("id", $id);
		$stmt3->bindParam("id", $id);
		$stmt4->bindParam("id", $id);
		$stmt->execute();
		$stmt1->execute();
		$stmt2->execute();
		$stmt3->execute();
		$stmt4->execute();
		$db = null;
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function findByName($query) {
	$sql = "SELECT * FROM Gra WHERE UPPER(nazwa) LIKE :query ORDER BY nazwa";
	try {
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$query = "%".$query."%";  
		$stmt->bindParam("query", $query);
		$stmt->execute();
		$games = $stmt->fetchAll(PDO::FETCH_OBJ);
		$db = null;
		echo '{"game": ' . json_encode($games) . '}';
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
}

function getConnection() {

	/*$dbhost="127.0.0.1";
	$dbuser="root";
	$dbpass="";
	$dbname="cellar";*/
	$dbhost = "db4free.net";
	$dbname = "rtgbase"; 
	$dbuser = "adminrtg";
	$dbpass = "ratethegame";
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
	$dbh -> exec("set names utf8");
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $dbh;
}

?>