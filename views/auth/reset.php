<div class="contenedor reestablecer">
    
    <?php include_once __DIR__ . '/../templates/nombre-sitio.php'; ?>
    
    
        <div class="contenedor-sm">
        <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
        <?php if($mostrar): ?>
            <p class="descripcion-pagina">Ingresa tu nuevo password</p>
            
            <form class="formulario" method="POST">
                <div class="campo">
                    <label for="password">Nuevo Password</label>
                    <input 
                        type="password"
                        id="password"
                        placeholder="Tú Nuevo Password"
                        name="password"
                        autocomplete="off"
                    />
                </div>
                <input type="submit" class="boton" value="Guardar Password">
            </form>
        <?php endif; ?>
            <div class="acciones">
                <a href="/signup">¿Aún no tienes cuenta? Obtener Una Cuenta</a>
                <a href="/login">¿Ya tienes cuenta? Iniciar Sesión</a>
            </div>
        </div>
    
</div>