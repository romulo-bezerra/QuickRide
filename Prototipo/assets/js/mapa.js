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

//Cria array global
var waypoints = [];

//Função adiciona waypoints ao array e emite status de inserção
btAddWeypoints.onclick = function (event) {
	event.preventDefault();
	swal({
		title: "Pontos Intermediários!",
		text: "Digite o local onde deseja traçar:",
	  	type: "input",
	  	showCancelButton: true,
	  	closeOnConfirm: false,
	  	animation: "slide-from-top",
	  	inputPlaceholder: "Digite seu ponto aqui"
	},
	function(inputValue){
  		if (inputValue === false) return false;

  		if (inputValue === "") {
    		swal.showInputError("You need to write something!");
    		return false;
  		};
		waypoints.push({location: inputValue});
      	
      	swal("Adicionado!", "Ponto Intermediário adicionado! " , "success");
		return true;
	});
};

//Função que mostra a distância e a duração da rota indicada
btnEnviar.onclick = function(event){
	event.preventDefault();

	var enderecoPartida = $("#txtEnderecoPartida").val();
	var enderecoChegada = $("#txtEnderecoChegada").val();

	var request = {
			origin: enderecoPartida,
			destination: enderecoChegada,
			waypoints: waypoints,
			travelMode: google.maps.DirectionsTravelMode.DRIVING
	};

	directionsService.route(request, function(response, status) {
		 if (status == google.maps.DirectionsStatus.OK) {
			
			var rota = response.routes[0].legs;
			var somaDistancia = 0;
			var somaDuracao = 0;
			
			//Percorre os braços da rota somando as distancias calculadas de ponto a ponto
			for(var i = 0; i < rota.length; i++){
				somaDistancia += rota[i].distance.value;
				somaDuracao += rota[i].duration.value;
			}
			
			document.getElementById('distancia').value = somaDistancia/1000+" KM";

			//Obtêm os inputs
			var horaSaida = document.getElementById('horaSaida').value;
			var dataViajem  = document.getElementById('dataViajem').value;

			//Chama a Função para calcular a hora estimada de chegada
			var horaChegada = calculaHoraChegadaAoDestino(dataViajem, horaSaida, somaDuracao);

			//Seta no campo input
			document.getElementById('duracao').value = horaChegada;

			directionsDisplay.setDirections(response);
		}
	});
};

//Função calcula a hora estimada de chegada ao destino da carona somando-se a
//hora da saída e a duração dada pela API do tráfego da rota
function calculaHoraChegadaAoDestino(dataViajem, horaSaida, duracaoDaViajem){

	//Divide a data da viajem em um array contendo [ano],[mes],[dia]
	var matDataViajem = dataViajem.split("-");

	//Divide a hora de saída da viajem em um array contendo [hora],[minuto]
	var matHoraSaida = horaSaida.split(":");

	//Monta uma data do tipo Date(Ano, Mes, Dia, Hora, Minuto, Segundo, Milissegundo)
	var dataHoraSaida = new Date(matDataViajem[0], matDataViajem[1], matDataViajem[2],
			matHoraSaida[0], matHoraSaida[1], 00, 0);

	//Atribue ao objeto dataHoraSaida a soma do objeto dataHoraSaida com a os minutos da duracao
	dataHoraSaida.setSeconds(dataHoraSaida.getSeconds() + duracaoDaViajem);
	
	//Data e Hora de chegada formatada
	var horaChegada = dataHoraSaida.getHours() + ":" + dataHoraSaida.getMinutes() + " do Dia " + 
			dataHoraSaida.getDate() + "/"+dataHoraSaida.getMonth() + "/" +
			dataHoraSaida.getFullYear();

	return horaChegada;
}
