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
            case "estado":
                //Por ahora se ignorara el id de estado ofrecido por el xml
                $valor = "DISPONIBLE";
                return $valor;
            case "totalm2":
                if(empty($valor)){
                    $valor = "0";

                }
                return $valor;
            case "captacion_com":
                if (empty($valor)) {
                    $valor = "0";
                }
                return $valor;
            case "listingstatus":
                if(empty($valor)){
                    return "";
                }else{
                    switch($valor){
                        case "1":
                            return "Active";
                        case "2":
                            return "Sold";
                        case "3":
                            return "Rented";
                        case "4":
                            return "Expired";
                        case "5":
                            return "Cancelled";
                        case "6":
                            return "Sold by Other Agent";
                        case "7":
                            return "Sold by Owner";
                        case "8":
                            return "Sale Agreed";
                        case "9":
                            return "On Option";
                        case "10":
                            return "Prospective";
                        default: 
                            return "Undefined";
                    }
                }
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
            "id_remax" => "IntegratorPropertyID",
            "cate_propiedad" => "CommercialResidential", "cod_iconnect" => "IntegratorSalesAssociateID",
            "direccion" => "AddressLine2", "dsc_ciudad" => "City",
            "precio" => "CurrentListingPrice", "precio_mon" => "CurrentListingCurrency",
            "totalm2" => "TotalArea", "fecha_alta" => "OrigListingDate",
            "fecha_vto" => "ExpiryDate", "dsc_inmueble" => "DescriptionText",
            "captacion_com" => "ComTotalPct", "estado" => "PropertyStatus",
            "listingstatus" => "ListingStatus", "code" => "ListingStatus",
            "transaction_type" => "TransactionType"
        );

        //En este array se guardan los nombres de los tags (como indice) y el nombre de su atributo a 
        //buscar (como valor) si es que lo tuviese
        //Cuando se busca el attributo de un tag se ignorara el valor del mismo si es que lo tuviese
        $attrs = array(
            "CurrentListingCurrency" => "CurrentListingCurrency",
            "PropertyStatus" => "PropertyStatus",
            "ListingStatus" => "ListingStatus",
            "TransactionType" => "TransactionType"        
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
                        $valores[$field] = (string) evaluarCaso($field, (string) $property->$tag->attributes()->$attr, $property);
                        //$valores[$field] = (string) evaluarCaso($field, (string) $property->$tag[$attr], $property);
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
                fwrite($log, "INFORME: Propiedad " . $valores["id_remax"] . " ya existe y no necesita actualizarse ($XML)" . PHP_EOL);
                //corroboramos que todos los campos sean iguales
                //en teoria no pueden haber 2 id_remax iguales
                /*$registro = $registroBD->fetch_assoc();
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
                }*/

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

    //Obtencion de los registros de la tabla de monedas
    $monedas = $consultas->consultarDatos(array("id", "simbolo"), "moneda");
    $simbolo_monedas = array();
    if (gettype($monedas) != "boolean") {
        if ($monedas->num_rows > 0) {
            while ($registro = $monedas->fetch_assoc()) {
                array_push($simbolo_monedas, $registro);
            }
        } else {
            fwrite($log, "SQL ERROR: No se encontraron registros en la tabla de monedas" . PHP_EOL);
        }
    } else {
        fwrite($log, "SQL ERROR: No se encontraron registros en la tabla de monedas" . PHP_EOL);
    }

    //Obtencion de los registros de l a tabla de popiedades
    $simbolo_propiedades = $consultas->consultarDatos(array("id", "precio_mon"), "propiedades");
    if (gettype($simbolo_propiedades) != "boolean") {
        if ($simbolo_propiedades->num_rows > 0) {
            while ($registro_propiedades = $simbolo_propiedades->fetch_assoc()) {
                //Comparacion con los simbolos de la tabla moneda para obtener el id de la moneda
                $updated = false;
                foreach ($simbolo_monedas as $moneda) {
                    if ($registro_propiedades["precio_mon"] == $moneda["simbolo"]) {
                        $res = $consultas->modificarDato(
                            "propiedades",
                            array("moneda_id"),
                            $moneda["id"],
                            "id",
                            $registro_propiedades["id"]
                        );
                        if ($res > 0) {
                            $updated = true;
                        }
                    }
                }
                //Que no se haya actualizado se puede deber a que la consulta fallo o que le simbolo 
                //no exista en la tabla de monedas
                if (!$updated) {
                    fwrite($log, "SQL ALERTA: No se actualizó el campo moneda_id de la propiedad con id "
                      . $registro_propiedades["id"] . PHP_EOL);
                } else {
                    fwrite($log, "SQL INFORME: Se actualizó el campo moneda_id de la propiedad con id "
                        . $registro_propiedades["id"] . PHP_EOL);
                }
            }
        } else {
            fwrite($log, "SQL ERROR: No se encontraron registros en la tabla de propiedades" . PHP_EOL);
        }
    } else {
        fwrite($log, "SQL ERROR: No se encontraron registros en la tabla de propiedades" . PHP_EOL);
    }

?>