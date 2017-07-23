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

//Cria array global
var waypoints = [];

//Função adiciona waypoints ao array e emite status de inserção
btAddWeypoints.onclick = function(event){
	event.preventDefault();
	var ponto = document.getElementById('pontoIntermediario').value;
	if (ponto != '') {
    	if(waypoints.push({
    		location: ponto, 
    		stopover: false})
    	) alert("ADICIONADO");
    	else alert("NÃO ADICIONADO");	
	}
	document.getElementById('pontoIntermediario').value = "";
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

			document.getElementById('distancia').value = response.routes[0].legs[0].distance.text;
			
			//Duração em formato 'X horas Y minutos'
			var dur = response.routes[0].legs[0].duration.text;
			
			//Obtêm os inputs
			var horaSaida = document.getElementById('horaSaida').value;
			var dataViajem  = document.getElementById('dataViajem').value;
			
			//Chama a Função para calcular a hora estimada de chegada
			var horaChegada = calculaHoraChegadaAoDestino(dataViajem, horaSaida, dur);
			
			//Seta no campo input
			document.getElementById('duracao').value = horaChegada;
			
			directionsDisplay.setDirections(response);
		}
	});
};	

//Função calcula a hora estimada de chegada ao destino da carona somando-se a 
//hora da saída e a duração dada pela API do tráfego da rota
function calculaHoraChegadaAoDestino(dataViajem, horaSaida, duracaoDaViajem){
	
	var minuto = 0;
	
	//Analisa se a duração é dada em 'X minutos' e Transforma em somente Números		
	if(duracaoDaViajem.match(/minuto/) && !duracaoDaViajem.match(/hora/) ){ 
		var horaFormatada = duracaoDaViajem.replace(/[^\d]+/g,':'); 
		var arrayHoraFormatada = horaFormatada.split(":"); 
		minuto = Number(arrayHoraFormatada[0]);
	
	//Analisa se a duração é dada em Dias:Horas e Transforma em somente Números
	}else if(duracaoDaViajem.match(/dia/)){ 
		//Retira tudo o q não for número
		var diaFormatado = duracaoDaViajem.replace(/[^\d]+/g,','); 
		var arrayDiaFormatado = diaFormatado.split(","); 
		var diaEmHora = arrayDiaFormatado[0] * 24;
		var hora = arrayDiaFormatado[1];
		minuto = (Number(diaEmHora) + Number(hora))*60;
	
	//Analisa se a duração é dada em Horas:Minutos e Transforma em somente Números	
	}else{ 
		//Retira tudo o q não for núrmero
		var horaFormatada = duracaoDaViajem.replace(/[^\d]+/g,':'); 
		var arrayHoraFormatada = horaFormatada.split(":"); 
		var hora = arrayHoraFormatada[0];
		minuto = Number(arrayHoraFormatada[1]) + Number(hora)*60;
	
	}
	
	//Divide a data da viajem em um array contendo [ano],[mes],[dia]
	var matDataViajem = dataViajem.split("-");
		
	//Divide a hora de saída da viajem em um array contendo [hora],[minuto]
	var matHoraSaida = horaSaida.split(":");
	
	//Monta uma data do tipo Date(Ano, Mes, Dia, Hora, Minuto, Segundo, Milissegundo)
	var dataHoraSaida = new Date(matDataViajem[0], matDataViajem[1], matDataViajem[2], 
			matHoraSaida[0], matHoraSaida[1], 00, 0);
	
	//Atribue ao objeto dataHoraSaida a soma do objeto dataHoraSaida com a os minutos da duracao
	dataHoraSaida.setMinutes(dataHoraSaida.getMinutes() + minuto); 
	
	//Data e Hora de chegada formatada
	var horaChegada = dataHoraSaida.getDate() + "/"+dataHoraSaida.getMonth() + "/" + 
			dataHoraSaida.getFullYear() + " às ≅ "+ dataHoraSaida.getHours() + ":" + 
			dataHoraSaida.getMinutes();
	
	return horaChegada;
}
