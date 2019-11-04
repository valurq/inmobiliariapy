function incluirJQuery(){
    var script=document.createElement('script');
    script.src="JS/jquery-3.4.0.js";
    document.head.appendChild(script);
}
function seleccionarFila(id){
    if((document.getElementById('seleccionado').value!='')&&(document.getElementById('seleccionado').value!=0)){
        var anterior=document.getElementById('seleccionado').value;
        document.getElementById(anterior).style.backgroundColor="white";
    }
    document.getElementById(id).style.backgroundColor= "#669ee8";
    document.getElementById("seleccionado").value=id;
}
//FUNCION QUE ES LLAMADA POR EL CAMPO DE BUSQUEDA PARA REALIZAR CONSULTAS A LA BASE DE DATOS Y MOSTRAR EN LA TABLA CORRESPONDIENTE
//PARAMETROS : OBJETO (EL INPUT BUSCADOR)   ;  TABLA: TABLA CORRESPONDIENTE A LA BASE DE DATOS DONDE SE REALIZARA LA BUSQUEDA
function buscarTablaPaneles(camposResultado,valor,tabla,campo) {
    $.post("Parametros/buscador.php", {camposResultado: camposResultado ,dato:valor,tabla:tabla,campoBusqueda:campo}, function(resultado) {
        //$("#resultadoBusqueda").html(resultado);
        var i;
        //console.log(resultado);
        $("#datosPanel tr").remove();
        resultado=JSON.parse(resultado);
        for(i=1 ; i<resultado.length;i++){
            cargarTabla(resultado[i],"datosPanel");
        }
     });
}

function cargarTabla(datos,tablaId){
    var i,columna="";
    var fila=document.createElement('tr');
    fila.id=datos[0];
    fila.addEventListener('click',function() {seleccionarFila(datos[0])} );
    document.getElementById(tablaId).appendChild(fila);
    for( i=1;i<datos.length;i++){
        console.log(datos[i]);
        if(datos[i]!="null"|| datos[i]!=null){
            columna=columna.concat("<td>"+datos[i]+"</td>");
        }else{
            columna=columna.concat("<td>  </td>");
        }
    }
    console.log(columna);
    document.getElementById(datos[0]).innerHTML=columna;
}
function eliminar(tabla){
   var sel=document.getElementById('seleccionado').value;
   if((sel=="")||(sel==' ')||(sel==0)){
       popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER ELIMINARLO");
   }else {
           //metodo,url destino, nombre parametros y valores a enviar, nombre con el que recibe la consulta
           $.post("Parametros/eliminador.php", {id : sel , tabla : tabla}, function(msg) {
                console.log(msg);
                if(msg==0){
                   document.getElementById('seleccionado').value="";
                   location.reload();
                //COD 1451 = CONSTRAINT ERROR
                }else if(msg==1451){
                   popup('Error',"OTROS REGISTROS UTILIZAN ESTOS DATOS")
                }else{
                   popup('Error',"ERROR EN LA ELIMINACION DEL REGISTRO");
                }
            });
   }
}
function editar(direccion){
    var sel=document.getElementById('seleccionado').value;
   // alert(sel)
    if((sel=="")||(sel==' ')||(sel==0)){
        popup('Advertencia',"DEBE SELECCIONAR UN ELEMENTO PARA PODER Editarlo");
    }else {
        document.getElementById("formularioMultiuso").action=direccion;
        document.getElementById("formularioMultiuso").submit();
   }
}

