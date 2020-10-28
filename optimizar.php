<?php
if($_REQUEST){    
    
    $modulo = isset($_REQUEST['modulo'])?$_REQUEST['modulo']:'';

    if($modulo == 'Optimizar'){

		$objOptimizar = new Optimizar();
		$objOptimizar->crearArchivoDzn($_REQUEST);
	}
}

class Optimizar{

    function crearArchivoDzn($parametros){       

        try {

            $mensaje = "";
            $response = array();

            //Array Plantas
            $plantas = $parametros['plantas'];
            $string_plantas = "plantas = {";
            $string_plantas .= implode(",", $plantas) ."};";

            //Array produciones diarias
            $produccionesDiarias = $parametros['producciones'];
            $string_producciones = "produccionesDiarias = [";
            $string_producciones .= implode(",", $produccionesDiarias) ."];";

            //Array de costos x 1 mw en cada planta
            $costos_array = $parametros['costos'];
            $costos = array();
            $string_costos = "costos = [";
            foreach($plantas as $planta){
                $costos[]=$costos_array[$planta];
            }
            $string_costos .= implode(",", $costos) ."];";

            //Array de clientes
            $clientes = array_keys ($parametros["demanda"]);
            $string_clientes = "clientes = {";
            $string_clientes .= implode(",", $clientes) ."};";

            //Array dias 
            foreach($parametros["demanda"] as $demanda){
                $dias = array_keys ($demanda);
            }
            $string_dias = "dias = {";
            $string_dias .= implode(",", $dias) ."};";

            //Array de demanda
            $string_demanda = "demanda = [";
            foreach($parametros["demanda"] as $demanda){
                $string_demanda .= "|".implode(",", $demanda);
            }
            $string_demanda .= "|];";
            

            if (file_exists("prueba.dzn")){
                unlink('prueba.dzn');
            }

        

            //Se crea el archivo
            $fh = fopen("prueba.dzn", 'w') or  $mensaje .= "Se produjo un error al crear el archivo";
            
            //Escribir Array Plantas
            fwrite($fh, $string_plantas.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de plantas en el archivo\n";
            //Escribir produciones diarias
            fwrite($fh, $string_producciones.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de producciones diarias en el archivo\n";
            //Escribir Array de costos x 1 mw en cada planta
            fwrite($fh, $string_costos.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de costo x 1 mw en el archivo\n";
            //Escribir Array de clientes
            fwrite($fh, $string_clientes.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de clientes en el archivo\n";
            //Escribir Array dias 
            fwrite($fh, $string_dias.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de dias en el archivo\n";
            //Escribir Array de demanda
            fwrite($fh, $string_demanda.PHP_EOL) or  $mensaje .= "No se pudo escribir el array de demandas en el archivo\n";
            
            fclose($fh);
            
            $mensaje .=  "Se ha escrito sin problemas\n"; 

        } catch (Exception $e) {
            $mensaje.= 'Excepción capturada: '.$e->getMessage()."\n";
        }

        $response = array(
            'tipo' => 'info',
            'mensaje'=> $mensaje,
            'result'=> ''
        );

        header('Access-Control-Allow-Origin: *');
        header('Content-type: application/json');
        
        echo json_encode($response); 
    }
}

?>