//#region  Datatable Mosrar dinammicamente
$(document).ready(function () {
    $('#table_materia').DataTable({
      "ajax": {
        "method":'POST',
        "url": 'AgregarAlumno/getDataAgregarAlumno',
        "dataSrc": 'data'
      },
      "columns":[
        {data:'id'},
        {data:'Alumno'},
        {data:'Materia'},
        {data:'Docente'},
        {data:'Descripción'},
        {data:'editar'},
        {data:'eliminar'}
   
      ]
  
    });
  });
  //#endregion
  
  