/*function editar(pagina){
    document.getElementById("formularioMultiuso").action=pagina;
    document.getElementById("formularioMultiuso").submit();
}*/
//FUNCION PARA LEVANTAR MENSAJES EN PANTALLA
function popup(simbolo,mensaje){
    if(!(document.getElementById("popup"))){
        crearPopup();
    }
    document.getElementById('popup').style.display="block";
    document.getElementById("imagenPopup").style.backgroundImage="url('"+seleccionarImagen(simbolo)+"')";
    document.getElementById("mensajePopup").value=mensaje;

}
function seleccionarImagen(identificador){
    var devolver;
    switch (identificador) {
        case 'Error':
            devolver="Imagenes/error.png"
            break;
        case 'Advertencia':
            devolver="Imagenes/warning.png"
            break;
        case 'Informacion':
            devolver="Imagenes/info.png"
            break;
        default:
            devolver='';
    }
    return devolver;
}
function crearPopup(){
    var pop=document.createElement('div');
    pop.id="popup";
    var popImg=document.createElement('div');
    popImg.id="imagenPopup";
    var popMsj=document.createElement('textarea');
    popMsj.id="mensajePopup";
    var popBoton=document.createElement('input');
    popBoton.type='Button';
    popBoton.id="btPopupAceptar"
    popBoton.value='Aceptar';
    popBoton.addEventListener( 'click', cerrarPopup);
    document.body.appendChild(pop);
    document.getElementById('popup').appendChild(popImg);
    document.getElementById('popup').appendChild(popMsj);
    document.getElementById('popup').appendChild(popBoton);
}
function cerrarPopup(){
    document.getElementById('popup').style.display="none";
}
function popupC(simbolo,mensaje,funcionConfirmar,parametro){
    if(!(document.getElementById("popupConfirmacion"))){
        crearPopupConfirmacion();
    }
    document.getElementById('popupConfirmacion').style.display="block";
    document.getElementById("imagenPopupC").style.backgroundImage="url('"+seleccionarImagen(simbolo)+"')";
    document.getElementById("mensajePopupC").value=mensaje;
    //document.getElementById("btPopupAceptar").addEventListener("click",function(){funcfuncionConfirmar(parametro)});
    document.getElementById("btPopupAceptarC").addEventListener("click",function(){funcionConfirmar(parametro) ; cerrarPopupC();});
}
function cerrarPopupC(){
    document.getElementById('popupConfirmacion').style.display="none";
}
function crearPopupConfirmacion(){
    var pop=document.createElement('div');
    pop.id="popupConfirmacion";
    var popImg=document.createElement('div');
    popImg.id="imagenPopupC";
    var popMsj=document.createElement('textarea');
    popMsj.id="mensajePopupC";
    var popBoton=document.createElement('input');
    popBoton.type='Button';
    popBoton.id="btPopupAceptarC"
    popBoton.value='Aceptar';
    //popBoton.addEventListener( 'click', aceptarPopup);
    var popBotonC=document.createElement('input');
    popBotonC.type='Button';
    popBotonC.id="btPopupCancelarC"
    popBotonC.value='Cancelar';
    popBotonC.addEventListener( 'click', cerrarPopupC);
    document.body.appendChild(pop);
    document.getElementById('popupConfirmacion').appendChild(popImg);
    document.getElementById('popupConfirmacion').appendChild(popMsj);
    document.getElementById('popupConfirmacion').appendChild(popBoton);
    document.getElementById('popupConfirmacion').appendChild(popBotonC);
}
//incluirJQuery();


/*
SECCION VALIDACIONES
*/

function esVacio(objeto){
    var resultado;
    ((objeto.value!="")&&(objeto.value!=" ")&&((objeto.value).strlenght>0))?resultado =true:resultado= false ;
    return resultado;
}

function crearAcceso(dir,titulo){

  var dire=document.createElement("a");
  dire.className="url";
  dire.id="a-"+cont;
  dire.href=dir;
  dire.target="_blank";

  var titu=document.createElement("div");
  titu.className="titulo-opcion-informes";
  titu.id="b-"+cont;
  titu.innerText=titulo;

  dire.appendChild(titu);

  document.getElementById('menu-items').appendChild(dire);
  document.getElementById("a-"+cont).appendChild(titu);
  cont++;
}

function crearMenu(dir,imagen,titulo,permiso){

    var dire=document.createElement("a");
    dire.className="url";
    dire.id="a-"+cont;
    dire.href=dir;
    dire.target="frame-trabajo"

    var item=document.createElement("div");
    item.className="menu-opcion";
    item.id="b-"+cont;

    var icono=document.createElement("div");
    icono.className="icono-opcion";
    icono.id="c-"+cont;
    icono.style.backgroundImage=imagen;

    var titu=document.createElement("div");
    titu.className="titulo-opcion";
    titu.id="d-"+cont;
    titu.innerText=titulo;
    if(permiso=="NO"){
        dire.href="about:blank";
        item.className+=" desactivado";
    }
    dire.appendChild(item);
    item.appendChild(icono);
    item.appendChild(titu);
    document.getElementById('menu-items').appendChild(dire);
    document.getElementById("a-"+cont).appendChild(item);
    document.getElementById("b-"+cont).appendChild(icono);
    document.getElementById("b-"+cont).appendChild(titu);
    cont++;
}

function cargarCampos(camposform,valores){
    var campo;
    //camposform='"'+camposform+'"';
//    alert(camposform);
//    alert(valores)
    camposform=camposform.split(",");
    valores=valores.split(",");
    for(var i=0;i<camposform.length;i++){
        campo=document.getElementById(camposform[i]);
        console.log(camposform[i]+" ->"+valores[i]);
        //campo=document.getElementById("frame-trabajo").contentWindow.document.getElementById(camposform[i]);
        if((campo.tagName=="INPUT")||(campo.tagName=="TEXTAREA")){
            campo.value=valores[i];
        }
    }
}
