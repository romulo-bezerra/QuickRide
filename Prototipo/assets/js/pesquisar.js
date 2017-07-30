
calculaQuilometragem("patos pb", "sousa pb");		

//Função calcula distância em quilômetros de dois pontos dados
function calculaQuilometragem(enderecoPartida, enderecoChegada){
	var directionsService = new google.maps.DirectionsService();
	var request = {
    	origin: enderecoPartida,
    	destination: enderecoChegada,
    	travelMode: google.maps.DirectionsTravelMode.DRIVING
    };
 
	directionsService.route(request, function(response, status) {
    	distancia.value = response.routes[0].legs[0].distance.value/1000;
    	
    });
}
