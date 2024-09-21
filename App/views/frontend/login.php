<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">

</head>
<body style="background: #2b3d6b;">
<div class="container-fluid ">
  <div class="row  justify-content-center align-items-center mt-5">

    <div class="col-md-5 col-12">
    <?php  if(isset($_SESSION['messagge'])):?>    
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong><?= $_SESSION['messagge'] ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif?>
    
  <div style="background-color: #355d98;width: 100%;border-radius:20px; padding: 50px; min-height: 20px;">
    <h1 class="text-white">Sistema Escolar</h1> 
    <p class="text-white">Para conectarse al sistema esscolar es importante solicitar un usuario a la institución.</p>
  <form method="post" action="Login/login" >
        <div class="mb-3">
          <label for="inputUser" class="form-label text-white">Nombre de usuario</label>

          <div class="input-group mb-3">
            <span class="input-group-text bg-success" id="basic-addon1"><span class="material-icons text-light">person</span></span>
            <input type="text" name="user" id="inputUser" class="form-control" placeholder="Username" maxlength="15" aria-describedby="basic-addon1">
          </div>

        </div>
        <div class="mb-3">
          <label for="inputClave" class="form-label text-white">Contraseña</label>

          <div class="input-group mb-3">
            <span class="input-group-text bg-success  " id="basic-addon1"><span class="material-icons text-light">lock</span></span>
            <input type="password" class="form-control bg-primary-subtle" placeholder="Username" maxlength="15" id="inputClave"  name="clave" maxlength="10" aria-describedby="basic-addon1">
          </div>

        </div>


      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
            


    </div>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
