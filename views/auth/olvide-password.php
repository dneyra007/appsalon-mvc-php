<h1 class="nombre-pagina">Reset your password</h1>
<p class="descripcion-pagina">Please, fill your email and we will send you a link to reset your password</p>


<?php
       include_once __DIR__ . "/../templates/alertas.php";
?>  

<form action="/olvide" class="formulario" method="POST">

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" placeholder="Your email"/>

    </div>

        <input type="submit" class="boton" value="Send instructions">

</form>

<div class="acciones">
        <a href="/">Do you already have an account? go to login</a>
        <a href="/crear-cuenta">Don't have an account yet? Create account</a>

    </div>