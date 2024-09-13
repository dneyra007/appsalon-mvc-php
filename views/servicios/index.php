<h1 class="nombre-pagina">Services</h1>
<p class="descripcion-pagina">Services Management</p>

<?php
include_once __DIR__ . '/../templates/barra.php';

?>

<ul class="servicios">
<?php
    foreach($servicios as $servicio) { ?>
       <li>
            <p>Name: <span><?php echo $servicio->nombre;  ?></span></p>
            <p>Price: <span>$<?php echo $servicio->precio;  ?></span></p>

            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id; ?>">Update</a>
            
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">

                    <input type="submit" value="Delete" class="boton-eliminar">
                </form>
            
            </div>
       </li>
   <?php }
?>
</ul>