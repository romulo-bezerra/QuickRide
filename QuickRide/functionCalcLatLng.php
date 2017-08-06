<?php

	//Função calcula coordenadas: latitude e longitude de uma localidade
	//Retorna um tipo String 'lat long'
	function calcLatLong($localidade){
		
		//Retira espaços em branco da localidade
		$localidade = str_replace(" ","",$localidade);
		
		//Geocodifica  a localidade
		$geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='
			       .$localidade.'&key=AIzaSyAgf7lIrFnLz2J67wYUibx-jhl3XlNFbmQ');
		
		//transforma em um json
		$output= json_decode($geocode);
		
		//Obtém a latitude
		$lat = $output->results[0]->geometry->location->lat;
  		
  		//Obtém a longitude
  		$long = $output->results[0]->geometry->location->lng;
		
		//Formata a saida
  		$latLing = $lat .' '. $long;
		
	    return $latLing;
	};

?>