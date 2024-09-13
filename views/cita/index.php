<h1 class="nombre-pagina">Get an appointment</h1>
<p class="descripcion-pagina text-center">We have an assortment of services for you:</p class="text-center">

<?php
  include_once __DIR__ . '/../templates/barra.php';
?>

<div id="app">

    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Services</button>
        <button type="button" data-paso="2">Your Info</button>
        <button type="button" data-paso="3">Your Selection</button>
    </nav>

    <div class="seccion" id="paso-1">
            <h2>Services</h2>
            <p class="text-center">Choose the services you require:</p class="text-center">
            <div class="listado-servicios" id="servicios"></div>

    </div>
    <div class="seccion" id="paso-2">
            <h2>Your info</h2>
            <p class="text-center">Insert your name, Id and date of appointment:</p class="text-center">

            <form action="" class="formulario">
                <div class="campo">
                    <label for="nombre">Name</label>
                    <input type="text" id="nombre" placeholder="your name" value= <?php echo $nombre; ?> disabled/>
                </div>
                <div class="campo">
                    <label for="fecha">Date</label>
                    <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day') ); ?>"/>
                </div>
                <div class="campo">
                    <label for="hora">time</label>
                    <input type="time" id="hora"/>
                </div>
                <input type="hidden" id="id" value="<?php echo $id; ?>">
            </form>
    </div>
    <div class="seccion contenido-resumen" id="paso-3">
            <h2>Your Selection</h2>
            <p class="text-center">Please, verify your selection:</p class="text-center">
    </div>
 
    <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Return</button>
   
        <button class="boton" id="siguiente">Next &raquo;</button>

    </div>

    </div>

    <?php 
      $script = "
      <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
      ";
      ?>