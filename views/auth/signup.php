<div class="contenedor crear">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu Cuenta en UpTask</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form action="/signup" class="formulario" method="POST">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input 
                    type="text"
                    id="nombre"
                    placeholder="Tú Nombre"
                    name="nombre"
                    value="<?php echo $usuario->nombre; ?>"
                    autocomplete="off"
                />
            </div>
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tú Email"
                    name="email"
                    value="<?php echo $usuario->email; ?> "
                    autocomplete="off"
                />
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tú Password"
                    name="password"
                    autocomplete="off"
                />
            </div>
            <div class="campo">
                <label for="password2">Repetir Password</label>
                <input 
                    type="password"
                    id="password2"
                    placeholder="Repite Tú Password"
                    name="password2"
                    autocomplete="off"
                />
            </div>
            <input type="submit" class="boton" value="Crear Cuenta">
        </form>
        <div class="acciones">
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
            <a href="/forgot">Olvidé mi Password.</a>
        </div>
    </div>
</div>