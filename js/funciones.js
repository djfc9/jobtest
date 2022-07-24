/*funciones que se ejecutan al cargar la pagina y activan eventos*/

$(document).ready(function() {

//alertas en botones
$(".alertas").on('click', function(event){
    event.preventDefault(); // Esto es para prevenir que cargue la pagina siguiente
    alert('Acción en desarrollo..!');
    
});
    /* Aqui especificamos el id del formulario
    tomamos en cuenta el evento keyup para evaluar la cantidad de caracteres en
    el input para hacer la busqueda
    */

    $( "#buscar" ).on( "keyup", function( event ) {
        event.preventDefault(); // Esto es para prevenir que cargue la pagina siguiente
        let buscar = $(this).val();

        //si hay 3 o mas caracteres en el input enviar el formulario y buscar coincidencias
        if(buscar.length >= 3){
            $('#formulario').submit();
        }
        
    });
});



