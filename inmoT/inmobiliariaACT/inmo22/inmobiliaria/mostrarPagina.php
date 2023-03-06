<?php
// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "inmobiliaria");
if(mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}

// Consulta para obtener las páginas
$sql = "SELECT * FROM paginas";
$resultado = mysqli_query($conn, $sql);


// Generar el HTML para mostrar las páginas
$html_paginas = "";
$contador = 0;
while($fila = mysqli_fetch_assoc($resultado)) {
    $titulo = $fila["titulo"];
    $contenido = $fila["contenido"];
    $imagen_ruta = $fila["imagen_ruta"];
    
    // Generar el HTML para mostrar una página
    $html_imagen = "";
    if(!empty($imagen_ruta)) {
        $html_imagen .= "<div class='card mt-4'>";
        $html_imagen .= "<img class='card-img-top' src='$imagen_ruta'>";
        $html_imagen .= "<div class='card-body'>";
        $html_imagen .= "<p class='card-text'>$contenido</p>";
        $html_imagen .= "<a href='#' class='btn btn-primary'>visitar</a>";
        $html_imagen .= "</div></div>";
    }
    
    if ($contador % 3 == 0) {
        if ($contador > 0) {
            $html_paginas .= "</div>";
        }
        $html_paginas .= "<div class='row'>";
    }
    
    $html_paginas .= "<div class='col-sm-4'>";
    $html_paginas .= $html_imagen;
    $html_paginas .= "</div>";
    
    $contador++;
}
// Cerrar la última fila
if ($contador > 0) {
    $html_paginas .= "</div>";
}


if(isset($_GET['actualizar']) && $_GET['actualizar'] == 1) {
    // actualizar la página en la base de datos aquí
    $nombre_archivo = $_FILES["imagen"]["name"];
    $tipo_archivo = $_FILES["imagen"]["type"];
    $tamano_archivo = $_FILES["imagen"]["size"];
    $temp_archivo = $_FILES["imagen"]["tmp_name"];
    $carpeta_destino = "imagenes/";
    $ruta_archivo = $carpeta_destino . $nombre_archivo;
    
    // Verificar que el archivo sea una imagen y no exceda el tamaño máximo permitido
    $es_imagen = strpos($tipo_archivo, "image") !== false;
    $tamano_maximo = 1000000; // 1 MB
    $es_tamano_valido = $tamano_archivo <= $tamano_maximo;
    
    if($es_imagen && $es_tamano_valido) {
        move_uploaded_file($temp_archivo, $ruta_archivo);
        $sql = "UPDATE paginas SET imagen_ruta='$ruta_archivo' WHERE id=$id_pagina";
        mysqli_query($conn, $sql);
    }
}




// mostrar la página aquí

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>

  

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">


  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
   
  <link rel="stylesheet" href="styles.css">

</head>

