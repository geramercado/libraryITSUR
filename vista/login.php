<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="body">
    <div class="container py-5">
      <div class="row d-flex justify-content-center align-items-center ">
        <div class="col-xl-5">
          <div id="cartaLogin" class="card rounded-2 text-black">
            <div class="row g-0">
                <div class="card-body p-md-5 mx-md-4">
  
                  <div class="text-center">
                    <img src="imagenes/logoItsur.png"

                      style="width: 185px;" alt="logo">
                    <h4 class="mt-1 mb-5 pb-1">Biblioteca ITSUR</h4>
                  </div>
  
                  <form action="procesarLogin.php" method="post">
                    <p>Ingresar credenciales para entrar</p>
  
                    <div class="form-outline mb-4">
                      <input type="email"  class="form-control" name="correo" required
                         />
                      <label class="form-label">Usuario</label>
                    </div>
  
                    <div class="form-outline mb-4">
                      <input type="password"  class="form-control" name="password" required />
                      <label class="form-label" >Contraseña</label>
                    </div>
  
                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-success text-white btn-block fa-lg gradient-custom-2 mb-3" >Log
                        in</button>
                      <a class="text-muted" href="#!">¿Olvidaste tu contraseña?</a>
                    </div>
                    <!---
                      <div class="d-flex align-items-center justify-content-center pb-4">
                        <p class="mb-0 me-2">Don't have an account?</p>
                        <button type="button" class="btn btn-outline-danger">Create new</button>
                      </div>
                    -->
                  </form>
  
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>