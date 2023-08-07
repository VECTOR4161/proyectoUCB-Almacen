var tabla;

//Función que se ejecuta al inicio
function init(){
	
    $("#fecha_inicio").change(listar);
	$("#fecha_fin").change(listar);
	$('#mConsultaC').addClass("treeview active");
    $('#lConsulasC').addClass("active");

    $.post("../ajax/cliente.php?op=5", function(r){
        console.log(r);
	    $("#cliente").html(r);
		$('#cliente').trigger('change.select2');
	});
    listar();
}
$( "#cliente" ).change(function() {
    listar();
});

//Función Listar
function listar()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
    var cliente = $("#cliente").val();
    console.log(cliente);
	tabla=$('#tbllistado').dataTable(
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
					url: '../ajax/consulta.php?op=1',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, cliente: cliente},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 10,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

init();