<body>

          <div class="navbarOrange">

            <div class="row">
              <div class="col px-5">
                Crta. Granada, Esquina Reyes Católicos | BAZA
              </div>

              <div class="col px-5">

                <h2>60789865</h2>

              </div>
            </div>
          </div>


          <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
              <a class="navbar-brand navbar" href="index.html"><img src="logoLogin.png" style="width: 100px;"> </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                  <li class="nav-item">
                    <a class="nav-link navbarT" href="#">EMPRESAS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link navbarT" href="#">SERVICIOS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link  navbarT">LOCALIZACIONES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link  navbarT">BUSCAR INMUEBLES</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link  navbarT">SIMULADOR HIPOTECAS</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link  navbarT">CONTACTAR</a>
                  </li>
                </ul>

                <form class="d-flex ms-5" role="search">
                  <input class="form-control me-2" type="search" placeholder="ej. Caniles" aria-label="Search">
                  <button class="btn btn-outline-light" type="submit">VENTA</button>
                  <button class="btn btn-outline-light" type="submit">ALQUILER</button>
                </form>
              </div>
            </div>
          </nav>

        

     


          <div class="row">
            <div class="col">

            </div>
            <div class="col-10 p-4">
              <img src="header.jpg" style="width: 100%;">




            </div>
            <div class="col">

            </div>
          </div>

          <div class="row text-center">
            <h1 style="color:orange ; padding:10px"><strong>DESTACADOS</strong></h1>
          </div>

          <?php //include 'admin.php'; ?>
                <?php echo $html_paginas; ?>

          <div class="row">
            <div class="col-4 mt-4">

              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/3.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="casa1.html" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 3 dias
                </div>
              </div>

            </div>

            <div class="col-4 mt-4">
              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/2.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 1 dia
                </div>
              </div>



            </div>
            <div class="col-4 mt-4">
              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/1.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 20 horas
                </div>
              </div>


            </div>
          </div>

          <div class="row">
            <div class="col-4 mt-4">

              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/3.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 3 dias
                </div>
              </div>

            </div>

            <div class="col-4 mt-4">
              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/2.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 1 dia
                </div>
              </div>



            </div>
            <div class="col-4 mt-4">
              <div class="card text-center">
                <div class="card-header">
                  <img src="/inmo22/inmobiliaria/1.png">
                </div>
                <div class="card-body">
                  <h5 class="card-title">Special title treatment</h5>
                  <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                  <a href="#" class="btn btn-primary">visitar</a>
                </div>
                <div class="card-footer text-muted">
                  Hace 20 horas
                </div>
              </div>


            </div>
          </div>
        

       
      </div>
    </div>
  </div>



<!-- CARDS-->


<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
<div class="c">

  <section class="hero-section">
    <div class="card-grid">
      <a class="card" href="#">
        <div class="card__background" style="background-image: url(/inmobiliariaACT/inmo22/inmobiliaria/cards/1.jpg)"></div>
        <div class="card__content">
          
        </div>
      </a>
      <a class="card" href="#">
        <div class="card__background" style="background-image: url(/inmobiliariaACT/inmo22/inmobiliaria/cards/2.jpg)"></div>
        <div class="card__content">
          
        </div>
      </a>
      <a class="card" href="#">
        <div class="card__background" style="background-image: url(/inmobiliariaACT/inmo22/inmobiliaria/cards/3.jpg)"></div>
        <div class="card__content">
          <p class="card__category"></p>
          
        </div>
      </li>
      <a class="card" href="#">
        <div class="card__background" style="background-image: url(/inmobiliariaACT/inmo22/inmobiliaria/cards/4.jpg)"></div>
        <div class="card__content">
      
        </div>
      </a>
    <div>
  </section>
  






</div>











    <footer class="bg-light py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <h5>Nosotros</h5>
            <ul class="list-unstyled">
              <li><a href="#">Acerca de nosotros</a></li>
              <li><a href="#">Nuestro equipo</a></li>
              <li><a href="#">Nuestra historia</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5>Servicios</h5>
            <ul class="list-unstyled">
              <li><a href="#">Ventas</a></li>
              <li><a href="#">Alquileres</a></li>
              <li><a href="#">Asesoramiento</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5>Contacto</h5>
            <ul class="list-unstyled">
              <li><a href="#">Dirección</a></li>
              <li><a href="#">Teléfono</a></li>
              <li><a href="#">Correo electrónico</a></li>
            </ul>
          </div>
          <div class="col-lg-3 col-md-6">
            <h5>Síguenos</h5>
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
              </svg></a></li>
              <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter" viewBox="0 0 16 16">
                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
              </svg></a></li>
              <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"/>
              </svg></a></li>
              <li class="list-inline-item"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">
                <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854V1.146zm4.943 12.248V6.169H2.542v7.225h2.401zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248-.822 0-1.359.54-1.359 1.248 0 .694.521 1.248 1.327 1.248h.016zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016a5.54 5.54 0 0 1 .016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225h2.4z"/>
              </svg></a></li>
            </ul>
          </div>
        </div>
        <hr>
        <p class="text-center text-muted small">Copyright &copy; RinconDelMueble 2022</p>
      </div>
    </footer>
    

  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
  <script src="script.js"></script>
</body>


</html>