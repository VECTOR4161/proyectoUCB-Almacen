var tabla;

//Función que se ejecuta al inicio
function init(){

	//Para validación
	$('#nombre').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú');
	$('#apellidop').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú');
	$('#apellidom').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú');
	$('#num_documento').validacion(' abcdefghijklmnñopqrstuvwxyz-0123456789');
	$('#direccion').validacion(' abcdefghijklmnñopqrstuvwxyzáéíóú,.#º0123456789');
    $('#tipo_documento').select2();

	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#imagenmuestra").hide();
}

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#apellidop").val("");
	$("#apellidom").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#email").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idproveedor").val("");
	$("#tipo_documento").val(1);
	$('#categoria').trigger('change.select2');
	$("#imagenmuestra").hide();
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').DataTable(
        {
            "lengthMenu": [ 10, 25, 50, 75, 100 ],//mostramos el menú de registros a revisar
            "Processing": true,//Activamos el procesamiento del datatables
            "ServerSide": true,//Paginación y filtrado realizados por el servidor
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            },
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [		          
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdf'
                    ],
            "ajax":
                    {
                        url: '../ajax/proveedor.php?op=0',
                        type : "get",
                        dataType : "json",						
                        error: function(e){
                            console.log(e.responseText);	
                        }
                    },
            "Destroy": true,
            "iDisplayLength": 10,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        });
}
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/proveedor.php?op=1",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {   
			mensaje=datos.split(":");
			if(mensaje[0]=="1"){               
			Swal.fire(
				'Mensaje de Confirmación',
				mensaje[1],
				'success'

				);           
	          mostrarform(false);
	          tabla.ajax.reload();
			}
			else{
				Swal.fire({
					type: 'error',
					title: 'Error',
					text: mensaje[1],
					footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
				});
			}
	    }

	});
	limpiar();
}

function mostrar(idproveedor)
{
	$.post("../ajax/proveedor.php?op=4",{idproveedor : idproveedor}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);
        
		$("#nombre").val(data.personanombre);
		$("#apellidop").val(data.personaap);
		$("#apellidom").val(data.personaam);
		$("#tipo_documento").val(data.personatipo_documento);
		$('#categoria').trigger('change.select2');
		$("#num_documento").val(data.personanum_documento);
		$("#direccion").val(data.personadireccion);
		$("#email").val(data.personaemail);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../file/proveedores/"+data.personaimagen);
		$("#imagenactual").val(data.personaimagen);
		$("#idproveedor").val(data.idproveedor);
 	});
}

//Función para desactivar registros
function desactivar(idproveedor)
{
	swal.fire({
		title: 'Mensaje de Confirmación',
		text: "¿Desea desactivar el Registro?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Desactivar'
	}).then((result) => {
		if (result.value) 
		{
			$.post("../ajax/proveedor.php?op=2", {idproveedor : idproveedor}, function(e){
				mensaje=e.split(":");
					if(mensaje[0]=="1"){  
						swal.fire(
							'Mensaje de Confirmación',
							mensaje[1],
							'success'
						);  
						tabla.ajax.reload();
					}	
					else{
						Swal.fire({
							type: 'error',
							title: 'Error',
							text: mensaje[1],
							footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
						});
					}			
        	});	
		}
	});   
}

//Función para activar registros
function activar(idproveedor)
{
	swal.fire({
		title: 'Mensaje de Confirmación',
		text: "¿Desea activar el Registro?",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		cancelButtonText: 'Cancelar',
		confirmButtonText: 'Activar'
	}).then((result) => {
		if (result.value) {
			$.post("../ajax/proveedor.php?op=3", {idproveedor : idproveedor}, function(e){
                console.log(e);
				mensaje=e.split(":");
					if(mensaje[0]=="1"){  
						swal.fire(
							'Mensaje de Confirmación',
							mensaje[1],
							'success'
						);  
						tabla.ajax.reload();
					}	
					else{
						Swal.fire({
							type: 'error',
							title: 'Error',
							text: mensaje[1],
							footer: 'Verifique la información de Registro, en especial que la información no fué ingresada previamente a la Base de Datos.'
						});
					}			
        	});	
		}
	}); 
}

init();