<?php
    session_start();
    include("Parametros/conexion.php");
    $consultas= new Consultas();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <script
  			  src="https://code.jquery.com/jquery-3.4.0.js"
  			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
  			  crossorigin="anonymous"></script>
          <script type="text/javascript" src="Js/funciones.js"></script>
    </head>
    <body>
        <input autocomplete="off" list="id_propiedades" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscadorAntiguo(this.value)" >
        <datalist id="id_propiedades">
          <option value=""></option>
        </datalist>
        <input autocomplete="off" type="hidden" name="idPropiedad" id="idPropiedad">
        <br>
        <br>
        <br>
        <br>
        <input autocomplete="off" list="propTest" id="propiedades" name="propiedades" autocomplete="off" onkeyup="buscar(this.value)" >
        <datalist id="propTest">
          <option value=""></option>
        </datalist>
        <input autocomplete="off" type="text" name="idPropiedadTest" id="idPropiedadTest">
        <textarea id='array' rows="8" cols="80"></textarea>
    </body>
    <script type="text/javascript">
    window.listaPropiedades=[];
    window.arrayRes;
    obtenerDatosCallBack(['id','id_remax'],'propiedades','','','',(resultado){
        for (var datos of resultado) {
            window.listaPropiedades.push(datos);
        }
        //$("#array").html(JSON.stringify(window.listaPropiedades));

    });
    function buscadorAntiguo(valor){
        //buscarListaQ(['id_remax'], valor,'propiedades', 'id_remax', 'id_propiedades', 'idPropiedad','LIMIT 10')
    }
    function cargarLista
    function buscar(valor){
        window.arrayRes=[];
        window.arrayRes= window.listaPropiedades.filter((x) => (x[1].indexOf(valor)!=-1));
        //console.log(window.arrayRes);
        $("#propTest").empty()
        for(i=1 ; i<Math.min(10,window.arrayRes.length);i++){
            cargarData(window.arrayRes[i],"propTest", "idPropiedadTest");
        }

    }
    function cargarData(datos, listaID, listaIDAux){
        let lista = document.getElementById(listaID);
        //console.log(lista);

        let option = document.createElement('option');
        option.value=datos[0];
        option.innerHTML=datos[1];
        option.addEventListener('click',function(){
            alert(this.value);
            //document.getElementById("idPropiedadTest").value=this.value;
        })
        lista.appendChild(option);
        document.getElementById(listaIDAux).setAttribute('value', datos[0]);

    }
    </script>
</html>
