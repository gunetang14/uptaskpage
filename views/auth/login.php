<div class="contenedor login">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form action="/" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tú Email"
                    name="email"
                />
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input 
                    type="password"
                    id="password"
                    placeholder="Tú Password"
                    name="password"
                />
            </div>
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <div class="acciones">
            <a href="/signup">¿Aún no tienes cuenta? Obtener Una Cuenta</a>
            <a href="/forgot">Olvidé mi Password.</a>
        </div>
    </div>
</div>