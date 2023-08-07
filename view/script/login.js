$("#frmAcceso").on('submit',function(e)
{
	e.preventDefault();
    logina=$("#logina").val();
    clavea=$("#clavea").val();

    $.post("../ajax/usuario.php?op=5",
        {"logina":logina,"clavea":clavea},
        function(data)
            {
                console.log(data);
                if (data!=0)
                {
                    $(location).attr("href","escritorio.php");            
                }
                else
                {
                    Swal.fire({
                        type: 'error',
						title: 'Error',
                        text: 'Usuario y/o Password incorrectos.',
                        footer: 'Cualquier información consulte con el administrador.'
                    });
                }
            });
})