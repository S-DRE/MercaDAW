<script src = "../public/js/jquery-3.4.1.min.js"></script>
<script src = "/DWCC/jQueryMercaDAW/inc/menu.js"></script>

<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="index.php?load=#">MERCADAW - jQuery</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" id = "inicioLink" href = "#">Inicio</a>
      </li>
      <?php


      if(!(isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] == true)) {
        echo '<li class="nav-item">
          <a class="nav-link" id = "registroLink" href = "#">Registro</a>
        </li>';
      }
      ?>
      
      <li class="nav-item" id = "buscarAds">
        <a class="nav-link" id = "buscarAnunciosLink" href = "#">Buscar Ads</a>
      </li>
      <?php
        if(isset($_SESSION['loggedUser']) && $_SESSION['loggedUser'] == true) {
          echo '<li class="nav-item">
          <a class="nav-link" id = "publicarAnunciosClick" href = "#">Publicar Ads</a>
          </li>';
        }
      ?>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <?php
        
          if(!(isset($_SESSION['loggedUser'])) || $_SESSION['loggedUser'] == false) {
            echo '<label disabled style = "color: white; margin: 10px;"> No está logueado - Usuario Anónimo </label>';
            echo '<button type = "button" class="btn btn-secondary my-2 my-sm-0 form-control" id = "botonLoginLink">Log In</button>';
          } else {
            echo '<label style = "color: white; margin: 10px;">'.$_SESSION['nombre'].' '.$_SESSION['apellidos'].'</label>';
            echo '<button class="btn btn-secondary my-2 my-sm-0" type="button" id = "botonLogoutLink">Log Out</button>';
          }
        
      ?>
      
    </form>
    
    
    <!--
    <form class = "form-inline my-2 my-lg-0" action = "index.php?load=login">
        <label>Usuario anónimo</label>
        <button class = "btn-secondary my-2 my-sm-0" type = "submit">Log In</button>
    </form>

    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Búsqueda" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Búsqueda de Anuncios</button>
      
    </form>
    -->

  </div>
</nav>                                                                               
<div class = "cuerpo"></div>
