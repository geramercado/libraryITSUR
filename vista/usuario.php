<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        
        form .row > div{
            margin: .5rem 0;
        }
    </style>
</head>
<body>
    <?php
        require('menu.php');
        if(!ISSET($_SESSION["usuario"])){
            header("Location:login.php");
        }
      require_once('../datos/daoUsuario.php');
      require_once('usuarioUtil.php');
      
    ?>
    
    <div class="container mt-3">
        <form method="post">
            <input type="hidden" name="id" value="<?=$usuario->id?>">
            <div class="row">
                <div class="col-4">
                    <label for="txtNombre" class="form-label">Nombre:</label>
                    <input type="text" id="txtNombre" name="Nombre" class="form-control <?=$valNombre?>"
                    placeholder="Nombre" required value="<?= $usuario->nombre?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El nombre es obligatorio</li>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 2 y 50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtApellido1" class="form-label">Primer apellido:</label>
                    <input type="text" id="txtApellido1" class="form-control <?=$valApe1?>" 
                    name="Apellido1" placeholder="Primer apellido" value="<?= $usuario->apellido1 ?>" required>
                    <div class="invalid-feedback">
                        <ul>
                            <li>El primer apellido es obligatorio</li>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 2 y 50</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtApellido2" class="form-label">Segundo apellido:</label>
                    <input type="text" id="txtApellido2" class="form-control <?=$valApe2?>" name="Apellido2" placeholder="Segundo apellido"
                    value="<?= $usuario->apellido2 ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>Debe contener solo caracteres alfabéticos</li>
                            <li>Debe tener entre 2 y 50</li>
                        </ul>
                    </div>
                </div>

                <div class="col-6">
                    <label for="txtEmail" class="form-label">Correo:</label>
                    <input type="email" id="txtEmail"  name="Email" class="form-control <?=$valEmail?>"
                    placeholder="Correo electrónico" required value="<?= $usuario->email ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>El correo electrónico es obligatorio</li>
                            <li>Debe tener un formato válido</li>
                        </ul>
                    </div>
                </div>
                <div class="col-4">
                    <label for="txtFechaNac" class="form-label">Fecha de nacimiento:</label>
                    <input  type="date" id="txtFechaNac" name="fecha_nac"  class="form-control <?=$valFechaNac?>"  
                    value="<?= $usuario->fecha_nac->format('Y-m-d') ?>"
                    required>
                    <div class="invalid-feedback">
                        <ul>
                            <li>La fecha de nacimiento es un dato obligatorio</li>
                            <li>Debes tener 18 años para acceder a los servicios proporcionados por esta aplciación</li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <label for="txtContrasenia" class="form-label">Contraseña:</label>
                    <input type="password" id="txtContrasenia"  name="Password" class="form-control <?=$valPassword?>"
                    placeholder="Contraseña" required value="<?= $usuario->password ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>La contraseña es requerida</li>
                            <li>Debe tener entre 6 y 15 caracteres</li>
                        </ul>
                    </div>
                </div>

                <div class="col-6">
                    <label for="txtContrasenia2" class="form-label">Confirmar contraseña:</label>
                    <input type="password" id="txtContrasenia2" class="form-control <?=$valPassword?>"
                    placeholder="Contraseña" required value="<?= $usuario->password ?>">
                    <div class="invalid-feedback">
                        <ul>
                            <li>La contraseña es requerida</li>
                            <li>Debe tener entre 6 y 15 caracteres</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-4">
                    <p>Género:</p>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="rbtMasculino" name="Genero" value="M" 
                        checked required>
                        <label class="form-check-label" for="rbtMasculino">
                            Masculino
                        </label>  
                    </div>
                    <div class="form-check">
                        <input type="radio" id="rbtFemenino" class="form-check-input" name="Genero" Value="F"
                        <?= $usuario->genero=="F"?"checked":"" ?> required>
                        <label class="form-check-label" for="rbtFemenino">
                            Femenino
                        </label>
                        <div class="invalid-feedback">
                            <ul>
                                <li>El género es obligatorio</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <p>Puesto:</p>
                    <div >
                        <select class="form-select" name="puesto">
                            <option  >Administrador</option>
                            <option >Auxiliar</option>
                            <option >Alumno</option>
                        </select>
                    </div>
                </div>
            <div class="row justify-content-center">
                <button class="btn btn-primary col-4 mx-2">Guardar</button>
                <button type="button" id="btnVolver" class="btn btn-secondary col-4 mx-2">Cancelar</button>
            </div>
            
        </form>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/usuario.js"></script>
</body>
</html>