$(document).ready(function () {
    $('#table_alumno').DataTable({
        pageLength:5,
      lengthMenu:[
        [5,10,25,50],[5,10,25,50]
      ],
    
      ajax: {
        method:'POST',
        url: 'Alumno/getDataStudent',
        dataSrc: 'data'
      },
      columns:[
        {data:'id'},
        {data:'Alumno'},
        {data:'fecha_nacimiento'},
        {data:'direccion'},
        {data:'Informacion'},
        {data:'status'},
        {data:'editar'},
        {data:'eliminar'},
      ],
      columnDefs: [
        { 
            targets: [0,1,2,3,4,5,6], // Aplica solo a la primera columna (id)
            visible: true, // La columna es visible
            className: 'text-center', // Añade una clase CSS específica
            // width: '2%' // Define el ancho de la columna
        },
        {
            targets: 5, // Aplica solo a la columna 'status'
          render: function(data, type, row) {
                // Personaliza el contenido: cambia el estilo dependiendo del valor del status
                if (data === 1) {
                    return '<span class="px-2 py-2 rounded text-success fw-semibold">Activo</span>';
                } else {
                    return '<span class="px-2 py-2 rounded text-danger fw-semibold">Inactivo</span>';
                }
            },
            
            className: 'text-bold' // Aplica una clase CSS personalizada
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
    }


    });
  });


//#region  Modal Dinamico
$(document).ready(function () {
    const modalTitle = $('#modalTitle ');
    const modalBody = $('#modalFormBody');
    const modalTitleIcon = $('#modalTitleIcon');
    const modalSubmit = $('#modalSubmit');
    const formulario_Tutor = $('#formulario_Alumno')
   
    const alerta = $('#alertAlumno');

    $('#createButtonAlumno').click(function (e) {
       reloadSelect()
      //Modal Crear 
      modalTitle.text('Crear');
      modalTitleIcon.text('person')
      modalBody.html(`
            <div class="col-md-6">
                    <div class="mb-3">
                        <label for="alumno" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="alumno" name="alumno" placeholder="Juan Campos" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}$" maxlength="50" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="1234567890"maxlength="10" >
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Av. Principal 123" pattern="^[a-zA-Z0-9\s,.#-]{1,100}$" maxlength="100">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="escuela_procedencia" class="form-label">Escuela de Procedencia</label>
                        <input type="text" class="form-control" id="escuela_procedencia" name="escuela_procedencia" placeholder="Escuela Ejemplo" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]{1,50}$" maxlength="50">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label for="situacion_academica" class="form-label">Situación Académica</label>
                        <input type="text" class="form-control" id="situacion_academica" name="situacion_academica" placeholder="Situación Ejemplo" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]{1,50}$" maxlength="50">
                    </div>
                </div
                >
                <div class="col-12">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Agregar imagen</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="select_tutor" class="form-label">Tutor</label>
                        <select class="form-select" id="select_tutor" name="select_tutor" aria-label="Default select example">
                            <!-- Opciones del select -->
                        </select>
                    </div>
                </div>
      `);
      modalSubmit.text('crear')
      modalSubmit.attr('class','btn btn-primary px-3 py-1 fs-5 ')
    });
    formulario_Tutor.attr('action','Alumno/crearAlumno');


    //Modal Editar
    $(document).on('click', '#editarButtonAlumno', function (e) {
        const id  = $(this).data('id');     
         obtenerAlumnoPorId(id);
    console.log(id);


      modalTitle.text('Editar ');
      modalTitleIcon.text('edit')
      modalBody.html(`
          <div class="col-md-6">
                    <div class="mb-3">
                        <label for="alumno" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="alumno" name="alumno" placeholder="Juan Campos" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]{1,50}$" maxlength="50" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Av. Principal 123">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" placeholder="1234567890" pattern="^[0-9]{10}$" maxlength="10" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Direccion</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Av. Principal 123" pattern="^[a-zA-Z0-9\s,.#-]{1,100}$" maxlength="100">
                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="escuela_procedencia" class="form-label">Escuela de Procedencia</label>
                        <input type="text" class="form-control" id="escuela_procedencia" name="escuela_procedencia" placeholder="Escuela Ejemplo" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]{1,50}$" maxlength="50">
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="mb-3">
                        <label for="situacion_academica" class="form-label">Situación Académica</label>
                        <input type="text" class="form-control" id="situacion_academica" name="situacion_academica" placeholder="Situación Ejemplo" pattern="^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s,.]{1,50}$" maxlength="50">
                    </div>
                </div
                >
                <div class="col-12">
     
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Agregar imagen</label>
                     <div id='imagenMostrar'></div>
                       
                        <input class="form-control" type="file" id="foto" name="foto">
                        <input type="hidden" class="form-control" id="imagenText" name="imagenText" >

                    </div>
                </div>

                <div class="col-12">
                    <div class="mb-3">
                        <label for="select_tutor" class="form-label">Tutor</label>
                        <select class="form-select" id="select_tutor" name="select_tutor" aria-label="Default select example">
                            <!-- Opciones del select -->
                        </select>
                    </div>
                </div>
  
    `);
   
      modalSubmit.text('Actualizar')
      formulario_Tutor.attr('action','Alumno/editarAlumno');
      modalSubmit.attr('class','btn btn-success px-3 py-1 fs-5 ')
    });

    //Modal borrar
    $(document).on('click', '#borrarButtonAlumno', function (e) {
         const id  = $(this).data('id');     
        obtenerAlumnoPorId(id); 
        modalTitle.text('Eliminar');
        modalTitleIcon.text('delete')
        modalBody.html(`
        <div class="alert alert-danger" role="alert">
        
               <div class="col-md-6">
                    <div class="mb-3">
                        <label for="alumno" class="form-label"> Desea Eliminar al Alumno: </label>
                        <input type="text" class="form-control" id="alumno" name="alumno"  disabled>
                    </div>
                </div>       
        </div>
        `)
        modalSubmit.text('eliminar')
        modalSubmit.attr('class','btn btn-danger px-3 py-1 fs-5 ')

       formulario_Tutor.attr('action','Alumno/borrarAlumno');
       

    });

   //Modal para ver Informacion del alumno
   $(document).on('click','#informationButtonAlumno', function(e) {
    const id  = $(this).data('id');     
    obtenerAlumnoPorId(id)
    modalTitle.text('Informacion del Alumno');
        modalTitleIcon.text('visibility')
    modalBody.html(`

        <section class="card border border-0">
        <section class="row">
              <div class="col-4">  <div id="perfil"></div> </div>
              <div class="col-8">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                    <h4 class="fw-medium text-primary">Numero de celular:</h4>
                    <span id="telefono" class="fs-5 fw-light text-secondary"></span>
                  </li>
      
                  <li class="list-group-item">
                    <h4 class="fw-medium text-primary"> Escuela de  Procedencia:</h4>
                    <span id="escuela_procedencia" class="fs-5 fw-light text-secondary"></span>
                  </li>
      
                  <li class="list-group-item">
                    <h4 class="fw-medium text-primary">Situación Academica:</h4>
                    <span id="situacion_academica" class="fs-5 fw-light text-secondary"></span>
                  </li>
                </ul>
              </div>
        </section>
          
          <div class="card-body">   
            <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <h4 class="fw-medium text-primary">Tutor:</h4>
                  <span id="tutor" class="fs-5 fw-light text-secondary"></span>
                </li>
      
                <li class="list-group-item">
                  <h4 class="fw-medium text-primary">Numero de celular Padre:</h4>
                  <span id="tutor_telefono" class="fs-5 fw-light text-secondary"></span>
                </li>
      
                <li class="list-group-item">
                  <h4 class="fw-medium text-primary">Ocupación del Padre</h4>
                  <span id="tutor_ocupacion" class="fs-5 fw-light text-secondary"></span>
                </li>
            </ul>
          </div>
               
        
      
      </section>
      

  `);
  modalSubmit.text('')
  modalSubmit.attr('class','visually-hidden')

});
    

$(document).on('click', '#modalSubmit', function (e) {
    e.preventDefault(); // Evitar el comportamiento predeterminado

    var formAction = formulario_Tutor.attr('action');
    var formData = new FormData();
    if (formAction.includes('crearAlumno') || formAction.includes('editarAlumno')) {
    // Validaciones antes de enviar el formulario
    const alumno = $('#alumno').val();
    const fecha = $('#fecha_nacimiento').val();
    const telefono = $('#telefono').val();
    const direccion = $('#direccion').val();
    const escuelaProcedencia = $('#escuela_procedencia').val();
    const situacionAcademica = $('#situacion_academica').val();
    const select_tutor = $('#select_tutor option:selected').val();
    const foto = $('#foto').prop('files')[0]; // Obtener el archivo seleccionado
   

    // Expresiones regulares para la validación
    const alumnoValidate = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/.test(alumno);
    const telefonoValidate = /^\d{10}$/.test(telefono);
    const direccionValidate = /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s.]+$/.test(direccion);
    const escuelaProcedenciaValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.]+$/.test(escuelaProcedencia);
    const situacionAcademicaValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.]+$/.test(situacionAcademica);

    // Validación de campos
    if (alumno !== '' && telefono !== '' && direccion !== '' && escuelaProcedencia !== '' && situacionAcademica !== '' &&select_tutor != 0) {
        alumnoValidate ? $('#alumno').attr('class', 'form-control is-valid') : $('#alumno').attr('class', 'form-control is-invalid');
        telefonoValidate ? $('#telefono').attr('class', 'form-control is-valid') : $('#telefono').attr('class', 'form-control is-invalid');
        direccionValidate ? $('#direccion').attr('class', 'form-control is-valid') : $('#direccion').attr('class', 'form-control is-invalid');
        escuelaProcedenciaValidate ? $('#escuela_procedencia').attr('class', 'form-control is-valid') : $('#escuela_procedencia').attr('class', 'form-control is-invalid');
        situacionAcademicaValidate ? $('#situacion_academica').attr('class', 'form-control is-valid') : $('#situacion_academica').attr('class', 'form-control is-invalid');
        $('#select_tutor').attr('class', 'form-control is-valid');
    } else {
        alerta.html(`  
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Rellene los campos vacíos</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
        $('.form-control').attr('class', 'form-control is-invalid');
        $('#select_tutor').attr('class', 'form-control is-invalid');
    }


    // Validar el formato de la imagen
    if (foto) {
        const extension = foto.name.split('.').pop().toLowerCase();
        if ($.inArray(extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) === -1) {
           
            alerta.html(`  
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Formato de imagen inválido</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            $('#foto').attr('class', 'form-control is-invalid');
            return false;
        } else {
            $('#foto').attr('class', 'form-control is-valid');
        }
    }

    formData.append('alumno', $('#alumno').val());
    formData.append('fecha_nacimiento', $('#fecha_nacimiento').val());
    formData.append('telefono', $('#telefono').val());
    formData.append('direccion', $('#direccion').val());
    formData.append('escuela_procedencia', $('#escuela_procedencia').val());
    formData.append('situacion_academica', $('#situacion_academica').val());
    formData.append('select_tutor', $('#select_tutor').val());
    // Si tienes un input tipo archivo
    formData.append('foto', foto);
    // Si no hay una nueva imagen, agregar la imagen actual
    formData.append('foto2', $('#imagenText').val()); // El src de la imagen actual
    

}

// Crear un nuevo FormData para incluir archivos



formData.append('itemID',$('#itemID').val());


    
    // Enviar el formulario por AJAX si todo está correcto
    $.ajax({
        url: formAction,
        type: 'POST',
        data: formData  ,
        contentType: false,
        processData: false,
        success: function (response) {
            const responseJson = JSON.parse(response);
            console.log(responseJson);
            
            alerta.html(`  
                <div class="alert ${responseJson.alert} alert-dismissible fade show" role="alert">
                    <strong>${responseJson.message}</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            $('#reusableModal').modal('hide');
            // setInterval(function () {
            //     // Llama a la función de recarga cada 10 segundos (puedes ajustar este valor)
            //     location.reload()
            //  }, 100);
        },
        error: function (xhr, status, error) {
            alert('Error: ' + error);
        }
    });
});


  });
//#endregion

function obtenerAlumnoPorId(id) {
    const parametro = {
        "id": id
    }
    $.ajax({
        type: "POST",
        url: "Alumno/getByStudent",
        data: parametro,
        success: function (response) {
            const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
            //Variables de Formulario
            const itemID = $('#itemID');
            const alumnoId = $('#alumno');
            const fechaId = $('#fecha_nacimiento');
            const telefonoId = $('#telefono');
            const direccionId = $('#direccion');
            const escuelProcedenciaId = $('#escuela_procedencia');
            const situacionAcademicaId= $('#situacion_academica');
            const fotoId = $('#imagenText');
          
            //Variable Modal Informacion
            const fechaNacimientoInfo = $('#fecha_nacimientoInfo');
            const telefonoInfo = $('#telefono');
            const escuelaProcedenciaInfo = $('#escuela_procedencia');
            const situacionAcademicaInfo = $('#situacion_academica');
            const tutorInfo = $('#tutor');
            const tutorTelefonoInfo= $('#tutor_telefono');
            const tutorOcupacionInfo = $('#tutor_ocupacion');


            const { id, Alumno, fecha_nacimiento, direccion, ruta_img, Telefono, escuela_procedencia, situacion_academica, tutor,celular_padre,
                Ocupacion } = responseJson.data;

                // Asignar el atributo 'src' para cargar la imagen
                // fotoId.attr('src', `{}`); // La variable `foto` debe contener la URL o ruta de la imagen
                
                // Asignar el atributo 'alt' para el texto alternativo
                fotoId.val(ruta_img); // El texto que describa la imagen
                

                $('#perfil').html(`
                     <img src="public/image/subidas/${ruta_img}" class="rounded mt-4"   height="220" width="180"alt="${ruta_img}">
                    `)
            // Asignar valores a los campos
            $('#imagenMostrar').html(`
                <img src='public/image/subidas/${ruta_img}' alt=${ruta_img} width=80 height=80 />
                `)
            itemID.val(id);
            alumnoId.val(Alumno);
            fechaId.val(fecha_nacimiento);
            telefonoId.val(Telefono);
            direccionId.val(direccion);
         
            escuelProcedenciaId.val(escuela_procedencia);
            situacionAcademicaId.val(situacion_academica);
           // Mostrar el  Modal Informacion
           fechaNacimientoInfo.text(`${fecha_nacimiento }`);
           telefonoInfo.text(`${ Telefono}`);
           escuelaProcedenciaInfo.text(`${escuela_procedencia }`);
           situacionAcademicaInfo.text(`${ situacion_academica}`);

           tutorInfo.html(`${ tutor}`);

         tutorTelefonoInfo.text(`${celular_padre }`);
           tutorOcupacionInfo.text(`${Ocupacion }`);


            // Llamar a reloadSelect para cargar los tutores y seleccionar el tutor actual
            reloadSelect(tutor);
        }
    });
}

function reloadSelect(tutor) {
    $.ajax({
        method: 'POST',
        url: 'Tutor/getDataTutor',
        success: function (response) {
            const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
            const tutorSelect = $('#select_tutor');
            tutorSelect.empty();
            tutorSelect.append('<option value="0" >Seleccione el tutor correspondiente</option>');
         
            responseJson.data.forEach(item => {
                tutorSelect.append(`<option value="${item.id}"  >${item.nombre}</option>`);
            });

            if(tutor){
                const selectedTutor=   responseJson.data.find(item => item.nombre == tutor)
                  // Verificar si se encontró el tutor
                if (selectedTutor) {
                    tutorSelect.append(`<option value="${selectedTutor.id}" selected  >${selectedTutor.nombre}</option>`);
            }
        }
             
            
        }
    });
}

//#endregion