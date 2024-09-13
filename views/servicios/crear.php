<h1 class="nombre-pagina">New Service</h1>
<p class="descripcion-pagina">Register the new service</p>

<?php
include_once __DIR__ . '/../templates/barra.php';
include_once __DIR__ . '/../templates/alertas.php';

?>

<form action="/servicios/crear" class="formulario" method="POST">

<?php
include_once __DIR__ . '/formulario.php';

?>



<input type="submit" class="boton" value="Save" >

</form>