//#region  Datatable Mosrar dinammicamente
$(document).ready(function () {
  $('#table_materia').DataTable({
    pageLength:5,
    lengthMenu:[
      [5,10,25,50],[5,10,25,50]
    ],
    ajax: {
      method:'POST',
      url: 'AgregarAlumno/getDataAgregarAlumno',
      dataSrc: 'data'
    },
    columns:[
      {data:'id'},
      {data:'Alumno'},
      {data:'Dia'},
      {data:'Materia'},
      {data:'Inicio'},
      {data:'Fin'},
      {data:'editar'},
      {data:'eliminar'}
 
    ] ,
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

  });
});
//#endregion
///modal_reutilizable_materia_alumno


//#region Modal reutilizable
$(document).ready(function () {
const modalTitle = $('#modalTitle ');
const modalBody = $('#modalFormBody');
const modalTitleIcon = $('#modalTitleIcon');
const modalSubmit = $('#modalSubmit');
const formulario_Tutor = $('#formulario_crear_agregarAM')
const itemID = $('#itemID');
const alerta = $('#alertAgregarAlumnos');


$('#createButtonAgregarAlumnoMateria').click(function (e) {
  //Modal Crear 
  modalTitle.text('Crear');
  modalTitleIcon.text('person')
  reloadSelect()
  modalBody.html(`
    <div class="col-12">
      <label for="select_alumno" class="form-label">Alumos</label>
      <select class="form-select" id="select_alumno" name="select_alumno" ></select>
    </div>

    <div class="col-12">
      <label for="select_dia" class="form-label">Día de la semana</label>
      <select class="form-select" id="select_dia" name="select_dia" >
      <option value="0" >Seleccione el dia </option>
      <option value="Lunes">Lunes</option>
       <option value="Martes">Martes</option>
        <option value="Miercoles">Miercoles</option>
         <option value="Jueves">Jueves</option>
          <option value="Viernes">Viernes</option>
           <option value="Sabado">Sabado</option>
            <option value="Domingo">Domingo</option>
      </select>
      
    </div>

    <div class="col-12">
      <label for="select_materia" class="form-label">Materia</label>
      <select class="form-select " id="select_materia" name="select_materia" ></select>
    </div>

    <div class=" col-12 mb-3">
      <label for="hora_inicio" class="form-label">Hora Inicio</label>
      <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" >
    </div>

    <div class="col-12 mb-3">
      <label for="hora_fin" class="form-label">Hora Fin</label>
      <input type="time" class="form-control" id="hora_fin" name="hora_fin" >
    </div>


  `);
  modalSubmit.text('crear')
  modalSubmit.attr('class','btn btn-primary px-3 py-1 fs-5 ')
  formulario_Tutor.attr('action','AgregarAlumno/crearAgregarAlumno');
});


//Modal Editar
$(document).on('click', '#editarButtonAgregarAlumnoMateria', function (e) {
  const id  = $(this).data('id');   
  itemID.val(id)  
  obtenerAlumnoPorId(id);
  modalTitle.text('Editar ');
  modalTitleIcon.text('edit')
  modalBody.html(`
        <div class="col-12">
      <label for="select_alumno" class="form-label">Alumos</label>
      <select class="form-select" id="select_alumno" name="select_alumno" ></select>
    </div>

    <div class="col-12">
      <label for="select_dia" class="form-label">Día de la semana</label>
   <select class="form-select" id="select_dia" name="select_dia" >
      <option value="0" >Seleccione el dia </option>
      <option value="Lunes">Lunes</option>
       <option value="Martes">Martes</option>
        <option value="Miercoles">Miercoles</option>
         <option value="Jueves">Jueves</option>
          <option value="Viernes">Viernes</option>
           <option value="Sabado">Sabado</option>
            <option value="Domingo">Domingo</option>
      </select>    </div>

    <div class="col-12">
      <label for="select_materia" class="form-label">Materia</label>
      <select class="form-select " id="select_materia" name="select_materia" ></select>
    </div>

    <div class=" col-12 mb-3">
      <label for="hora_inicio" class="form-label">Hora Inicio</label>
      <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" >
    </div>

    <div class="col-12 mb-3">
      <label for="hora_fin" class="form-label">Hora Fin</label>
      <input type="time" class="form-control" id="hora_fin" name="hora_fin" >
    </div>


  `);

  modalSubmit.text('Actualizar')
//        formulario_Tutor.attr('action','?views=Tutor&action=editarTutor');
  modalSubmit.attr('class','btn btn-success px-3 py-1 fs-5 ')
  formulario_Tutor.attr('action','AgregarAlumno/editarAgregarAlumno');

});

//Modal borrar
$(document).on('click', '#borrarButtonAgregarAlumnoMateria', function (e) {
  const id  = $(this).data('id');     
  itemID.val(id)  

  obtenerAlumnoPorId(id);
  modalTitle.text('Eliminar');
  modalTitleIcon.text('delete')
modalBody.html(`
  
    <div class="alert alert-danger" role="alert">
    <h5>Desea Eliminar al Horario de: </h5>
    <span class="fw-semibold mx-2" id="alumno"></span>
 
    </div>
  `)
  modalSubmit.text('eliminar')
  modalSubmit.attr('class','btn btn-danger px-3 py-1 fs-5 ')
  formulario_Tutor.attr('action','AgregarAlumno/borrarAgregarAlumno');

});

$(document).on('click', '#modalSubmit', function (e) { 
  e.preventDefault(); // Evitar el comportamiento predeterminado
  var formAction = formulario_Tutor.attr('action');
  var formData = formulario_Tutor.serialize(); // Serializar los datos del formulario

  if (formAction.includes('crearAgregarAlumno') || formAction.includes('editarAgregarAlumno')) {
    const selectAlumno = $('#select_alumno').val();
    const selectHorario = $('#select_dia').val();
    const selectMateria = $('#select_materia').val();
    const horaInicio = $('#hora_inicio').val();
    const horaFin = $('#hora_fin').val();
    // Validar selección de tutor
    if (selectAlumno != 0 & selectHorario != 0  && selectMateria != 0 ) {
      alerta.html();
    } else{
      alerta.html(`  
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Debe escoger una opcion </strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `);
    }

    if (selectAlumno != 0) {
      $('#select_alumno').attr('class', 'form-control is-valid');
    } else {
      $('#select_alumno').attr('class', 'form-control is-invalid');
    }

  if (selectHorario != 0) {
  $('#select_dia').attr('class', 'form-control is-valid');
  } else {
  $('#select_dia').attr('class', 'form-control is-invalid');
  }

  if (selectMateria != 0) {
  $('#select_materia').attr('class', 'form-control is-valid');
  } else {
  $('#select_materia').attr('class', 'form-control is-invalid');
  }

// Verificar si el campo está vacío



if (horaInicio === '' && horaFin === '') {
alert('Por favor, ingresa la hora de inicio y la hora de fin.');
$('#hora_inicio').attr('class', 'form-control is-invalid'); // Añadir clase para mostrar error
$('#hora_fin').attr('class', 'form-control is-invalid');
return false; // Detener el envío del formulario
} else {
$('#hora_inicio').attr('class', 'form-control is-valid'); // Marcar como válido

$('#hora_fin').attr('class', 'form-control is-valid'); // Marcar como válido
}

// Verificar que la hora de fin sea mayor que la hora de inicio
if (horaInicio >= horaFin) {
alert('La hora de fin debe ser mayor que la hora de inicio.');
$('#hora_inicio').attr('class', 'form-control is-invalid');
$('#hora_fin').attr('class', 'form-control is-invalid');
return false;
} else {
$('#hora_fin').attr('class', 'form-control is-valid');
}




  }

  $.ajax({
    url: formAction,
    type: 'POST',
    data: formData ,
  
    success: function (response) {
        const responseJson = JSON.parse(response);
        
        alerta.html(`  
            <div class="alert ${responseJson.alert} alert-dismissible fade show" role="alert">
                <strong>${responseJson.message}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
// Detectar el cierre del modal
$('#modal_reutilizable_materia_alumno').on('hidden.bs.modal', function () {
  // 
  setTimeout(function(){
    location.reload(); // Recargar la página
  },1000)
});
    },
    error: function (xhr, status, error) {
        alert('Error: ' + error);
    }
  });


})

});


function obtenerAlumnoPorId(id) {
const parametro = {"id": id}
$.ajax({
    type: "POST",
    url: "AgregarAlumno/getDataByAgregarAlumno",
    data: parametro,
    success: function (response) {
        const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
        console.log(responseJson);
        
        //Variables de Formulario
        const horaInicio = $('#hora_inicio');
        const horaFin = $('#hora_fin')
        const selectHorario = $('#select_dia');

       const {Alumno_id,Dia,Alumno, Materia,Materia_id,Inicio,Fin} = responseJson.data;
     $('#materia').text(Materia);
     $('#alumno').text(Alumno);
     selectHorario.val(Dia)

        horaInicio.val(Inicio)
        horaFin.val(Fin)
        reloadSelect(Alumno_id,Materia_id)
    }
});
}

function reloadSelect(Alumno_id, Materia_id) {
 
$.ajax({
  method: 'POST',
  url: 'AgregarAlumno/getDataAlumnoMMateriaHorario',
  success: function (response) {
    const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
    const selectAlumno = $('#select_alumno');
    const selectMateria = $('#select_materia');
    
    selectAlumno.empty();
   
    selectMateria.empty();

    selectAlumno.append('<option value="0" >Seleccione un alumno</option>');
    // selectHorario.append('<option value="0" >Seleccione el dia </option>');
    selectMateria.append('<option value="0" >Seleccione la materia</option>');

    // Append alumnos
    responseJson.data.Alumnos.forEach(item => {
      selectAlumno.append(`<option value="${item.id}">${item.Alumno}</option>`);
    });
 // Append alumnos
 responseJson.data.Materias.forEach(item => {
  selectMateria.append(`<option value="${item.Materia_id}">${item.Materia}</option>`);
});


// Set the selected alumno
        if (Alumno_id) {
      const selectedAlumno = responseJson.data.Alumnos.find(item => item.id == Alumno_id);
      if (selectedAlumno) {
        selectAlumno.append(`<option value="${selectedAlumno.id}" selected>${selectedAlumno.Alumno}</option>`);
      }
    }
 


    // Set the selected materia
    if (Materia_id) {
      const selectedMateria = responseJson.data.Materias.find(item => item.Materia_id == Materia_id);
      if (selectedMateria) {
        selectMateria.append(`<option value="${selectedMateria.Materia_id}" selected>${selectedMateria.Materia}</option>`);
      }
    }
  }
});
}
