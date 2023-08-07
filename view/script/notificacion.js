

function listar()
{
    alert("Entra al metodo");
    var menu = document.getElementById("menu-notificaciones");
    $.ajax({
        url: "../ajax/notificacion.php?op=0",
        type: "POST", 
        dataType: "JSON", // el tipo de datos que esperas recibir del servidor
        success: function(response) 
        {
            let text = "";
            response.forEach(myFunction);

            function myFunction(item) 
            {
                
             text +=' <a href="#!" class="text-reset ' +
                    '  notification-item">' +
                    '    <div class="d-flex">' +
                    '      <div class="flex-shrink-0 me-3">'+
                    '           <span class="avatar-title bg-success rounded-circle font-size-16">'+
                    '              <i class="bx bx-badge-check"></i>'+
                    '           </span>'+
                    '        </div>'+
                    '         <div class="flex-grow-1">'+
                    '            <h6 class="mb-1">'+item[0]+'</h6>'+
                    '             <div class="font-size-13'+
                    '                text-muted">'+
                    '                <p class="mb-1">'+
                    '                   '+item[1]+'</p>'+               
                    '            </div>'+
                    '        </div>'+
                    '    </div>'+
                    ' </a>'
            }
            menu.innerHTML(text);
        }
    });
}

listar();