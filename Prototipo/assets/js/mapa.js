var map;
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();

// Função de inicialização

function initialize() {
	directionsDisplay = new google.maps.DirectionsRenderer();
	var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);

    var options = {
        zoom: 10,
		center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById("trajeto-texto"));

	// Geolocalização
	
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function (position) {

			pontoPadrao = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
			var marker = new google.maps.Marker({
                    position: pontoPadrao,
                    map: map,
                    title: 'Esta é sua localização atual!'
                    });
			map.setCenter(pontoPadrao);

			var geocoder = new google.maps.Geocoder();

			geocoder.geocode({
				"location": new google.maps.LatLng(position.coords.latitude, position.coords.longitude)
            },
            function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					$("#txtEnderecoPartida").val(results[0].formatted_address);
				}
            });
		});
	}	
}

initialize();

// Função que mostra todo o percurso da rota indicada

/*$("form").submit(function(event) {
	event.preventDefault();

	var enderecoPartida = $("#txtEnderecoPartida").val();
	var enderecoChegada = $("#txtEnderecoChegada").val();

	var request = {
		origin: enderecoPartida,
		destination: enderecoChegada,
		travelMode: google.maps.TravelMode.DRIVING
	};

	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
});*/

// Função que mostra a distância e a duração da rota indicada
btnEnviar.onclick = function(event){
//$("form").submit(function(event) {
	event.preventDefault();

	var enderecoPartida = $("#txtEnderecoPartida").val();
	var enderecoChegada = $("#txtEnderecoChegada").val();

	var request = {
			origin: enderecoPartida,
			destination: enderecoChegada,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
	};

	directionsService.route(request, function(response, status) {
		 if (status == google.maps.DirectionsStatus.OK) {

						document.getElementById('distancia').value =
							 response.routes[0].legs[0].distance.text;
						
						//Duração em formato HORA horas MINUTO minutos
						var dur = response.routes[0].legs[0].duration.text;
						
						//Formatando duração - retirando "minutos"
						var noMinutes = dur.replace(" minutos", "");
						
						//Duração no formato hora:minuto
						var duracao = noMinutes.replace(" horas ", ":");
						
						document.getElementById('duracao').value = duracao;
						
						directionsDisplay.setDirections(response);
				 }
			});

};
