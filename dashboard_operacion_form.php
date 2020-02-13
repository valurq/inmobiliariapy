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

    <style>
        .content{
            max-width: 80%;
            margin: auto;
            padding: 16px 32px;
        }

        .row{
            display: inline-block;
            min-height: 256px;
            width: 48%;
        }

        div{
            display: block;
        }

        canvas{
            display: block;
        }

    </style>

</head>
<body style="background-color:white">
    <h2>DASHBOARD DE OPERACIONES</h2>

    <div class="content">
        <div class="row">
            <canvas id="chart1" class="chart" width="392" height="256"></canvas>
        </div>
        <div class="row">
            <canvas id="chart2" class="chart" width="392" height="256"></canvas>
        </div>
        <!-- <div class="row">
            <canvas id="chart3" class="chart" width="392" height="256"></canvas>
        </div> -->
        <div class="row">
            <canvas id="chart4" class="chart" width="392" height="256"></canvas>
        </div>
        <div class="row">
            <canvas id="chart5" class="chart" width="392" height="256"></canvas>            
        </div>
    </div>
    

</body>

<script type="text/javascript">
    let idUsuario = '<?php echo $usuarioLogeado ?>';
    
    let datosPersonales = comprobarCargo(25);
    let datos = '';
    if(datosPersonales.cargo == 'AGENTE'){
        console.log(datosPersonales);
        obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE vendedor_id = ${datosPersonales.id} GROUP BY operacion`, resultado => {datos = resultado});

    }else if(datosPersonales.cargo == 'MANAGER' || datosPersonales.cargo == 'BROKER'){
        console.log(datosPersonales);
        obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones WHERE oficina_id = ${datosPersonales.id_oficina} GROUP BY operacion`, resultado => {console.log(resultado); datos = resultado});
    }else{
        console.log(datosPersonales);
        obtenerDatosCallBackQuery(`SELECT operacion,COUNT(*) AS qty FROM vista_operaciones GROUP BY operacion`, resultado => {datos = resultado});
    }

    let data = cargarData(datos);    

    console.log(data);

    options = {
        scales: {
            yAxes:[{
                ticks: {beginAtZero: true}
            }]
        }
    }

    let barVerChart = document.getElementById('chart1').getContext('2d');
    let pieChart = document.getElementById('chart2').getContext('2d');
    dibujarChart(pieChart, 'pie', data);
    dibujarChart(barVerChart, 'bar', data, options);

    let barHorChart = document.getElementById('chart4').getContext('2d');

    options = {
        scales:{
            xAxes: [{
                ticks: {beginAtZero: true}
            }]
        }
    }

    dibujarChart(barHorChart, 'horizontalBar', data, options);

    

    function dibujarChart (variableChart, tipo, data, options) {
        let chart = new Chart(variableChart, {
            type: tipo,
            data: data,
            options: options
        });
    }

    function randomColor (cantidad) {
        let colores = ['#E0323C', '#fdd365', '#fb8d62', '#fd2eb3', '#87258A', '#04ABDF', '#19D613', '#ECE62F', '#FF9D27'];
        let colorAux = [];
        for(let k = 0; k < cantidad; k++){
            let color = colores[Math.floor(Math.random() * colores.length)];
            colorAux.push(color);
        }
        return colorAux;
    }

    function comprobarCargo (idUsuario) {
        let datosPersonales = {id: 0, nombre: '', apellido: '', cargo: 'REGIONAL', id_oficina: 0, nombreOficina: ''};

        obtenerDatosCallBackQuery(`SELECT nombre, apellido FROM usuario WHERE id = ${idUsuario}`, resultado => {datosPersonales.nombre = resultado[0][0]; datosPersonales.apellido = resultado[0][1]});

        obtenerDatosCallBackQuery(`SELECT id, oficina_id FROM vendedor WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'AGENTE';
                datosPersonales.id_oficina = resultado[0][1];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => datosPersonales.nombreOficina = resultado[0][0]);
            }
        });

        if(datosPersonales.id)
            return datosPersonales;
        
        obtenerDatosCallBackQuery(`SELECT id, oficina_id FROM manager WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'MANAGER';
                datosPersonales.id_oficina = resultado[0][1];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => datosPersonales.nombreOficina = resultado[0][0]);
            }
        });

        if(datosPersonales.id)
            return datosPersonales;

        obtenerDatosCallBackQuery(`SELECT id, oficina_id FROM brokers WHERE usuario_id = ${idUsuario}`, resultado => { 
            if(resultado[0]) {
                datosPersonales.id = resultado[0][0];
                datosPersonales.cargo = 'BROKER';
                datosPersonales.id_oficina = resultado[0][1];
                obtenerDatosCallBackQuery(`SELECT dsc_oficina FROM oficina WHERE id = ${datosPersonales.id_oficina}`, resultado => datosPersonales.nombreOficina = resultado[0][0]);
            }
        });

        if(datosPersonales.id)
            return datosPersonales;

        return datosPersonales;
    }

    function cargarData (datos) {
        let data = {
            labels: [],
            datasets: [],
            options: {}
        };

        let datasets = {
            label: [],
            data: [],
            backgroundColor: ['#328EE0', '#51E047', '#E0323C']
        }

        for (dato of datos) {
            data.labels.push([dato[0]]);
            datasets.data.push(dato[1]);
        }
        data.datasets.push(datasets);

        return data;
    }

    /*let datosLine = {
        labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio'], 
        datasets: [{
            label: ['Dataset'],
            data: [65,59,80,81,56,55, 20],
            fill: false,
            borderColor: '#7DADEA',
            lineTension: 0,
            borderCapStyle: 'butt',
            borderWidth: '5',
            pointBackgroundColor: '#E95475',
            pointBorderColor: '#E95475'
        },{
            label: ['SetData'],
            data: [64,45,21,78,18,45,80],
            fill: false,
            borderColor: '#EA867D',
            lineTension: 0,
            borderCapStyle: 'butt',
            borderWidth: '5',
            pointBackgroundColor: '#54C7E9',
            pointBorderColor: '#54C7E9' 
        }]
    };
    
    let optionesLine = {
        scales: {
            yAxes: [{
                stacked: false
            }]
        }
    }

    let pieChart = document.getElementById('chart2').getContext('2d');

    data = {
        labels: ['Venta', 'Alquiler', 'Alq. Adm'],
        datasets: [{
            label: ['Nery'],
            data: [48,56,452],
            backgroundColor: ['#26C8CD', '#D963E5', '#218D59']
        }]
    }

    dibujarChart(pieChart, 'pie', data);

    let doughnutChart = document.getElementById('chart5').getContext('2d');

    dibujarChart(doughnutChart, 'doughnut', data);*/

</script>

</html>
