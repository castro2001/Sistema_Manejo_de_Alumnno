$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "Horario/getDatasHorario",
        success: function (response) {
            const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
            const listStudents = $('#listAlumns');
            let studentItems = ''; // Variable para acumular el HTML
        
            responseJson.data.forEach(item => {
                studentItems += `
                    <div class="col-md-5 shadow p-3 mb-5 bg-body-tertiary rounded" style="min-width:18%">
                        <ul class="list-group">
                            <img src="public/image/subidas/${item.ruta_img}" alt="" height="200">
                            <li class="list-group-item disabled" aria-disabled="true">${item.Alumno}</li>
                            <li class="list-group-item">
                                <button class="btn btn-primary ver-horario" type="button" data-bs-toggle="modal" data-bs-target="#modal_reutilizable_horario" data-id="${item.id}">
                                    Ver Horario
                                </button>
                            </li>
                        </ul> 
                    </div>    
                `;
            });
            
            // Después de construir el HTML, lo establecemos de una vez
            listStudents.html(studentItems);
        }
});
});
// Uso de delegación de eventos para manejar el click en los botones generados dinámicamente
$(document).on('click', '.ver-horario', function() {
    const alumnoId = $(this).data('id');

    // Hacer una nueva petición AJAX para obtener los detalles del alumno
    $.ajax({
        type: "POST",
        url: "Horario/getByHorario",
        data: { id: alumnoId },
        success: function(response) {
            const responseJson = JSON.parse(response); // Convertir a JSON la respuesta
            
    
            // Limpiar cualquier contenido previo en el modal
            $('#modalBodyContent').html(''); 
            
            // Establecer el título del modal
            $('#modalTitle').text(`Datos del alumno ${responseJson.data[0].Alumno}`);  
    
            // Crear la tabla solo una vez
            let tableHtml = `
      <div class="table-responsive">
  <table class="table text-center table-striped table-bordered">
  <thead>
      <tr>
          <th scope="col">Lunes</th> 
          <th scope="col">Martes</th>
          <th scope="col">Miercoles</th>
          <th scope="col">Jueves</th>
          <th scope="col">Viernes</th> 
          <th scope="col">Sabado</th>
          <th scope="col">Domingo</th> 
      </tr>
  </thead>
  <tbody>
      <tr>
          <td class="lunes"></td>
          <td class="martes"></td>
          <td class="miercoles"></td>
          <td class="jueves"></td>
          <td class="viernes"></td>
          <td class="sabado"></td>
          <td class="domingo"></td>
      </tr>
  </tbody>
  </table>
</div>
            `;
    
            // Agregar la tabla al contenido del modal
            $('#modalBodyContent').append(tableHtml);
            
            // Función para obtener el color según la materia
            function getColor(materia) {
                const colorMap = {
                    "Historia": ".bg-secondary-subtle",
                    "Matemáticas": "bg-warning-subtle",
                    "Ciencias": "bg-success-subtle",
                    "Lengua": "bg-primary-subtle",
                    "Programación ": "bg-info-subtle"
                    // Agrega más materias y colores según sea necesario
                };
                return colorMap[materia] || "bg-primary-subtle"; // Color por defecto
            }
    
            // Iterar sobre cada horario del alumno y agregarlo al contenido de la tabla
            responseJson.data.forEach(item => {
                const dia = item.Dia.toLowerCase(); // Convertir el día a minúsculas
                const colorClass = getColor(item.Materia); // Obtener la clase de color
    
                const contenido = `
                    <section class="${colorClass} p-2 shadow rounded mb-3">
                        <div class="d-flex justify-content-center">
                            <span class="material-icons text-danger fs-2 opacity-25">schedule</span> 
                            <h3 class="mx-2" style="font-size: 1.1rem;">${item.Materia}</h3>
                        </div>
                        <time datetime="H:m" style="font-size: 15px;">${item.Inicio} - ${item.Fin}</time>
                    </section>
                `;
    
                // Agregar el contenido a la celda correspondiente
                $(`.${dia}`).append(contenido);
            });
    
            // Mostrar el modal
            $('#modal_reutilizable_horario').modal('show');
        },
        error: function(xhr, status, error) {
            console.error("Error en la solicitud:", status, error);
        }
    });
    
    
});


