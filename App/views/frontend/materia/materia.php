
<section class="container text-center  align-content-center">

    <header class="d-flex  justify-content-between">
      <h1 class="mb-5 text-center">Materia</h1>
      <section>
        <button class="btn btn-warning " type="button"data-bs-toggle="modal" data-bs-target="#modal_reutilizable_materia" id="createButtonMateria">
          <span class='material-icons px-1 py-1 '>add</span> 
        </button>
      </section>
    </header>

    <section class="table-responsive">
        <table class="table table-style" id="table_materia">
            <thead>
                <tr>
                    <th scope="col">#</th> 
                    <th scope="col">Nombre</th>
                    <th scope="col">Docente</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Editar</th> 
                    <th scope="col">Eliminar</th> 
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </section>

</section>





<!-- Modal -->
<div class="modal fade" id="modal_reutilizable_materia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
<!--  -->
  <div class="row justify-content-center ">
     <div class="col-xl-5 mt-2"> <div id="alert"></div></div>
  </div>
  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <span class='material-icons' id="modalTitleIcon"></span><h1 class="modal-title fs-5" id="modalTitleMateria"></h1>
         <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formulario_Materia"  >
         <div class="modal-body">
            <input type="hidden" name="id" id="itemID" >
               <div id="modalFormBodyMateria"class="row g-3" ></div>
           
            <div class="modal-footer">
               <div class="col-12">
                     <button type="submit" id="modalSubmitMateria" class="btn btn-primary"></button>
               </div>  
            </div>           
        </div>
      </form>
    
    </div>
  </div>
</div>

