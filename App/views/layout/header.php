<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>Sistema Escolar <?= isset($title) ? "| ".$title: null ?> </title>
	    <!-- Bootstrap CSS -->
        <link rel="icon" type="image/png" sizes="96x96" href="public/image/logo.png">
		<!--google fonts -->
	    <?php if(!empty($styles)): ?>
            <?php foreach($styles as $style): ?>
            <link rel="stylesheet" href="public/css/<?php echo $style?>.css"> 
            <?php endforeach ?>
        <?php endif ?>    

	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	<!--google material icon-->
      <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
      <!-- Datatables sttylle -->
      <link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css" />
  
        <link rel="stylesheet" href="https://cdn.datatables.net/autofill/2.7.0/css/autoFill.bulma.min.css   ">  

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body  >

<main class="wrapper">
    <div class="body-overlay"></div>
    <nav id="sidebar">
            <header class="sidebar-header">
                <h3>
                    <img src="public/image/logo.png" alt="logo" class="img-fluid"/>
                     <span>Sistema escolar</span>
                     
                </h3>
            </header>

          
            <ul class="list-unstyled components">

            

                <li >
                     <a href="Administrador" class="dashboard text-decoration-none"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
                 </li>
		
                <li >
                    <a href="Tutor" class="text-decoration-none"><i class="material-icons">supervisor_account</i><span>Padres</span></a>
                </li>

                <li  >
                    <a href="Alumno" class="text-decoration-none"><i class="material-icons">sentiment_very_satisfied</i><span>Alumnos</span></a>
                </li>

                <li >
                    <a  data-bs-toggle="collapse" data-bs-target="#collapseCalendario" aria-expanded="false" aria-controls="collapseExample" class="text-decoration-none" ><i class="material-icons">school</i><span>Materias</span></a>
                    <ul class="collapse list-unstyled menu" id="collapseCalendario">
                        <li>
                            <a href="Materia" class="text-decoration-none">Ver Materia</a>
                        </li>
                        <li>
                            <a href="AgregarAlumno" class="text-decoration-none" >Alumnos registrados</a>
                        </li>
                        
                    </ul> 
                </li>

                <li >
                    <a href="Horario" class="text-decoration-none cursor-pointer" >
                        <i class="material-icons">calendar_month</i><span>Calendario</span>
                    </a>
                  
                </li>

                <li  >
                    <a href="Pagos" class="text-decoration-none"><i class="material-icons">payment</i><span>Pagos</span></a>
                </li>  
            </ul>
    </nav>
<!-- Contenido -->
<section id="content">
    <header class="top-navbar">
        <section class="xp-topbar">
            <div class="row justify-content-between align-items-center">
            <!-- Menú en la izquierda -->
            <div class="col-1 col-lg-1 col-md-1">
                <div class="xp-menubar">
                    <span class="material-icons text-white">signal_cellular_alt</span>
                </div>
            </div>

            <div class="col-8 col-lg-1 col-md-4 position-relative">

                <div class="position-relative">
                <a class="text-decoration-none" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapseExample">
                    <img src="public/image/user.jpg" alt="logo" class="rounded-circle" height="50">
                </a>                  
                    
                </div>
                <ul class="collapse list-unstyled  bg-white dropdown position-absolute end-0 text-center shadow" style="width:150px;height:120px" id="collapse">
                        <li class="p-2">
                            <?= isset($_SESSION['User'])? ucfirst($_SESSION['User']->usuario): 'Jordan'; ?>
                        </li>
                    
                        <li class="p-2">
                            <a href="Login/logout" class=" btn btn-danger">Cerrar sesión</a>
                        </li>
                </ul>
                </div>
            </div>
                

        </section>
        
    </header>

    

    <section class="main-content">


