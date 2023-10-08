<?php 
    defined('BASEPATH') OR exit('No direct script access allowed');

    //--------------------------------------------------------------------------------------------------------------------------------------------------------------
    class Utilitarios
    {
        
        function mes($idmes){
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  
            return $meses[$idmes];
        } 
        
        
        function generar_clave($numerodeletras=20){
          $caracteres = "abcdefghijklmnopqrstuvwxyz1234567890"; //posibles caracteres a usar
          $cadena = ""; //variable para almacenar la cadena generada
          for($i=0;$i<$numerodeletras;$i++)
          {
              $cadena .= substr($caracteres,rand(0,strlen($caracteres)),1); /*Extraemos 1 caracter de los caracteres
          entre el rango 0 a Numero de letras que tiene la cadena */
          }
          return $cadena; 
        }
        
        function fecha_letras($fecha, $flag_dia=false){
            $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");  
            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Setiembre","Octubre","Noviembre","Diciembre");  
        
            $ahora = strtotime($fecha);  
        
            return ($flag_dia?$dias[date("w", $ahora)]." ":" ") . date("j", $ahora) . " de " . $meses[date("n", $ahora)-1] . " de " . date("Y", $ahora);
        } 
    }
?>


