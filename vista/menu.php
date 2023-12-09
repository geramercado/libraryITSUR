<?php 
  session_start();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
          <img src="imagenes/logoItsur.png" alt="">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                </li>
              <?php
                if($_SESSION["puesto"]=="Alumno"){
                  echo '<li class="nav-item">
                          <a class="nav-link active" aria-current="page" href="accesoGeneral.php">Acceso general</a>
                        </li>';
                }
                else{
                  echo '
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Registros
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="prestamoGrupal.php">Servicio Grupal</a></li>
                            <li><a class="dropdown-item" href="prestamoIndividual.php">Servicio Individual</a></li>
                            <li><a class="dropdown-item" href="usuario.php">Usuario</a></li>
                          </ul>
                        </li>
                        <li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Listas
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="listaPrestamos.php">Prestamos</a></li>
                            <li><a class="dropdown-item" href="listaUsuarios.php">Usuarios</a></li>
                          </ul>
                        </li>';
                  if($_SESSION["puesto"]=="Administrador"){
                    echo '<li class="nav-item dropdown">
                          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informes
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="FiltrarArea(Escuela)Concentrado.php">Filtrar Escuela concentrado</a></li>
                            <li><a class="dropdown-item" href="ReporteGeneral.php">Reporte General</a></li>
                            <li><a class="dropdown-item" href="ReporteGeneralConcentrado.php">Reporte General Concentrado</a></li>
                            <li><a class="dropdown-item" href="#">Reporte General Concentrado</a></li>
                          </ul>
                        </li>
                        ';
                  }
                }
              ?>
            </ul>
          </div>
          <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <?=
                    $_SESSION["nombre"];
                  ?>
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="cerrarSesion.php">Cerrar sesión</a></li>
                </ul>
              </li>
            </ul>
        </div>
      </nav>