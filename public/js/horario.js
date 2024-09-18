

$(document).ready(function() {
  $('#table_horario').DataTable({
      "ajax": {
        "method":'POST',

        "url": '?views=Horario&action=getDatasHorario',// Cambia esto por la URL de tu script PHP
          "dataSrc": "data"
      },
      "columns": [
          { "data": "Hora" },
          { "data": "Lunes" },
          { "data": "Martes" },
          { "data": "Miércoles" },
          { "data": "Jueves" },
          { "data": "Viernes" }
      ]
  });
});
