

<section class="container text-center  align-content-center">
    <header class="d-flex  justify-content-between">
      <h1 class="mb-5 text-center">Alumnos</h1>
      <section>
        <button class="btn btn-warning " type="button"data-bs-toggle="modal" data-bs-target="#modal_reutilizable_Alumno" id="createButtonAlumno">
          <span class='material-icons px-1 py-1 '>add</span> 
        </button>
      </section>
    </header>

    <section class="table-responsive text-center">
        <table class="table table-style" id="table_alumno">
            <thead>
                <tr>
                    <th scope="col">id</th> 
                    <th scope="col text-success">Alumno</th>
                    <th scope="col">Fecha de Nacimiento</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Información</th>
                    <th scope="col">Estado</th> 
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


<div class="modal fade" id="modal_reutilizable_Alumno" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  
<div class="row justify-content-center ">
     <div class="col-xl-5 mt-2"> <div id="alertAlumno"></div></div>
  </div>
<div class="modal-dialog shadow rounded">
    <div class="modal-content">
      <div class="modal-header">
         <span class='material-icons' id="modalTitleIcon"></span><h1 class="modal-title fs-5 fw-bold ms-2" id="modalTitle"></h1>
         <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="formulario_Alumno" enctype="multipart/form-data" >
         <div class="modal-body">
            <input type="hidden" name="id" id="itemID" >
               <div id="modalFormBody"class="row g-3" ></div>
           
            <div class="modal-footer">
               <div class="col-12">
                     <button type="submit" id="modalSubmit" class="btn"></button>
               </div>  
            </div>           
        </div>
      </form>
    
    </div>
  </div>
</div>



