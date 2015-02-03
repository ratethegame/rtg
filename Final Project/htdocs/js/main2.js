// The root URL for the RESTful services
var rootURL = "http://localhost/api/users";

var currentGame;

// Retrieve user list when application starts 


// Nothing to delete in initial application state

// Register listeners


// Trigger search when pressing 'Return' on search key input field

findAll();


$('#btnSave').click(function() {
	
		addUser();


	return false;
});

function findAll() {
	console.log('findAll');
	$.ajax({
		type: 'GET',
		url: rootURL,
		dataType: "json", // data type of response
		success: renderList
	});
}

// Replace broken images with generic user bottle/
/*$("img").error(function(){
  $(this).attr("src", "pics/icon_user.png");

});*/



function addUser() {
	console.log('addUser');
	$.ajax({
		type: 'POST',
		contentType: 'application/json',
		url: rootURL,
	//	dataType: "json",
		data: formToJSON(),
		success: function(data, textStatus, jqXHR){
			alert('Zarejestrowano użytkownika w bazie');
			$('#userId').val(data.id);
		},
		error: function(jqXHR, textStatus, errorThrown){
			alert('adduser error: ' + textStatus);
		}
	});
}






function renderList(data) {
	// JAX-RS serializes an empty list as null, and a 'collection of one' as an object (not an 'array of one')
	var list = data == null ? [] : (data.user instanceof Array ? data.user : [data.user]);

	$('#userList li').remove();
	$.each(list, function(index, user) {
		$('#userList').append('<li><a href="#" data-identity="' + user.id + '">'+user.nick+'</a></li>');
	});
}

function renderDetails(user) {
	$('#userId').val(user.id);
	$('#nick').val(user.nick);
	$('#haslo').val(user.haslo);
	$('#email').val(user.email);
	$('#imie').val(user.imie);
	$('#nazwisko').val(user.nazwisko);
	$('#status_admin').val(user.status_admin);	
}

// Helper function to serialize all the form fields into a JSON string


function formToJSON() {
	return JSON.stringify({
		"id": $('#userId').val(), 
		"nick": $('#nick').val(), 
		"haslo": $('#haslo').val(),
		"email": $('#email').val(),
		"imie": $('#imie').val(),
		"nazwisko": $('#nazwisko').val(),
		"status_admin": $('#status_admin').val()
		});
}
