//#region  DATATABLE PAGOS
$(document).ready(function () {
    $('#table_pagos').DataTable({
      pageLength:5,
      lengthMenu:[
        [5,10,25,50],[5,10,25,50]
      ],
      ajax: {
        method:'POST',
        url: 'Pagos/getDataPagos',
        dataSrc: 'data'
      },
      columns:[
        {data:'id'},
        {data:'codigo'},
        {data:'Alumno'},
        {data:'Metodo_Pago'},
        {data:'Monto'},
        {data:'Descuento'},
        {data:'Observacion'},
        {data:'Total'},
        {data:'status'},
        {data:'editar'},
        {data:'eliminar'}
      ],
      
      columnDefs: [
        { 
            targets: [0,1,2,3,4,5], // Aplica solo a la primera columna (id)
            visible: true, // La columna es visible
            className: 'text-center', // Añade una clase CSS específica
            // width: '2%' // Define el ancho de la columna
        },
        {
          targets: 8, // Aplica solo a la columna 'status'
          render: function(data, type, row) {
              
            if (data === "1" || data === 1) {  // Comparar tanto string como número
                return '<span class="px-2 py-2 rounded text-success fw-semibold">Pagado</span>';
            } else if (data === "0" || data === 0) {
                return '<span class="px-2 py-2 rounded text-danger fw-semibold">Pendiente</span>';
            } else {
                return '<span class="px-2 py-2 rounded text-warning fw-semibold">Sin Estado</span>';  // Por si acaso hay otro valor
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
    },
  
    });


});
//#endregion

//#region Modal reutilizable
$(document).ready(function () {
 const modalTitle = $('#modalTitle ');
 const modalBody = $('#modalFormBody');
 const modalTitleIcon = $('#modalTitleIcon');
 const modalSubmit = $('#modalSubmit');
 const formulario_Tutor = $('#formulario_crear_pagos')
 const itemID = $('#itemIDitemID');
 const alerta = $('#alertPagos');


 $('#createButton').click(function (e) {
   //Modal Crear 
   modalTitle.text('Crear');
   modalTitleIcon.text('person')
   
   selectAlumnos()
   modalBody.html(`
       <div class="col-md-6">
          <div class="mb-3">
                <label for="codigo" class="form-label">Codigo</label>
                <input type="text" class="form-control" id="codigo" name="codigo" placeholder="ABC123"  maxlength="6" >
                <span id="errorCodigo" class="error-message"></span>
          </div>
       </div>

       <div class="col-md-6">
          <div >
                <label for="select_Alumno" class="form-label">Alumno</label>
                <select class="form-select" id="select_Alumno" name="select_Alumno" aria-label="Default select example"></select>
                <span id="error_alumno"></span>
          </div>
       </div>

    <div class="col-md-6">
       <div class="mb-3">
             <label for="select_pago" class="form-label">Metodo de pago</label>
             <select class="form-select" id="select_pago" name="select_pago">
                 <option value="0" >Seleccione un metodo de pago</option>
              <option value="Efectivo">Efectivo</option>
              <option value="Transferencia">Transferencia</option>
             </select>
       </div>
    </div>

  <div class="col-md-6">
      <div class="mb-3">
          <label for="select_status" class="form-label">Estado</label>
          <select class="form-select" id="select_status" name="select_status" aria-label="Default select example">
        
            <option value="default" >Seleccione el estado del pago</option>
            <option value="1" >pagado</option>
            <option value="0" >pendiente</option>
          </select>
      </div>
  </div>
  
  <div class="col-md-4">
      <div class="mb-3">
          <label for="monto" class="form-label">Monto</label>
          <input type="text" class="form-control" id="monto" name="monto" placeholder="12.56" maxlength=6>
          <div id="errorMonto" class="error-message"></div>
      </div>
  </div>

  <div class="col-md-4">
      <div class="mb-3">
          <label for="descuentos" class="form-label">Descuento</label>
          <input type="text" class="form-control" id="descuentos" name="descuentos" placeholder="10" maxlength=3 >
          <div id="errorDescuentos" class="error-message"></div>
      </div>
  </div>
  
  <div class="col-md-4">
      <div class="mb-3">
          <label for="total" class="form-label">Total</label>
          <input type="text" class="form-control" id="total" name="total"  value=0.00 maxlength=6>
          <div id="errorTotal" class="error-message"></div>
          <button onclick='actualizarTotal()' class='btn btn-secondary mt-2' type='button' >Calcular EL Total</button>
      </div>
  </div>

  <div class="col-12">
      <div class="mb-3">
          <label for="observacion" class="form-label">Observacion</label>
          <textarea class="form-control" id="observacion" name="observacion" placeholder="Observación adicional" ></textarea>
          <div id="errorobservacion"></div>
      </div>
  </div>
  

   `);
   modalSubmit.text('crear')
   modalSubmit.attr('class','btn btn-primary px-3 py-1 fs-5 ')
   formulario_Tutor.attr('action','Pagos/crearPago');
 });


 //Modal Editar
 $(document).on('click', '#editarButtonPago', function (e) {
  const id  = $(this).data('id'); 
  obtenerPagoPorId(id)
       modalTitle.text('Editar ');
   modalTitleIcon.text('edit')
   modalBody.html(`
      <div class="col-md-6">
         <div class="mb-3">
               <label for="codigo" class="form-label">Codigo</label>
               <input type="text" class="form-control" id="codigo" name="codigo" placeholder="ABC123"  maxlength="6" >
               <span id="errorCodigo" class="error-message"></span>
         </div>
      </div>

      <div class="col-md-6">
         <div >
               <label for="select_Alumno" class="form-label">Alumno</label>
               <select class="form-select" id="select_Alumno" name="select_Alumno" aria-label="Default select example"></select>
               <span id="error_alumno"></span>
         </div>
      </div>

   <div class="col-md-6">
      <div class="mb-3">
            <label for="select_pago" class="form-label">Metodo de pago</label>
            <select class="form-select" id="select_pago" name="select_pago">
                <option value="0" >Seleccione un metodo de pago</option>
             <option value="Efectivo">Efectivo</option>
             <option value="Transferencia">Transferencia</option>
            </select>
      </div>
   </div>

 <div class="col-md-6">
     <div class="mb-3">
         <label for="select_status" class="form-label">Estado</label>
         <select class="form-select" id="select_status" name="select_status" aria-label="Default select example">
       
                      <option value="default" >Seleccione el estado del pago</option>
            <option value="1" >pagado</option>
            <option value="0" >pendiente</option>
         </select>
     </div>
 </div>
 
 <div class="col-md-4">
     <div class="mb-3">
         <label for="monto" class="form-label">Monto</label>
         <input type="text" class="form-control" id="monto" name="monto" placeholder="12.56" maxlength=6>
         <div id="errorMonto" class="error-message"></div>
     </div>
 </div>

 <div class="col-md-4">
     <div class="mb-3">
         <label for="descuentos" class="form-label">Descuento</label>
         <input type="text" class="form-control" id="descuentos" name="descuentos" placeholder="10" maxlength=3 >
         <div id="errorDescuentos" class="error-message"></div>
     </div>
 </div>
 
 <div class="col-md-4">
     <div class="mb-3">
         <label for="total" class="form-label">Total</label>
         <input type="text" class="form-control" id="total" name="total" value=0.00 maxlength=6>
         <div id="errorTotal" class="error-message"></div>
         <button onclick='actualizarTotal()' class='btn btn-secondary mt-2' type='button' >Calcular EL Total</button>
     </div>
 </div>

 <div class="col-12">
     <div class="mb-3">
         <label for="observacion" class="form-label">Observacion</label>
         <textarea class="form-control" id="observacion" name="observacion" placeholder="Observación adicional" ></textarea>
         <div id="errorobservacion"></div>
     </div>
 </div>
 

  `);
 
   modalSubmit.text('Actualizar')
   formulario_Tutor.attr('action','Pagos/editarPago');
   modalSubmit.attr('class','btn btn-success px-3 py-1 fs-5 ')
 });

 //Modal borrar
 $(document).on('click', '#borrarButtonPago', function (e) {
   const id  = $(this).data('id'); 
   obtenerPagoPorId(id)
   modalTitle.text('Eliminar');
   modalTitleIcon.text('delete')
      modalBody.html(`
   
 <div class="alert alert-danger" role="alert">
 
          
  <div class="col-md-6">
      <div class="mb-3">
          <label for="alumno_update" class="form-label">Desea Eliminar El Pago: </label>
          <input type="text" disabled class="form-control" id="alumno_update" disabled name="alumno_update" >

          <span id="error_alumno"></span>
      </div>
  </div>
         
</div>
   `)
   modalSubmit.text('eliminar')
   modalSubmit.attr('class','btn btn-danger px-3 py-1 fs-5 ')

   formulario_Tutor.attr('action','Pagos/borrarPago');
   itemID.val(id);

 });

 $(document).on('click', '#modalSubmit', function (e) { 
  e.preventDefault(); // Evitar el comportamiento predeterminado
  var formAction = formulario_Tutor.attr('action');
  var formData = formulario_Tutor.serialize(); // Serializar los datos del formulario

  if (formAction.includes('crearPago') || formAction.includes('editarPago')) {
      const codigo = $('#codigo').val();
      const alumno = $('#select_Alumno option:selected').val();
      const metodoPago = $('#select_pago option:selected').val();
      const estadoPago = $('#select_status option:selected').val();
      const monto = parseFloat($('#monto').val());
      const descuentos = parseFloat($('#descuentos').val());
      const observacion = $('#observacion').val();

      const codigoValidate = /^[a-zA-Z0-9]+$/.test(codigo);
      const montoValidate = /^\d+(\.\d{1,2})?$/.test(monto);
      const descuentosValidate = /^\d+$/.test(descuentos);
      const observacionValidate = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ .]{9,}$/.test(observacion);
      


      // Validar selección de opciones
      if (estadoPago != 'default') {
          $('#select_status').attr('class', 'form-control is-valid');
      } else {
          $('#select_status').attr('class', 'form-control is-invalid');
      }

      if (metodoPago != 0) {
          $('#select_pago').attr('class', 'form-control is-valid');
      } else {
          $('#select_pago').attr('class', 'form-control is-invalid');
      }

      if (alumno != 0) {
          $('#select_Alumno').attr('class', 'form-control is-valid');
      } else {
          $('#select_Alumno').attr('class', 'form-control is-invalid');
      }

      // Escuchar los cambios en los campos monto y descuentos para actualizar el total
      $('#monto, #descuentos').on('input', function () {
      actualizarTotal();
      });

      if (montoValidate && descuentosValidate) {
          $('#monto').attr('class', 'form-control is-valid');
          $('#descuentos').attr('class', 'form-control is-valid');
          alerta.html('');
      } else {
          alerta.html(`
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Los campos monto y total son decimales, y el campo descuento es sin decimal</strong>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `);
          $('#monto').attr('class', 'form-control is-invalid');
          $('#descuentos').attr('class', 'form-control is-invalid');
      }

      if (observacionValidate) {
          $('#observacion').attr('class', 'form-control is-valid');
          $('#errorobservacion').text('');
      } else {
          $('#observacion').attr('class', 'form-control is-invalid');
          $('#errorobservacion').text('Debe tener como mínimo 10 caracteres');
      }

      if (codigoValidate) {
          $('#codigo').attr('class', 'form-control is-valid');
          $('#errorCodigo').text('');
      } else {
          $('#codigo').attr('class', 'form-control is-invalid');
          $('#errorCodigo').text('El código debe estar conformado por letras y números');
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
        // Configura un intervalo de tiempo para recargar los datos automáticamente
        alerta.html(`
          <div class="alert ${responseJson.alert} alert-dismissible fade show" role="alert">
            <strong>${responseJson.message}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        `);
        $('#modal_reutilizable_pagos').on('hidden.bs.modal', function () {
            // 
            setTimeout(function(){
              location.reload(); // Recargar la página
            },1000)
          });
      
      },
      error: function(xhr, status, error) {
          // Lógica de error
          alert('Error: ' + error);

      }
  });
});


});

//#endregion


//#region Funciones 
function obtenerPagoPorId(id) {
  const parametro = {"id":id}    
  $.ajax({
    type: "POST",
    url: "Pagos/getByPagos",
    data: parametro,
    success: function (response) {
      const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
      
      const itemID = $('#itemID');
      const codigoId= $('#codigo');
      const select_pagoId= $('#select_pago');
      const monto = $('#monto'); 
      const descuentosId= $('#descuentos');
      const totalId = $('#total');
      const observacionId = $('#observacion');
      const estadoSelect = $('#select_status ');

      const { id, codigo,id_Alumno,Alumno , Metodo_Pago,Monto,Descuento,Observacion,Total,status} = responseJson.data ;
      itemID.val(id)
      codigoId.val(codigo);
      select_pagoId.val(Metodo_Pago);
      estadoSelect.val(status)
      monto.val(Monto);
      descuentosId.val(Descuento);
      observacionId.val(Observacion);
      totalId.val(Total);
      selectAlumnos(id_Alumno,Alumno);
    }
  });

}

function selectAlumnos(id_Alumno,Alumno){

    
    $.ajax({
    method: 'POST',
    url: 'Alumno/getDataStudent',
    success: function (response) {
        const responseJson = JSON.parse(response); // Convertir la respuesta a JSON
        const alumnoSelect = $('#select_Alumno');
        alumnoSelect.empty();
        alumnoSelect.append('<option value="0">Seleccione un Alumno</option>')
        responseJson.data.forEach(item => {
            alumnoSelect.append(`<option value="${item.id}"  >${item.Alumno}</option>`);
        });
        if(Alumno){
            const selectedTutor=   responseJson.data.find(item => item.id == id_Alumno)
         
            
              // Verificar si se encontró el tutor
            if (selectedTutor) {
                alumnoSelect.append(`<option value="${selectedTutor.id}" selected  >${selectedTutor.Alumno}</option>`);
            }
        }    
    }
});
  
}


function actualizarTotal() {
  const montoVal = parseFloat($('#monto').val()) || 0;
  const descuentosVal = parseFloat($('#descuentos').val()) || 0;

  if (!isNaN(montoVal) && !isNaN(descuentosVal)) {
      const desporcentaje = descuentosVal/100;
      var totalMonto = montoVal -desporcentaje ;
      $('#total').val(totalMonto.toFixed(2)); // Actualizar el campo total
  }
}

//#endregion