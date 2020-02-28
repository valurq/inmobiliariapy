<!DOCTYPE HTML>
<html>
<head>
    <?php
        /*
        SECCION PARA OBTENER VALORES NECESARIOS PARA LA MODIFICACION DE REGISTROS
        ========================================================================
        */
        session_start();
        include("Parametros/conexion.php");
        $inserta_Datos= new Consultas();
        include("Parametros/verificarConexion.php");
        @$usuarioLogeado = $_SESSION['idUsu'] ;
        $resultado="";

        
    ?>


    <title>VALURQ_SRL</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <meta name="generator" content="Web Page Maker">
      <link rel="stylesheet" href="CSS/popup.css">
      <link rel="stylesheet" href="CSS/formularios.css">
      <script
			  src="https://code.jquery.com/jquery-3.4.0.js"
			  integrity="sha256-DYZMCC8HTC+QDr5QNaIcfR7VSPtcISykd+6eSmBW5qo="
			  crossorigin="anonymous"></script>
        <script type="text/javascript" src="Js/funciones.js"></script>
        <script src="Js/Chart.js-2.9.3/dist/Chart.js"></script>
        <script src="http://momentjs.com/downloads/moment.min.js"></script>
        <script src="Js/Sortable/js/jquery.tablesorter.min.js"></script>
        <script src="Js/Sortable/js/jquery.tablesorter.widgets.min.js"></script>

    <link rel="stylesheet" href="Js/Sortable/css/theme.blue.css">
    <style>

        @import url(https://fonts.googleapis.com/css?family=Raleway:400,500);
        
        body{
            font-family: 'Raleway', Arial, sans-serif;
        }
        .content{
            display: flex;
            flex-flow: column;
            max-width: 80%;
            min-width: 1240px;
            margin: auto;
            padding: 16px 32px;
        }

        .wrapper{
            display: flex;
            justify-content: space-between;
        }

        .row{
            display: inline-block;
            min-height: 256px;
            width: 48%;
            /*border: 3px solid #369989;*/
            border-radius: 10px;
            box-sizing: border-box;
            padding: 30px;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 1px 3px 10px black;
        }

        div{
            display: block;
        }

        canvas{
            display: block;
        }

        h2{
            text-align: center;
            margin: 0px;
        }

        #cabecera{
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #cabecera h2{
            width: 100%;
            text-align: center;
            font-size: 30px;
        }

        #datosPersonales{
            font-weight: bold;
            display: flex;
            justify-content: space-around;
        }

        #datosPersonales div{
            width: 33%;
        }

        #datosBasicos, #ranking, #estadisticas{
            display: flex;
            flex-flow: column;
            justify-content: center;
            box-sizing: border-box;
        }

        #datosBasicos{
            font-size: 20px;
            border-right: 1px solid black;
        }

        #datosBasicos p{
            margin: 3px 0px;
        }

        #ranking{
            font-size: 20px;
        }

        #estadisticas{
            border-left: 1px solid black;
            align-items: center;
            font-size: 120x;
        }

        #estadisticas h2, p{
            margin: 3px 0px;
        }

        #totalesCantidad{
            width: 40%;
            display: flex;
            flex-flow: column;
            justify-content: space-around;
            align-items: center;
        }

        #totalesCantidad p{
            font-weight: bold;
        }

        #cantidadEmpleados{
            width: 100%;
            display: flex;
            align-items: center;
        }

        #cantidadEmpleados *{
            margin-left: 10px;
            font-weight: bold;
        }

        #cantidadEmpleados button{
            font-family: inherit;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            background-color: #99bfe6;
            color: black;
            border: none;
            box-sizing: border-box;
            padding: 10px;
            border-radius: 5px;
            border: 2px solid #99bfe6;
        }

        #cantidadEmpleados button:hover{
            background-color: white;
            color: #99bfe6;
            box-sizing: border-box;
        }


    </style>

    <script>
        $(function(){
            sortTable();
        });

        function sortTable () {
            $("#tabla").tablesorter({
                theme: 'blue',
                widgets: ['zebra', 'filter', 'resizable']
            });
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>

</head>
<body style="background-color:#EEEEEE">

    <div class="content">

            <div class="row" style="width: 100%; max-height: 350px; padding: 10px 60px 30px; box-sizing: border-box;">
                <div id="cabecera">
                    <h2>DASHBOARD DE OPERACIONES</h2>
                    <img src="Imagenes/reemax.png" alt="Logo RE/MAX" width="60px">
                </div>

                <div id="datosPersonales">
                    <div id="datosBasicos">
                    </div>

                    <div id="ranking">

                    </div>

                    <div id="estadisticas">
                        
                    </div>
                </div>


            </div>
        
        <div class="wrapper">

            <div class="row">
                <h2>Cantidad de operaciones<br />Total</h2>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <div style="width: 50%">
                        <canvas id="pie" class="chart" width="392" height="256"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <h2>Cantidad de operaciones<br />Periodo: 6 meses</h2>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <div style="width: 50%">
                        <canvas id="doughnut" class="chart" width="392" height="256"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row" style="width: 100%; display: flex; justify-content: center;">
            <div style="width: 50%">
                <h2>Cantidad de operaciones por periodo<br />Periodo: 6 meses</h2>
                <div style="display: flex;">
                    <div style="width: 60%">
                        <canvas id="line" class="chart" width="392" height="256"></canvas>
                    </div>
                    <div id="totalesCantidad">
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="wrapper">
            <div class="row">
                <h2>Total de operaciones por precio PYG (en millones)<br /><br /></h2>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <div style="width: 50%">
                        <canvas id="bar" class="chart" width="392" height="256"></canvas>  
                    </div>
                </div>
            </div>

            <div class="row">
                <h2>Total de operaciones por precio PYG (en millones)<br />Periodo: 6 meses</h2>
                <div style="width: 100%; display: flex; justify-content: center;">
                    <div style="width: 50%">
                        <canvas id="horizontalBar" class="chart" width="392" height="256"></canvas>            
                    </div>
                </div>
            </div>     
        </div>       
        <div class="row"  id="tablaWrap" style="width: 100%">
            <div id="cantidadEmpleados">
                
            </div>

            <div>
                <table id="tabla" class="tablesorter">
                
                </table>
            </div>
        </div>
    </div>
    

</body>

<script type="text/javascript">
    let idUsuario = '<?php echo $usuarioLogeado ?>';
    //let idUsuario = 8;
    let datosPersonales = comprobarCargo(idUsuario);
    
    estadistica(datosPersonales);

    function estadistica (datosPersonales) {
        $('#datosBasicos').empty();
        $('#ranking').empty();
        $('#estadisticas').empty();
        $('#totalesCantidad').empty();

        cargarCabecera(datosPersonales);

        if(comprobarCargo(idUsuario).cargo == 'AGENTE'){
            document.getElementById('tablaWrap').style.display = 'none';
        }

        let datosCantidad = '', datosCantidadMeses = '', datosPrecio = '', datosPrecioMeses = '', datosOperaXMesVenta = '', datosOperaXMesAlquiler = '', datosOperaXMesAdm = '', totalImporteOperacion = [], cantidadEmpleados = [];
        if(datosPersonales.cargo == 'AGENTE'){
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} GROUP BY operacion`, resultado => {datosCantidad = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosCantidadMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  WHERE vendedor_id = ${datosPersonales.id} GROUP BY operacion`, resultado => {datosPrecio = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  WHERE vendedor_id = ${datosPersonales.id} AND cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH)  AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosPrecioMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'VENTA' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesVenta = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'ALQUILER' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAlquiler = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'ALQUILER ADMI' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAdm = resultado});
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'VENTA'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'ALQUILER'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} AND operacion = 'ALQUILER ADMI'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));

            //document.getElementById('tablaWrap').style.display = 'none';

        }else if(datosPersonales.cargo == 'MANAGER' || datosPersonales.cargo == 'BROKER'){
            let datosAgentes = []
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} GROUP BY operacion`, resultado => {datosCantidad = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosCantidadMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  WHERE oficina_id = ${datosPersonales.id_oficina} GROUP BY operacion`, resultado => {datosPrecio = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  WHERE oficina_id = ${datosPersonales.id_oficina} AND cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH)  AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosPrecioMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'VENTA' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesVenta = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'ALQUILER' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAlquiler = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'ALQUILER ADMI' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAdm = resultado});
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'VENTA'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'ALQUILER'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} AND operacion = 'ALQUILER ADMI'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));

            obtenerDatosCallBackQuery(`SELECT usuario_id FROM vendedor WHERE oficina_id = ${datosPersonales.id_oficina}`, resultado => {
                resultado.forEach(registro => {
                    datosAgentes.push(comprobarCargo(registro));
                });
            });

            obtenerDatosCallBackQuery(`SELECT sum((SELECT COUNT(*) FROM vendedor WHERE vendedor.oficina_id=oficina.id)) AS cant_vendedores FROM oficina WHERE id = ${datosPersonales.id_oficina} AND oficina.estado='ACTIVO'`, resultado => cantidadEmpleados.push(resultado[0]));

            cargarTabla(datosAgentes, 'Nombre del agente', 'Apellido del agente', 'Oficina', 'Comisión en Gs', 'Comisión en USD', 'Operaciones', 'Propiedades activas', 'Ranking', 'Ver estadisticas');

        }else{
            let datosOficinas = [];
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones GROUP BY operacion`, resultado => {datosCantidad = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosCantidadMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  GROUP BY operacion`, resultado => {datosPrecio = resultado});
            obtenerDatosCallBackQuery(`SELECT operacion,SUM(precio_finalGS) / 1000000 AS sumPrecio FROM vista_operaciones  WHERE cab_fecha >= DATE_SUB(CURDATE(),INTERVAL '6' MONTH)  AND cab_fecha <= CURDATE() GROUP BY operacion`, resultado => {datosPrecioMeses = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE  operacion = 'VENTA' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesVenta = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE operacion = 'ALQUILER' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAlquiler = resultado});
            obtenerDatosCallBackQuery(`SELECT MONTH(cab_fecha) AS mes,COUNT(*) AS qty FROM vista_operaciones WHERE operacion = 'ALQUILER ADMI' AND cab_fecha BETWEEN DATE_SUB(CURDATE(),INTERVAL '6' MONTH) AND CURDATE() GROUP BY operacion, MONTH(cab_fecha)`, resultado => {datosOperaXMesAdm = resultado});
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE operacion = 'VENTA'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE operacion = 'ALQUILER'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));
            obtenerDatosCallBackQuery(`SELECT SUM(precio_finalGS) AS totalvendido FROM vista_operaciones WHERE operacion = 'ALQUILER ADMI'`, resultado => totalImporteOperacion.push(parseInt(resultado[0][0])));

            obtenerDatosCallBackQuery(`SELECT usuario_id FROM manager`, resultado => {
                resultado.forEach(registro => {
                    datosOficinas.push(comprobarCargo(registro));
                });
            });

            obtenerDatosCallBackQuery(`SELECT sum((SELECT COUNT(*) FROM vendedor WHERE vendedor.oficina_id=oficina.id)) AS cant_vendedores ,sum((SELECT COUNT(*) FROM brokers WHERE brokers.oficina_id=oficina.id)) AS cant_brokers,sum((SELECT COUNT(*) FROM manager WHERE manager.oficina_id=oficina.id))AS cant_managers FROM oficina WHERE oficina.estado='ACTIVO'`, resultado => cantidadEmpleados.push(resultado[0]));

            cargarTabla(datosOficinas, 'Nombre del manager', 'Apellido del manager', 'Oficina', 'Comisión en Gs', 'Comisión en USD', 'Operaciones', 'Propiedades activas', 'Ranking', 'Ver estadisticas');
        }

        cargarDatosTotales(totalImporteOperacion);
        if(datosPersonales.cargo != 'AGENTE')
            cargarCantidadEmpleado(datosPersonales.cargo, cantidadEmpleados[0]);

        //Adiccion de Colores
        cargarColor(datosCantidad);
        cargarColor(datosCantidadMeses);
        cargarColor(datosPrecio);
        cargarColor(datosPrecioMeses);

        reestructurarOperaXMes(datosOperaXMesVenta, datosOperaXMesAlquiler, datosOperaXMesAdm);

        eliminarChart('pie');
        let pieChart = document.getElementById('pie').getContext('2d');
        let data = cargarData('pie', datosCantidad);
        dibujarChart(pieChart, 'pie', data);

        eliminarChart('doughnut');
        let doughnutChart = document.getElementById('doughnut').getContext('2d');
        data = cargarData('doughnut', datosCantidadMeses);
        dibujarChart(doughnutChart, 'doughnut', data);

        let options = {
            scales: {
                yAxes:[{
                    ticks: {beginAtZero: true}
                }]
            }
        }
        eliminarChart('line');
        let lineChart = document.getElementById('line').getContext('2d');
        data =  cargarData('line', reestructurarOperaXMes(datosOperaXMesVenta, datosOperaXMesAlquiler, datosOperaXMesAdm));
        dibujarChart(lineChart, 'line', data, options);

        eliminarChart('bar');
        let barVerChart = document.getElementById('bar').getContext('2d');
        data = cargarData('bar', datosPrecio);
        options = {
            scales: {
                yAxes:[{
                    ticks: {beginAtZero: true}
                }]
            }
        }
        dibujarChart(barVerChart, 'bar', data, options);

        eliminarChart('horizontalBar');
        let barHorChart = document.getElementById('horizontalBar').getContext('2d');
        data = cargarData('horizontalBar', datosPrecioMeses);
        options = {
            scales:{
                xAxes: [{
                    ticks: {beginAtZero: true}
                }]
            }
        }
        dibujarChart(barHorChart, 'horizontalBar', data, options);
    }

    function cargarCabecera (datosPersonales) {
        crearElemento('p', `Nombre completo: ${datosPersonales.nombre} ${datosPersonales.apellido}`, 'datosBasicos');
        crearElemento('p', `Cargo: ${datosPersonales.cargo}`, 'datosBasicos');

        if(datosPersonales.nombreOficina != ''){
            crearElemento('p', `Oficina: ${datosPersonales.nombreOficina}`, 'datosBasicos');
            crearElemento('p', `Dirección de la oficina: ${datosPersonales.dirOficina}`, 'datosBasicos');

            crearElemento('h2', 'RANKING', 'ranking');
            crearElemento('h2', `${datosPersonales.ranking}`, 'ranking');
        }

        if(datosPersonales.fechaIngreso !=  ''){
            let ano = moment().diff(moment(datosPersonales.fechaIngreso), 'year');
            let mes = moment().diff(moment(datosPersonales.fechaIngreso), 'month');
            mes = (ano > 1) ? Math.floor(mes / (12 * ano) ) : mes;
            crearElemento('p', `Se unió hace: 
                ${ (ano) ? ( 
                    (ano > 1 ) ? (ano + ' años') : (ano + ' año') 
                    ) : '' } 
                ${ (mes) ? (
                    (mes > 1) ? (mes + ' meses') : (mes + ' mes')
                    ) : ( (ano < 1) ? 'menos de 1 mes' : '') }
            `, 'datosBasicos');
        }

        if(datosPersonales.cargo == 'REGIONAL'){
            document.getElementById('ranking').style.display = 'none';
            document.getElementById('datosBasicos').style.width = '50%';
            document.getElementById('estadisticas').style.width = '50%';
        }else{
            document.getElementById('ranking').style.display = 'flex';
            document.getElementById('datosBasicos').style.width = '50%';
            document.getElementById('estadisticas').style.width = '50%';
        }

        crearElemento('h2', 'Comisiones', 'estadisticas');
        crearElemento('p', `${datosPersonales.comisionGs.toUpperCase()}`, 'estadisticas');
        crearElemento('p', `${datosPersonales.comisionUs}`, 'estadisticas');
        crearElemento('h2', 'Operaciones', 'estadisticas');
        crearElemento('p', `${datosPersonales.totalOperacion}`, 'estadisticas');
        crearElemento('h2', 'Propiedades activas', 'estadisticas');
        crearElemento('p', `${datosPersonales.totalProAct}`, 'estadisticas');
    }

    function cargarDatosTotales (importesTotales) {
        crearElemento('h2', 'Importes Totales', 'totalesCantidad');
        let venta = (importesTotales[0]) ? new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(importesTotales[0]).toUpperCase() : 'GS. 0';
        crearElemento('p',`Venta: ${venta}`, 'totalesCantidad');
        let alquiler = (importesTotales[1]) ? new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(importesTotales[1]).toUpperCase() : 'GS. 0';
        crearElemento('p',`Alquiler: ${ alquiler }`, 'totalesCantidad');
        let admin = (importesTotales[2]) ? new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(importesTotales[2]).toUpperCase() : 'GS. 0';
        crearElemento('p',`Alq. Adm.: ${admin}`, 'totalesCantidad');

    }

    function cargarData (tipoChart, datos) {

        let data = {
            labels: [],
            datasets: [],
            options: {}
        };

        let dataset = {
            label: [],
            data: [],
            backgroundColor: []
        }

        if(tipoChart == 'bar' || tipoChart == 'horizontalBar'){
            data.labels = [''];

            for (registro of datos) {
                dataset = {label: [],data: [], backgroundColor: []}
                dataset.label.push(registro[0]);
                dataset.data.push(registro[1]);
                dataset.backgroundColor.push(registro[2]);
                data.datasets.push(dataset);
            }
        }

        if(tipoChart == 'pie' || tipoChart == 'doughnut'){
            for (dato of datos) {
                data.labels.push([dato[0]]);
                dataset.data.push(dato[1]);
                dataset.backgroundColor.push(dato[2]);
            }
            data.datasets.push(dataset);
        }

        if(tipoChart == 'line'){
            for (mes of datos[0]) {
                data.labels.push(obtenerMes(mes));
            }

            datos.shift();
            for (valores of datos[0]) {
                dataset = {label: [],data: []}
                let numeros = [];
                valores.forEach(numero => numeros.push(parseInt(numero)));
                dataset.data = numeros;
                dataset.fill = false;
                dataset.lineTension = 0;
                data.datasets.push(dataset);
            }

            datos.shift();
            datos[0].forEach( (label,index) => {
                data.datasets[index].label = [label];
                data.datasets[index].borderColor = obtenerColor(index);
                data.datasets[index].borderWidth = '5';
                data.datasets[index].pointBackgroundColor = obtenerColor(index);
            });
            //data.datasets[0].label = datos
            
        }

        return data;
    }

    function eliminarChart (idChart) {
        let canvas = document.getElementById(idChart);
        let padre = canvas.parentElement;
        canvas.remove();
        canvas = document.createElement('canvas');
        canvas.setAttribute('id', idChart);
        canvas.setAttribute('class', 'chart');
        canvas.setAttribute('width', '392');
        canvas.setAttribute('height', '256');
        padre.appendChild(canvas);
    }

    function dibujarChart (variableChart, tipo, data, options) {
        let chart = new Chart(variableChart, {
            type: tipo,
            data: data,
            options: options
        });

        return chart;
    }

    function comprobarCargo (idUsuario) {
        let datosPersonales = {id: 0, nombre: '', apellido: '', cargo: 'REGIONAL', id_oficina: 0, nombreOficina: '', dirOficina: '', fechaIngreso: '', ranking: '', comisionGs: 0, comisionUs: 0, totalOperacion: 0, totalProAct: 0,};

        obtenerDatosCallBackQuery(`SELECT nombre, apellido FROM usuario WHERE id = ${idUsuario}`, resultado => {datosPersonales.nombre = resultado[0][0]; datosPersonales.apellido = resultado[0][1]});

        obtenerDatosCallBackQuery(`SELECT id, oficina_id, fe_ingreso_py FROM vendedor WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'AGENTE';
                datosPersonales.id_oficina = resultado[0][1];
                datosPersonales.fechaIngreso = resultado[0][2];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina, direccion FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => {datosPersonales.nombreOficina = resultado[0][0]; datosPersonales.dirOficina = resultado[0][1]});
                obtenerDatosCallBackQuery(`SELECT RK FROM Ranking_agentes WHERE vendedor_id = ${datosPersonales.id}`, resultado => datosPersonales.ranking = resultado[0].toString());
                obtenerDatosCallBackQuery(`SELECT Tcomision_GS, Tcomision_USD, Toperacion, TpropActivas FROM vista_ofi_agentes WHERE id_Agente = ${datosPersonales.id}`, resultado => {
                        datosPersonales.comisionGs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(resultado[0][0]);
                        datosPersonales.comisionUs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'USD'}).format(resultado[0][1]);
                        datosPersonales.totalOperacion = resultado[0][2];
                        datosPersonales.totalProAct = resultado[0][3];
                });
            }
        });

        if(datosPersonales.id)
            return datosPersonales;
        
        obtenerDatosCallBackQuery(`SELECT id, oficina_id FROM manager WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'MANAGER';
                datosPersonales.id_oficina = resultado[0][1];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina, direccion FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => {datosPersonales.nombreOficina = resultado[0][0]; datosPersonales.dirOficina = resultado[0][1]});
                obtenerDatosCallBackQuery(`SELECT RK FROM Ranking_oficina WHERE oficina_id = ${datosPersonales.id_oficina}`, resultado => datosPersonales.ranking = resultado[0].toString());
                obtenerDatosCallBackQuery(`SELECT Tcomision_GS, Tcomision_USD, Toperacion, TpropActivas FROM vista_reg_oficinas WHERE oficina_id = ${datosPersonales.id_oficina}`, resultado => {
                        datosPersonales.comisionGs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(resultado[0][0]);
                        datosPersonales.comisionUs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'USD'}).format(resultado[0][1]);
                        datosPersonales.totalOperacion = resultado[0][2];
                        datosPersonales.totalProAct = resultado[0][3];
                });
            }
        });

        if(datosPersonales.id)
            return datosPersonales;

        obtenerDatosCallBackQuery(`SELECT id, oficina_id FROM brokers WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'BROKER';
                datosPersonales.id_oficina = resultado[0][1];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina, direccion FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => {datosPersonales.nombreOficina = resultado[0][0]; datosPersonales.dirOficina = resultado[0][1]});
                obtenerDatosCallBackQuery(`SELECT RK FROM Ranking_oficina WHERE oficina_id = ${datosPersonales.id_oficina}`, resultado => datosPersonales.ranking = resultado[0].toString());
                obtenerDatosCallBackQuery(`SELECT Tcomision_GS, Tcomision_USD, Toperacion, TpropActivas FROM vista_reg_oficinas WHERE oficina_id = ${datosPersonales.id_oficina}`, resultado => {
                        datosPersonales.comisionGs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(resultado[0][0]);
                        datosPersonales.comisionUs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'USD'}).format(resultado[0][1]);
                        datosPersonales.totalOperacion = resultado[0][2];
                        datosPersonales.totalProAct = resultado[0][3];
                });
            }
        });

        if(datosPersonales.id)
            return datosPersonales;

        obtenerDatosCallBackQuery(`SELECT Tcomision_GS, Tcomision_USD, Toperacion, TpropActivas FROM vista_reg_oficinas`, resultado => {
                        resultado.forEach(registro => {
                            datosPersonales.comisionGs += parseFloat(registro[0]);
                            datosPersonales.comisionUs += parseFloat(registro[1]);
                            datosPersonales.totalOperacion += parseInt(registro[2]);
                            datosPersonales.totalProAct += parseInt(registro[3]);
                        });
                        datosPersonales.comisionGs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'PYG'}).format(datosPersonales.comisionGs);
                        datosPersonales.comisionUs = new Intl.NumberFormat("es-PY", {style: 'currency', currency: 'USD'}).format(datosPersonales.comisionUs);
                });
        return datosPersonales;
    }

    function cargarColor (datos) {
        let colores = ['#4F708C' ,'#F7DB4F', '#E84A5F'];
        for(let k = 0; k < datos.length; k++){
            datos[k].push(colores[k]);
        }
    }

    function obtenerColor (indice) {
        let colores = ['#4F708C' ,'#F7DB4F', '#E84A5F'];
        return colores[indice];
    }

    function updateTabla (...titulos) {
        $('#tabla').empty();

        let tHead = document.createElement('thead');
        let trHead = document.createElement('tr');

        for(titulo of titulos){
            let th = document.createElement('th');
            let text = document.createTextNode(titulo);
            th.appendChild(text);
            trHead.appendChild(th);
        }
        tHead.appendChild(trHead);
        document.getElementById('tabla').appendChild(tHead);

        let tBody = document.createElement('tbody');
        tBody.setAttribute('id', 'bodyTabla');
        document.getElementById('tabla').appendChild(tBody);

    }

    function cargarTabla (registros, ...titulos) {
        updateTabla(...titulos);

        for (dato of registros) {
            let fila = new Object();
            fila = Object.assign(fila, dato);
            let row = document.createElement('tr');
            let tData = document.createElement('td');
            let text = document.createTextNode(fila.nombre);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            text = document.createTextNode(fila.apellido);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            text = document.createTextNode(fila.nombreOficina);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            tData.style.textAlign = 'right';
            text = document.createTextNode(fila.comisionGs.toUpperCase());
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            tData.style.textAlign = 'right';
            text = document.createTextNode(fila.comisionUs);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            text = document.createTextNode(fila.totalOperacion);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            text = document.createTextNode(fila.totalProAct);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            text = document.createTextNode(fila.ranking);
            tData.appendChild(text);
            row.appendChild(tData);

            tData = document.createElement('td');
            let button = document.createElement('button');
            button.addEventListener('click', () => {estadistica(fila)});
            button.innerHTML = 'Ver';
            tData.appendChild(button);
            tData.style.textAlign = 'center';
            row.appendChild(tData);

            $('#bodyTabla').prepend(row);
        }
    }

    function cargarCantidadEmpleado (cargo, registros) {
        $('#cantidadEmpleados').empty();

        let boton = document.createElement('button');
        let text = document.createTextNode('Recargar');
        boton.appendChild(text);
        boton.addEventListener('click', () => location.reload());
        document.getElementById('cantidadEmpleados').appendChild(boton);

        crearElemento('p', `Cantidad de agentes: ${registros[0]}`, 'cantidadEmpleados');
            
        if(cargo == 'REGIONAL'){
           crearElemento('p', `Cantidad de brokers: ${registros[1]}`, 'cantidadEmpleados'); 
           crearElemento('p', `Cantidad de managers: ${registros[2]}`, 'cantidadEmpleados');
        }
    }

    function crearElemento (etiqueta, contenido, idUbicacion) {
        let elemento = document.createElement(etiqueta);
        text = document.createTextNode(contenido);
        elemento.appendChild(text);
        
        document.getElementById(idUbicacion).appendChild(elemento);
    }

    function reestructurarOperaXMes (...contenidos) {
        let meses = [];
        for (registro of contenidos) {
            for (dato of registro) {
                meses.push(dato[0]);
            }
        }

        meses = meses.filter((item, index) => meses.lastIndexOf(item) == index);

        let data = [];
        for (registro of contenidos) {
            let valores = new Array(meses.length);
            valores.fill(0);
            for (index in meses) {
                for (dato of registro) {
                    if(dato[0] == meses[index])
                        valores[index] = dato[1];
                }
            }
            data.push(valores);
        }
        return [meses, data, ['VENTA', 'ALQUILER', 'ALQUILER ADM']];
    }

    function obtenerMes(indice){
        let meses = ['', 'ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];
        return meses[indice].toString();
    }

</script>

</html>
