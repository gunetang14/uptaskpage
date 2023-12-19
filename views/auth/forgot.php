<div class="contenedor olvide">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Ingresa tu Email para recuperar el password</p>
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <form action="/forgot" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email</label>
                <input 
                    type="email"
                    id="email"
                    placeholder="Tú Email"
                    name="email"
                    autocomplete="off"
                />
            </div>
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <div class="acciones">
            <a href="/signup">¿Aún no tienes cuenta? Obtener Una Cuenta</a>
            <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
        </div>
    </div>
</div>