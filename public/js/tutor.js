//#region  Datatable
 $(document).ready(function () {
    $('#table_tutor').DataTable({
      pageLength:5,
      lengthMenu:[
        [5,10,25,50],[5,10,25,50]
      ],
      ajax: {
        method:'POST',
        url: 'Tutor/getDataTutor',
        dataSrc: 'data'
      },
      columns:[
        {data:'id'},
        {data:'nombre'},
        {data:'telefono'},
        {data:'ocupacion'},
        {data:'editar'},
        {data:'eliminar'}
      ]
      ,
      columnDefs: [
        { 
            targets: [0,1,2,3,4,5], // Aplica solo a la primera columna (id)
            visible: true, // La columna es visible
            className: 'text-center', // Añade una clase CSS específica
            // width: '2%' // Define el ancho de la columna
        },
   
    ],

    language: {
        "lengthMenu": "Mostrar _MENU_ entradas por página",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",  // Cambiar el texto de "Showing 1 to 5 of 21 entries"
        "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
        "infoFiltered": "(filtrado de _MAX_ entradas totales)",
        "paginate": {
            "first": "Primero",
            "last": "Último",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "search": "Buscar:",  // Cambiar el texto del campo de búsqueda
        "zeroRecords": "No se encontraron resultados"
    },
     

    })

  });

  
//#endregion


//#region Modal reutilizable
    $(document).ready(function () {
      const modalTitle = $('#modalTitle ');
      const modalBody = $('#modalFormBody');
      const modalTitleIcon = $('#modalTitleIcon');
      const modalSubmit = $('#modalSubmit');
      const formulario_Tutor = $('#formulario_Tutor')
      const itemID = $('#itemID');
      const alerta = $('#alertAlumno');


      $('#createButton').click(function (e) {
        //Modal Crear 
        modalTitle.text('Crear');
        modalTitleIcon.text('person')
        modalBody.html(`
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="alumno" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre y apellido del alumno eje. Juan Campos"  maxlength="50">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="solo se acepta numeros de 10 digitos"  maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="ocupacion" class="form-label">Ocupacion</label>
                    <input type="text" class="form-control" id="ocupacion" name="ocupacion"  placeholder="Ingresa la occupacuon eje. Ingeniero " maxlength="50">
                </div>
            </div>
        `);
        modalSubmit.text('crear')
        modalSubmit.attr('class','btn btn-primary px-3 py-1 fs-5 ')
      });
      //formulario_Tutor.attr('action','?views=Tutor&action=crearTutor');
      formulario_Tutor.attr('action','Tutor/crearTutor');

      
      //Modal Editar
      $(document).on('click', '#editarButton', function (e) {
      
        modalTitle.text('Editar ');
        modalTitleIcon.text('edit')
        modalBody.html(`

      <div class="col-md-6">
                <div class="mb-3">
                    <label for="alumno" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="nombre y apellido del tutor eje. Juan Campos"  maxlength="50">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="telefono" name="telefono"  placeholder="solo se acepta numeros de 10 digitos"  maxlength="10">
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="ocupacion" class="form-label">Ocupacion</label>
                    <input type="text" class="form-control" id="ocupacion" name="ocupacion"  placeholder="Ingresa la occupacuon eje. Ingeniero " maxlength="50">
                </div>
            </div>
      `);
      
        modalSubmit.text('Actualizar')
//        formulario_Tutor.attr('action','?views=Tutor&action=editarTutor');
        modalSubmit.attr('class','btn btn-success px-3 py-1 fs-5 ')
        formulario_Tutor.attr('action','Tutor/editarTutor');

      });

      //Modal borrar
      $(document).on('click', '#borrarButton', function (e) {
        const id  = $(this).data('id'); 
        modalTitle.text('Eliminar');
        obtenerTutorPorId(id)
        modalTitleIcon.text('delete')
      modalBody.html(`
        
      <div class="alert alert-danger" role="alert">
      Desea Eliminar al tutor: 
      <input type="text" class="form-control" id='nombre' name="nombre" placeholder="Juan Campos" disabled>
              
    </div>
        `)
        modalSubmit.text('eliminar')
        modalSubmit.attr('class','btn btn-danger px-3 py-1 fs-5 ')

       // formulario_Tutor.attr('action','?views=Tutor&action=borrarTutor');
//        itemID.val(id);
formulario_Tutor.attr('action','Tutor/borrarTutor');

      });
      
      $(document).on('click', '#modalSubmit', function (e) { 
        e.preventDefault(); // Evitar el comportamiento predeterminado
        var formAction = formulario_Tutor.attr('action');
        var formData = formulario_Tutor.serialize(); // Serializar los datos del formulario
    




        $.ajax({
            url: formAction,
            type: 'POST',
            data: formData,
            success: function(response) {
                // Lógica de éxito (mostrar mensaje, recargar datos, etc.)
              const responseJson = JSON.parse(response);
                console.log(responseJson); // O manejar con alertas o recargas de tabla
        
                alerta.html(`  
                  <div class="alert ${responseJson.alert} alert-dismissible fade show" role="alert">
                      <strong>${responseJson.message}</strong>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
              `);
                // Detecta cuando el modal se oculta completamente
$('#reusableModal').on('hidden.bs.modal', function () {
  // Recarga la página
  location.reload();
});

// $('#reusableModal').modal('hide');
//                 setInterval(function () {
//                   // Llama a la función de recarga cada 10 segundos (puedes ajustar este valor)
//                   location.reload()
//                }, 10000);
               
            },
            error: function(xhr, status, error) {
                // Lógica de error
                alert('Error: ' + error);

            }
        });

      })

    });

//#endregion


//#region Obtener Id
  function obtenerTutorPorId(id) {
     
      
      const parametro = {
      "id":id
      }
      $.ajax({
        type: "POST",
        url: "Tutor/getByTutor",
        data: parametro,
        success: function (response) {
          const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
          const itemID = $('#itemID');
          const nombreId= $('#nombre');
          const telefonoId = $('#telefono');
          const ocupacionId = $('#ocupacion');

          const { id, nombre,telefono , ocupacion} = responseJson.data ;
          itemID.val(id)
          nombreId.val(nombre);
          telefonoId.val(telefono);
          ocupacionId.val(ocupacion);
        }

      });

    }
//#endregion