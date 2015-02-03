// The root URL for the RESTful services
var rootURL = "http://localhost/api/games";

var currentGame;

// Retrieve game list when application starts 
findAll();

// Nothing to delete in initial application state
$('#btnDelete').hide();

// Register listeners
$('#btnSearch').click(function() {
	search($('#searchKey').val());
	return false;
});

// Trigger search when pressing 'Return' on search key input field
$('#searchKey').keypress(function(e){
	if(e.which == 13) {
		search($('#searchKey').val());
		e.preventDefault();
		return false;
    }
});

$('#btnAdd').click(function() {
	newGame();
	return false;
});

$('#btnSave').click(function() {
	/*if ($('#gameId').val() == '')
		addGame();
	else*/
		updateGame();
	return false;
});


$('#btnDelete').click(function() {
	deleteGame();
	return false;
});

$('#gameList a').live('click', function() {
	findById($(this).data('identity'));
});

// Replace broken images with generic game bottle/
/*$("img").error(function(){
  $(this).attr("src", "pics/icon_game.png");

});*/

function search(searchKey) {
	if (searchKey == '') 
		findAll();
	else
		findByName(searchKey);
}

function newGame() {
	$('#btnDelete').hide();
	currentGame = {};
	renderDetails(currentGame); // Display empty form
}

function findAll() {
	console.log('findAll');
	$.ajax({
		type: 'GET',
		url: rootURL,
		dataType: "json", // data type of response
		success: renderList
	});
}

function findByName(searchKey) {
	console.log('findByName: ' + searchKey);
	$.ajax({
		type: 'GET',
		url: rootURL + '/search/' + searchKey,
		dataType: "json",
		success: renderList 
	});
}

function findById(id) {
	console.log('findById: ' + id);
	$.ajax({
		type: 'GET',
		url: rootURL + '/' + id,
		dataType: "json",
		success: function(data){
			$('#btnDelete').show();
			console.log('findById success: ' + data.nazwa);
			currentGame = data;
			renderDetails(currentGame);
		}
	});
}

function updateGame() {
	console.log('updateGame');
	$.ajax({
		type: 'PUT',
		contentType: 'application/json',
		url: rootURL + '/' + $('#gameId').val(),
		dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('Game updated successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('updateGame error: ' + textStatus);
		}
	});
}



function deleteGame() {
	console.log('deleteGame');
	$.ajax({
		type: 'DELETE',
		url: rootURL + '/' + $('#gameId').val(),
		success: function(data, textStatus, jqXHR){
			alert('Game deleted successfully');
		},
		error: function(jqXHR, textStatus, errorThrown){
			
			alert('deleteGame error'+textStatus);
		}
	});
}

function renderList(data) {
	// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
	var list = data == null ? [] : (data.game instanceof Array ? data.game : [data.game]);

	$('#gameList li').remove();
	$.each(list, function(index, game) {
		$('#gameList').append('<li><a href="#" data-identity="' + game.id + '">'+game.nazwa+'</a></li>');
	});
}

function renderDetails(game) {
	$('#gameId').val(game.id);
	$('#nazwa').val(game.nazwa);
	$('#gatunek').val(game.gatunek);
	$('#wydawca').val(game.wydawca);
	$('#okladka').val(game.okladka);
	$('#trailer').val(game.trailer);
	$('#platformy').val(game.platformy);
	$('#rok_wydania_swiat').val(game.rok_wydania_swiat);
	$('#rok_wydania_polska').val(game.rok_wydania_polska);
	$('#dodal').val(game.dodal);
	$('#zatwierdzone').val(game.zatwierdzone);
	$('#dodano_czas').val(game.dodano_czas);
	$('#opis').val(game.opis);

	
}

// Helper function to serialize all the form fields into a JSON string


function formToJSON() {
	return JSON.stringify({
		"id": $('#gameId').val(), 
		"nazwa": $('#nazwa').val(), 
		"gatunek": $('#gatunek').val(),
		"wydawca": $('#wydawca').val(),
		"okladka": $('#okladka').val(),
		"trailer": $('#trailer').val(),
		"platformy": $('#platformy').val(),
		"rok_wydania_swiat": $('#rok_wydania_swiat').val(),
		"rok_wydania_polska": $('#rok_wydania_polska').val(),
		"dodal": $('#dodal').val(),
		"zatwierdzone": $('#zatwierdzone').val(),
		"dodano_czas": $('#dodano_czas').val(),
		"opis": $('#opis').val()
		});
}
