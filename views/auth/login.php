<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Insert your user and password</p>

<?php
       include_once __DIR__ . "/../templates/alertas.php";
?>  

<form action="/" class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="your email" name="email" />
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="your password" name="password" />
    </div>

    <input type="submit" class="boton" value="Login">

    </form>

    <div class="acciones">
        <a href="/crear-cuenta">Don't have an account yet? Create account</a>
        <a href="/olvide">I forgot my password</a>

    </div>