<?php

    /*
    $caso = nombre de campo a procesar 
    $valor = valor del campo a procesar
    Lo que esta funcion pretende es permitir establecer formateos o directivas 
    especificas para campos especificos. Esta funcion es llamada por cada campo que se 
    inserta en la base de datos
    */
    function evaluarCaso($caso,$valor,$property){
        switch($caso){
            case "fecha_alta":
                if(!empty($valor)){
                    $time = strtotime($valor);
                    $valor = date('Y-m-d', $time);
                }
                return $valor;
            case "fecha_vto":
                if (!empty($valor)) {
                    $time = strtotime($valor);
                    $valor = date('Y-m-d', $time);
                }
                return $valor;
            case "cate_propiedad":
                if ($valor == 1) {
                    $valor = "RESIDENCIAL";
                } else if ($valor == 2) {
                    $valor = "COMERCIAL";
                } else {
                    $valor = "INDEFINIDO";
                }
                return $valor;
            case "moneda_id":
                //EN DESUSO POR AHORA
                if(!empty($valor)){
                    if($valor=="PYG"){
                        $valor = 1;
                    }else if($valor=="USD"){
                        $valor = 2;
                    }else{
                        $valor = -1;
                    }
                }else{
                    $valor = 0;
                }
                return $valor;
            case "dsc_inmueble":
                //para este caso se necesita seleccionar el <DescriptionText> que le antecede 
                //a un <DescriptionType DescriptionType="6"> son siblings
                $valor = " ";
                $descripciones = $property->PropertyDescriptions->children();
                foreach($descripciones as $descripcion){
                    $type = (string) $descripcion->DescriptionType['DescriptionType'];
                    if($type=="6"){
                        $valor = (string) $descripcion->DescriptionText;
                    }
                }
                if(empty($valor) or $valor == '0'){
                    $valor = " ";
                }
                return $valor;
            case "direccion":
                //Si no encontramos nada en el tag AddressLine2, entonces buscamos en el 
                //tag StreetName y si aun ahi no hay nada, el campo va vacio
                if (empty($valor) or $valor == '0') {
                    $valor = (string) $property->StreetName;
                    if (empty($valor) or $valor == '0') {
                        $valor = " ";
                    }
                }
                return $valor;
            default:
                if (empty($valor) or strlen($valor)<=0) {
                    $valor = "";
                }
                return $valor;
        }
    }

    foreach($nuevosXML as $XML){
        $xml = simplexml_load_file($newDir."/".$XML);
        $c = 0;
        
        //Array que contiene los tags que se buscaran de cada <Property> (osea de cada propiedad)
        //El indice de cada tag representa su campo equivalente en la base de datos
        $tags = array(
            "id_remax" => "IntegratorPropertyID", "Finca_ccctral" => "RegionID",
            "cate_propiedad" => "CommercialResidential", "cod_iconnect" => "IntegratorSalesAssociateID",
            "direccion" => "AddressLine2", "dsc_ciudad" => "City",
            "precio" => "CurrentListingPrice", "precio_mon" => "CurrentListingCurrency",
            "totalm2" => "TotalArea", "fecha_alta" => "OrigListingDate",
            "fecha_vto" => "ExpiryDate", "dsc_inmueble" => "DescriptionText",
            "captacion_com" => "ComTotalPct", "estado" => "PropertyStatus"
        );

        //En este array se guardan los nombres de los tags (como indice) y el nombre de su atributo a 
        //buscar (como valor) si es que lo tuviese
        //Cuando se busca el attributo de un tag se ignorara el valor del mismo si es que lo tuviese
        $attrs = array(
            "RegionID" => "RegionID",
            "CurrentListingCurrency" => "CurrentListingCurrency",
            "PropertyStatus" => "PropertyStatus"        
        );

        //Se cargaran como campos los que esten definidos en el array de tags
        $campos = array();
        foreach($tags as $campo=>$tag){
            array_push($campos,$campo);
        }

        //Se recorren todos los hijos (Property) del tag <Properties>
        foreach ($xml->Properties->children() as $property) {
            $valores = array();
            $i = 0;
            
            //Se lee el array de tags para saber de que tags recuperar valores
            foreach($tags as $field=>$tag){
                $esAtributo = false; //para controlar si se debe obtener el valor del tag o algun atributo

                //Se recorre el array de atributos para saber si de este tag se debe obtener su valor 
                //o el valor de algun atributo determinado
                foreach($attrs as $indice=>$attr){

                    //Se obtiene el valor del atributo del tag
                    if($indice == $tag){
                        $esAtributo = true;
                        $valores[$field] = (string) evaluarCaso($field, (string) $property->$tag[$attr], $property);
                    }
                }

                //Se obtiene el valor del tag
                if(!$esAtributo){
                    $valores[$field] = (string) evaluarCaso($field, (string) $property->$tag, $property);
                }

                $i++;
            }

            //Escapado de la comilla de las descripciones para evitar error en el query
            foreach($valores as $indice=>$valor){
                if(strpos($valor,"'")!==false){
                    $valores[$indice] = str_replace("'", "", $valor);
                }
            }

            //VALIDACION SQL E INSERCION/MODIFICACION EN BASE DE DATOS
            $registroBD = $consultas->buscarDatoCustom($campos, $tabla, " WHERE id_remax='"
                            .$valores["id_remax"]."'");
            $modificar = gettype($registroBD) == "boolean";
            $modificar = ($modificar) ? 0 : $registroBD->num_rows;
            if ($modificar>0) {

                //corroboramos que todos los campos sean iguales
                //en teoria no pueden haber 2 id_remax iguales
                $registro = $registroBD->fetch_assoc();
                $campos_diferencia = array();
                $valores_diferencia = "";

                foreach ($valores as $campo_local => $valor_local) {

                    foreach ($registro as $campo_bd => $valor_bd) {
                        
                        if ($campo_local == $campo_bd) {

                            if ($valor_local != $valor_bd) {

                                array_push($campos_diferencia, $campo_local);

                                if (strlen($valores_diferencia) > 0) {
                                    $valores_diferencia .= " , '" . $valor_local . "' ";
                                } else {
                                    $valores_diferencia .= " '" . $valor_local . "' ";
                                }

                            }

                        }

                    }

                }
                
                if (!empty($campos_diferencia)) {
                    if ($consultas->modificarDato(
                        $tabla,
                        $campos_diferencia,
                        $valores_diferencia,
                        "id_remax",
                        $valores["id_remax"]
                    )) {
                        fwrite($log, "QUERY: Propiedad ". $valores["id_remax"]." actualizada desde $XML" . PHP_EOL);
                    } else {
                        fwrite($log, "FATAL-QUERY: Propiedad ". $valores["id_remax"]." no se pudo actualizar desde $XML a causa de: "
                            . $consultas->getLastError() . PHP_EOL);
                    }
                } else {
                    fwrite($log, "INFORME: Propiedad ". $valores["id_remax"]." ya existe y no necesita actualizarse ($XML)" . PHP_EOL);
                }
            } else {

                $str_valores = "";
                foreach($valores as $valor){
                    if (strlen($str_valores) > 0) {
                        $str_valores .= " , '" . $valor . "' ";
                    } else {
                        $str_valores .= " '" . $valor . "' ";
                    }
                }


                if ($consultas->insertarDato($tabla, $campos, $str_valores)) {
                    fwrite($log, "QUERY: Propiedad ". $valores["id_remax"]." insertada desde $XML " . PHP_EOL);
                } else {
                    fwrite($log, "FATAL-QUERY: Propiedad ". $valores["id_remax"]." no se pudo insertar desde $XML a causa de: 
                            " . $consultas->getLastError() . PHP_EOL);
                }
            }

            $c++; //aumenta en 1 al terminar de leerse un <Property>

        }
    }
?>