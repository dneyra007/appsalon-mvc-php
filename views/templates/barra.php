<div class="barra">
<p><?php echo $nombre ?? ''; ?></p>
<a class="boton" href="/logout">Logout</a>

</div>

<?php if(isset($_SESSION['admin'])) { ?>
    <div class="barra-servicios">
     <a href="/admin" class="boton">Appointments</a>
     <a href="/servicios" class="boton">Services</a>
     <a href="/servicios/crear" class="boton">New Service</a>

    </div>
<?php } ?>