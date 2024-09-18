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
<body>

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

                <li class="dropdown">
                    <a class="text-decoration-none" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapseExample">
                        <span><?= isset($_SESSION['nombre'])? ucfirst($_SESSION['nombre']): 'Jordan'; ?></span>
                    </a>                  
                    <ul class="collapse list-unstyled menu" id="collapse">
                        <li>
                            <a href="" class="text-decoration-none">Perfil</a>
                        </li>
                        <li>
                            <a href="#" class="text-decoration-none" >Configuración</a>
                        </li>
                        <li>
                            <a href="" class="text-decoration-none">Cerrar sesión</a>
                        </li>
                    </ul>
                </li>

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

            <!-- Start XP Row -->
            <div class="row justify-content-between"> 
                <!-- Start XP Col -->
                <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                    <div class="xp-menubar">
                            <span class="material-icons text-white">signal_cellular_alt
                            </span>
                        </div>
                </div> 
                <!-- End XP Col -->

                <!-- Start XP Col -->
                <div class="col-md-5 col-lg-3 order-3 order-md-2">
                    <div class="xp-searchbar">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control" 
                                placeholder="Buscar...">
                                <div class="input-group-append">
                                <button class="btn" type="submit" 
                                id="button-addon2">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- End XP Col -->

                <!-- Start XP Col -->
                <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                    <div class="xp-profilebar text-right">
                            <nav class="navbar p-0">
                            <ul class="nav navbar-nav flex-row ml-auto">   
                                <li class="dropdown nav-item active">
                                    <a href="#" class="nav-link" data-toggle="dropdown">
                                    <span class="material-icons">notifications</span>
                                    <span class="notification">4</span>
                                </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="#">You have 5 new messages</a>
                                        </li>
                                        <li>
                                            <a href="#">You're now friend with Mike</a>
                                        </li>
                                        <li>
                                            <a href="#">Wish Mary on her birthday!</a>
                                        </li>
                                        <li>
                                            <a href="#">5 warnings in Server Console</a>
                                        </li>
                                    
                                    </ul>
                                </li>
                                
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="#" data-toggle="dropdown">
                                    <img src="public/image/logo.png" style="width:40px; border-radius:50%;"/>
                                    <span class="xp-user-live"></span>
                                    </a>
                                    <ul class="dropdown-menu small-menu">
                                        <li>
                                            <a href="../profile/mostrar.php">
                                            <span class="material-icons">person_outline</span>Perfil

                                            </a>
                                        </li>
                                        <li>
                                            <a href="#"><span class="material-icons">settings</span>Configuración</a>
                                        </li>
                                        <li>
                                            <a href="../pages-logout.php"><span class="material-icons">logout</span>Cerrar sesión</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                    </nav>
                        
                    </div>
                </div>
                <!-- End XP Col -->

            </div> 
            <!-- End XP Row -->

        </section>

        <section class="xp-breadcrumbbar text-center">
            <h4 class="page-title">Bienvenido&nbsp;<?= isset($_SESSION['usuario']) ? ucfirst($_SESSION['usuario']):'user' ; ?></h4>  
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><?=  isset($_SESSION['correo'])? ucfirst($_SESSION['correo']): 'example'; ?></li>
            </ol>                
        </section>
        
    </header>

    <section class="main-content">
