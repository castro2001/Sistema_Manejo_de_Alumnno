  //Estte es el codigo para el menu
$(document).ready(function(){
  $(".xp-menubar").on('click',function(){
    $('#sidebar').toggleClass('active');
    $('#content').toggleClass('active');
  });
  
   $(".xp-menubar,.body-overlay").on('click',function(){
     $('#sidebar,.body-overlay').toggleClass('show-nav');
   });
    
  });
$(document).ready(function() {
  setTimeout(function() {
  $(".content").fadeOut(1500);
  },3000);

});

$(document).ready(function() {
  $('.dropdown-button').on('click', function() {
      // Obtener el ID del submenú
      var target = $(this).attr('data-toggle');
      
      // Alternar la clase "show" para desplegar o colapsar
      $(target).toggleClass('show');
      
      // Cambiar el atributo "aria-expanded" según el estado
      var isExpanded = $(target).hasClass('show');
      $(this).attr('aria-expanded', isExpanded);
  });
});









 


