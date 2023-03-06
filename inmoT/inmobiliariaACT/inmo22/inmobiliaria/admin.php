<!doctype html>
<html lang="en">

<head>
  <title>
    
  </title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="styles3.css" type="text/css" rel="stylesheet">


  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

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

      <button class="btn btn-outline-danger btn-lg">ADMINISTRADOR</button>
    </form>
  </div>
</div>
</nav>


 
<?php

session_start();

// Conexión a la base de datos
$conn = mysqli_connect("localhost", "root", "", "inmobiliaria");
if(mysqli_connect_errno()) {
    die("Error al conectar a la base de datos: " . mysqli_connect_error());
}
// Agregar una página
if(isset($_POST['titulo']) && isset($_POST['contenido'])) {
    $titulo = $_POST['titulo'];
    $contenido = $_POST['contenido'];
    $ruta_imagen = "imagenes/";
    if(isset($_FILES['imagen'])) {
        $nombre_imagen = $_FILES['imagen']['name'];
        $ruta_imagen = "imagenes/" . $nombre_imagen;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_imagen);
    }
    $sql = "INSERT INTO paginas (titulo, contenido, imagen_ruta) VALUES ('$titulo', '$contenido', '$ruta_imagen')";
    mysqli_query($conn, $sql);
}

// Editar una página
if(isset($_POST['id']) && isset($_POST['titulo_editar']) && isset($_POST['contenido_editar'])) {
    $id = $_POST['id'];
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo_editar']);
    $contenido = mysqli_real_escape_string($conn, $_POST['contenido_editar']);
    $ruta_imagen = "";
    if(isset($_FILES['imagen_editar']) && $_FILES['imagen_editar']['size'] > 0) {
        $nombre_imagen = $_FILES['imagen_editar']['name'];
        $ruta_imagen = "imagenes/" . $nombre_imagen;
        move_uploaded_file($_FILES['imagen_editar']['tmp_name'], $ruta_imagen);
    }
    $sql = "UPDATE paginas SET titulo='$titulo', contenido='$contenido', imagen_ruta='$ruta_imagen' WHERE id='$id'";
    mysqli_query($conn, $sql);
}







 // Eliminar una página
if(isset($_POST['id_eliminar'])) {
  $id = $_POST['id_eliminar'];
  $sql = "DELETE FROM paginas WHERE id=$id";
  mysqli_query($conn, $sql);
  }
  ?>
  <div class="row">
    <div class="col">

    </div>
    <div class="col">
    
    <h2>AGREGAR CASA</h2>

    </div>

    <div class="col">

    </div>
  </div>


<!-- Agregar página -->

<form method="post" enctype="multipart/form-data" class="form p-5">
    <div class="form-group">
        <label for="titulo">Título:</label>
        <input type="text" class="form-control" id="titulo" name="titulo">
    </div>
    <div class="form-group">
        <label for="contenido">Contenido:</label>
        <textarea class="form-control" id="contenido" name="contenido"></textarea>
    </div>
    <div class="form-group">
        <label for="imagen" style="margin-top=10px">Imagen:</label>
        <input type="file" class="form-control-file" id="imagen" name="imagen">
    </div>
    <button type="submit" class="btn btn-primary mt-4">Agregar</button>
</form>

<!-- Editar página -->
<h2>Editar página</h2>
<table class="table">
    <thead>
        <tr>
            <th>Título</th>
            <th>Contenido</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM paginas";
            $result = mysqli_query($conn, $sql);
         
            while($fila = mysqli_fetch_assoc($result)) 
            {
                echo "<tr>";
                echo "<td>" . $fila['titulo'] . "</td>";
                echo "<td>" . $fila['contenido'] . "</td>";
                if($fila['imagen_ruta'] != "") {
                    echo "<td><img src='" . $fila['imagen_ruta'] . "' width='100'></td>";
                } else {
                    echo "<td></td>";
                }
                echo "<td>";
                echo "<button class='btn btn-primary mx-3' onclick='editar(" . $fila['id'] . ")'>Editar</button>";
                echo "<form method='post' style='display: inline-block;'>";
                echo "<input type='hidden' name='id_eliminar' value='" . $fila['id'] . "'>";
                echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        ?>
    </tbody>
</table>

<!-- Formulario de edición -->
<div id="formulario_edicion" style="display: none;">
    <h3>Editar página</h3>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id_editar">
        <div class="form-group">
            <label for="titulo_editar">Título:</label>
            <input type="text" class="form-control" id="titulo_editar" name="titulo_editar">
        </div>
        <div class="form-group">
            <label for="contenido_editar">Contenido:</label>
            <textarea class="form-control" id="contenido_editar" name="contenido_editar"></textarea>
        </div>
        <div class="form-group">
            <label for="imagen_editar">Imagen:</label>
            <input type="file" class="form-control-file" id="imagen_editar" name="imagen_editar">
        </div>
        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <button type="button" class="btn btn-danger" onclick="cancelar()">Cancelar</button>
             </form>
         </div>
</div>

<?php
echo "<a href='mostrarPagina.php'><button class='btn btn-warning'>Ver página</button></a>";
?>

    <script>

function editar(id) {
           // Obtener los datos de la página a editar mediante AJAX
           var xhr = new XMLHttpRequest();
           xhr.onreadystatechange = function() {
               if(this.readyState == 4 && this.status == 200) {
                   var pagina = JSON.parse(this.responseText);
                   document.getElementById("id_editar").value = pagina.id;
                   document.getElementById("titulo_editar").value = pagina.titulo;
                   document.getElementById("contenido_editar").value = pagina.contenido;
                   document.getElementById("formulario_edicion").style.display = "block";
               }
           };
           xhr.open("GET", "editar_pagina.php?id=" + id, true);
           xhr.send();
       }
       function cancelar() {
           document.getElementById("formulario_edicion").style.display = "none";
       }
   </script>


</body>
   </html>
   <?php
   // Cerrar la conexión a la base de datos
   mysqli_close($conn);
   ?>












  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>