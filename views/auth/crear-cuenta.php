<h1 class="nombre-pagina">Create an account</h1>
<p class="descripcion-pagina">Please, fill the form to create an account</p>

<?php
       include_once __DIR__ . "/../templates/alertas.php";
?>  



<form action="/crear-cuenta" class="formulario" method="POST">

    <div class="campo">
        <label for="nombre">Name</label>
        <input type="text" id="nombre" name="nombre" placeholder="Your name" value="<?php echo s($usuario->nombre);?>"/>

       
    </div>
    <div class="campo">
        <label for="apellido">Last name</label>
        <input type="text" id="apellido" name="apellido" placeholder="Your last name" value="<?php echo s($usuario->apellido);?>"/>


    </div>
    <div class="campo">
        <label for="telefono">Phone number</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Your phone" value="<?php echo s($usuario->telefono);?>"/>


    </div>
    <div class="campo">
        <label for="email">Email</label>
        <input type="tel" id="email" name="email" placeholder="Your email" value="<?php echo s($usuario->email);?>"/>


    </div>
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Your password"/>


    </div>

    <input type="submit" value="create account" class="boton">

</form>

<div class="acciones">
        <a href="/">Do you already have an account? go to login</a>
        <a href="/olvide">I forgot my password</a>

    </div>