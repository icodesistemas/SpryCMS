
<div class="login-form padding20 block-shadow">
    <form method="post">
        <h1 class="text-light">Inicio de Sesión</h1>
        <hr class="thin"/>
        <div class="input-control modern text iconic" style="width: 90%">
            <input type="text" name="user_login" id="user_login" required = "required" value="<?= (isset($_POST['user_login']) ? $_POST['user_login'] : '' ) ?>">
            <span class="label">Campo de Usuario</span>
            <span class="informer">Ingrese su usaurio o correo electronico</span>
            <span class="placeholder">Campo de Usuario</span>
            <span class="icon mif-user"></span>
        </div>
        <br />
        <div class="input-control modern password iconic" data-role="input" style="width: 90%">
            <input type="password" name="user_password" id="user_password">
            <span class="label">Campo de Contraseña</span>
            <span class="informer">Ingrese su contraseña de accesos</span>
            <span class="placeholder">Campo de Contraseña</span>
            <span class="icon mif-lock"></span>
            <button class="button helper-button reveal"><span class="mif-looks"></span></button>
        </div>



        <br /> <br />
        <div class="form-actions">
            <button type="submit" class="button primary">Ingresar</button>
            <button type="button" class="button link">Recuperar datos de acceso</button>
        </div>
        <input type="hidden" name = "action" value = "login">
    </form>
</div>