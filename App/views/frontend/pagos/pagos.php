
<section class="container text-center  align-content-center">
    <header class="d-flex  justify-content-between">
        <h1 class="mb-5 text-center">Pagos</h1>
        <section>
            <button class="btn btn-warning " type="button"data-bs-toggle="modal" data-bs-target="#modal_reutilizable_pagos" id="createButton">
            <span class='material-icons px-1 py-1 '>add</span> 
            </button>
      </section>
    </header>


    <div class="table-responsive">
    <table class="table table-style" id="table_pagos">
        <thead>
            <tr>
                <th scope="col">#</th> 
                <th scope="col">Codigo</th>
                <th scope="col">Alumno</th>
                <th scope="col">Metodo de Pago</th>
                <th scope="col">Monto</th>
                <th scope="col">Descuentos</th>
                <th scope="col">Observación</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th> 
                <th scope="col">Editar</th> 
                <th scope="col">Eliminar</th> 
                <th scope="col">Reporte</th> 
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    </div>
  



<!-- Modal -->
<div class="modal fade" id="modal_reutilizable_pagos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  
<div class="row justify-content-center ">
     <div class="col-xl-5 mt-2"> <div id="alertPagos"></div></div>
  </div>
<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
            <span class='material-icons' id="modalTitleIcon"></span><h1 class="modal-title fs-5" id="modalTitle"></h1>
            <button type="button" class="btn-close"  data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

        <form id="formulario_crear_pagos"  >
            <div class="modal-body">
                <input type="hidden" name="id" id="itemID" >
                <div id="modalFormBody"class="row g-3" ></div>
                    <div class="modal-footer">
                        <div class="col-12">
                            <button type="submit" id="modalSubmit" class="btn btn-primary"></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
  </div>
</div>
