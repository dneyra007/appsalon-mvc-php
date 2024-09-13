
<h1 class="nombre-pagina">Reset Password</h1>
<p class="descripcion-pagina">Write a new password:</p>

<?php
       include_once __DIR__ . "/../templates/alertas.php";
?>  

<?php if($error) return; ?>

<form action="" class="formulario" method="POST" >

    <div class="campo">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="Your new password"/>
    </div>
    <input type="submit" class="boton" value="Save new Password">

</form>

<div class="acciones">
        <a href="/">Do you already have an account? go to login</a>
        <a href="/crear-cuenta">Don't have an account yet? Create account</a>

    </div>