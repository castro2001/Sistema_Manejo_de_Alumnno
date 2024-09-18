//#region  Datatable Mosrar dinammicamente
$(document).ready(function () {
  $('#table_materia').DataTable({
    pageLength:5,
    lengthMenu:[
      [5,10,25,50],[5,10,25,50]
    ],
    ajax: {
      method:'POST',
      url: 'Materia/getDataMateria',
      dataSrc: 'data'
    },
    columns:[
      {data:'id'},
      {data:'nombre'},
      {data:'docente'},
      {data:'descripcion'},
      {data:'editar'},
      {data:'eliminar'}
 
    ],
    
    columnDefs: [
      { 
          targets: [0,1,2,3,4,5], // Aplica solo a la primera columna (id)
          visible: true, // La columna es visible
          className: 'text-center', // Añade una clase CSS específica
          // width: '2%' // Define el ancho de la columna
      }
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

  });
});
//#endregion


//#region  Modal Dinamico Materia

$(document).ready(function () {
  const modalTitle = $('#modalTitleMateria ');
  const modalBody = $('#modalFormBodyMateria');
  const modalTitleIcon = $('#modalTitleIcon');
  const modalSubmit = $('#modalSubmitMateria');
  const formularioMateria = $('#formulario_Materia')
  const alerta = $('#alert');


  $('#createButtonMateria').click(function (e) {
    //Modal Crear 
    modalTitle.text('Crear');
    modalTitleIcon.text('person')
    modalBody.html(`
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="materia" class="form-label">Materia</label>
                    <input type="text" class="form-control" id="materia" name="materia" placeholder="Ciencia" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}$" maxlength="50">
                    <div id="error_materia"></div>
                    </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="docente" class="form-label">Docente</label>
                    <input type="text" class="form-control" id="docente" name="docente"  placeholder="Marcos" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ]{1,50}$" maxlength="50">
                     <div  id="error_docente"></div>

                    </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"  placeholder="Lo que va a tratar la materia " pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,250}$" maxlength="250">
                   <div id="error_descripcion"></div>

                    </div>
            </div>
    `);
    modalSubmit.text('crear')
    modalSubmit.attr('class','btn btn-primary px-3 py-1 fs-5 ')
    formularioMateria.attr('action','Materia/crearMateria');
  });


  //Modal Editar
  $(document).on('click', '#editarButtonMateria', function (e) {
  
    modalTitle.text('Editar ');
    modalTitleIcon.text('edit')
    modalBody.html(`
             <div class="col-md-6">
                <div class="mb-3">
                    <label for="materia" class="form-label">Materia</label>
                    <input type="text" class="form-control" id="materia" name="materia" placeholder="Ciencia" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}$" maxlength="50">
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="docente" class="form-label">Docente</label>
                    <input type="text" class="form-control" id="docente" name="docente"  placeholder="Marcos" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}$" maxlength="50">
                </div>
            </div>

            <div class="col-md-12">
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion"  placeholder="Lo que va a tratar la materia " pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,250}$" maxlength="250">
                </div>
            </div>

  `);
  
    modalSubmit.text('Actualizar')
    modalSubmit.attr('class','btn btn-success px-3 py-1 fs-5 ')
    formularioMateria.attr('action','Materia/editarMateria');
  });

  //Modal borrar
  $(document).on('click', '#borrarButtonMateria', function (e) {
      const id  = $(this).data('id'); 
  
      modalTitle.text('Eliminar');
      modalTitleIcon.text('delete')
      modalBody.html(`
      <div class="alert alert-danger" role="alert">
    <label for="materia" class="form-label">Desea eliminar la Materia: </label>
                    <input type="text" class="form-control" disabled id="materia" >
                 
      </div>
      `)
      modalSubmit.text('Eliminar')
      modalSubmit.attr('class','btn btn-danger px-3 py-1 fs-5 ')

      formularioMateria.attr('action','Materia/borrarMateria');
      

  });

  //Ennvio de fformulario
  $(document).on('click', '#modalSubmitMateria', function (e) { 
    e.preventDefault(); // Evitar el comportamiento predeterminado

    var formAction = formularioMateria.attr('action');
    var formData = formularioMateria.serialize(); // Serializar los datos del formulario
    if (formAction.includes('crearMateria') || formAction.includes('editarMateria') ) {
      const materia = $('#materia').val();
      const docente = $('#docente').val();
      const descripcion = $('#descripcion').val();
    
  
      const materiaValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ 12]+$/.test(materia);
      const docenteValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/.test(docente);
      const descripcionValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]+$/.test(descripcion);
  
      const camposLlenos = materia && docente && descripcion;
  
      if (!camposLlenos) {
     
        alerta.html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Rellene todos los campos</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `);
          $('#materia').attr('class', ' form-control is-invalid')
          $('#docente').attr('class', ' form-control is-invalid')
          $('#descripcion').attr('class', ' form-control is-invalid')
          return
      }
  
  
      if(materiaValidate && docenteValidate && descripcionValidate){
        // alert('enviado a php')
        $('#materia').attr('class', ' form-control is-valid')
        $('#docente').attr('class', ' form-control is-valid')
        $('#descripcion').attr('class', ' form-control is-valid')
       
      }else{
        alerta.html(`
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Solo el campo materia tiene aceptado  1 a 2 , letras y espacios, y los demas campos no se permiten números ni caracteres especiales.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `);
        $('#materia').attr('class', ' form-control is-invalid')
        $('#docente').attr('class', ' form-control is-invalid')
        $('#descripcion').attr('class', ' form-control is-invalid')
     
      }      
    }
    
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
          $('#reusableModal').modal('hide');
     
      },
      error: function(xhr, status, error) {
          // Lógica de error
          alert('Error: ' + error);

      }
  });
 
    
  })

    

});





//#endregion

//#region Funciones 
function obtenerMateriaPorId(id) {
  const parametro = {"id":id }
  $.ajax({
    type: "POST",
    url: "Materia/getByMateria",
    data: parametro,
    success: function (response) {
      // Convertir la respuesta a JSON
      const responseJson = JSON.parse(response);
      const itemID = $('#itemID');
      const nombreId= $('#materia');
      const docenteId = $('#docente');
      const descripcionId = $('#descripcion');

      const { id, nombre,docente , descripcion} = responseJson.data ;
      itemID.val(id)
      nombreId.val(nombre);
      docenteId.val(docente);
      descripcionId.val(descripcion);
    
    }
  });

}
//#endregion


//#region  Validacionn
