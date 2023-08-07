

function verificarUsuario()
{

    var usuario = document.getElementById("usuarioLogin").value;
    alert("si entra");
    $.ajax({
        url: "../ajax/usuario.php?op=8",
        type: "POST", 
        data: 
        { 
            login: usuario
        },
        dataType: "JSON",
        success: function(response) 
        {
            if(response[0]==1)
            {
                $(location).attr("href","login.php");
            }
            else
            {
                alert("el usuario no existe");
            }
        }
    });
}

