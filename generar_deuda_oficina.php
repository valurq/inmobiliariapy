<?php 
	include("Parametros/conexion.php");
    $fecreacion = date("Y")."-".date("m")."-".date("d");
    $dia_final = date("Y-m-t", strtotime($fecreacion));
    $fecreacion = date("Y-m-d",strtotime($fecreacion));

    if($fecreacion == $dia_final){

      $inserta_Datos= new Consultas();

      $campos = array('id', 'moneda_id', 'oficina_id');
      $contratoId = $inserta_Datos->consultarDatos($campos,'contratos','','estado','VIGENTE');

      $contrato = array();
      while($aux=$contratoId->fetch_row()){
        array_push($contrato,$aux);
      }

      $campos = array('id', 'contratos_id', 'fee_administrativo', 'fondo_marketing', 'desde', 'hasta');
      $variacion_anual = array();
      for ($i=0; $i < count($contrato); $i++) { 
        $variacionAnualId =$inserta_Datos->consultarDatos($campos,'variacion_anual','','contratos_id', $contrato[$i][0]);
        $variacion_anual[$i]=array();
        while($aux2=$variacionAnualId->fetch_row()){
          array_push($variacion_anual[$i],$aux2);
        }
      }

      for ($i=0; $i < count($contrato); $i++) { 
        print_r($contrato);
        echo "<br><br>";
        print_r($variacion_anual[$i]);
        echo "<br><br>";
      }

      for ($i=0; $i < count($contrato); $i++){
        $moneda_id = $contrato[$i][1];
        $oficina_id = $contrato[$i][2];

        for ($j=0; $j < count($variacion_anual[$i]); $j++) {
        $desde = date("Y-m-d",strtotime($variacion_anual[$i][$j][4]) );
        $hasta = date("Y-m-d",strtotime($variacion_anual[$i][$j][5]) );
          
          if ($desde <= $fecreacion && $hasta >= $fecreacion) {
            $importe_adm = $saldo_adm = $variacion_anual[$i][$j][2];
            $importe_mkt = $saldo_mkt = $variacion_anual[$i][$j][3];
            $fe_vto = date("Y-m-t", strtotime("+1 months",strtotime($fecreacion)));
            $estado = "PENDIENTE";
            $concepto = "Gastos administrativos";
            $creador = "SISTEMA";
            $campos = array('moneda_id', 'oficina_id', 'fe_vto', 'importe', 'saldo', 'estado', 'concepto', 'creador');
            $valores = "'".$moneda_id."', '".$oficina_id."', '".$fe_vto."', '".$importe_adm."', '".$saldo_adm."', '".$estado."', '".$concepto."', '".$creador."'";
            $inserta_Datos->insertarDato('afiliacion_oficina',$campos,$valores);

            //echo "funciona primero";

            $concepto = "Gastos de marketing";
            $valores = "'".$moneda_id."', '".$oficina_id."', '".$fe_vto."', '".$importe_mkt."', '".$saldo_mkt."', '".$estado."', '".$concepto."', '".$creador."'";
            $inserta_Datos->insertarDato('afiliacion_oficina',$campos,$valores);

            //echo "<br /> Funciona despues";
          }
          else{
            continue;
          }
        }

      }

    }

    

 ?>