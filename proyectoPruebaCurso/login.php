<?php
include ("Config/connection.php");
include ("Template/header.php");
?>

<div class="contenedor_form">
        <form action="" class="form" method="post">
            <h2 class="form_titulo">Login</h2>
            <p class="form_parrafo"> ¿No tienes cuenta? <a href="sign_in.php" class="form_link">¡Registrate!</a></p>

            <div class="form_contenedor">
                <div class="form_grupo">
                    <input type="text" id="leg" name="legajo"  class="form_input" placeholder="" required>
                    <label for="leg" class="form_label">Legajo</label>
                    <span class="form_linea"></span>
                </div>
                <div class="form_grupo">
                    <input type="password" id="pass" name="password" class="form_input" placeholder="" required>
                    <label for="pass" class="form_label">Contraseña</label>
                    <span class="form_linea"></span>
                </div>
            
                <input type="submit" value="Entrar" name="btn_login" class="form_submit">
                
                <?php
                    include("./Controllers/controller_login.php");
                ?>

            </div>
        </form>
    </div>

<?php
include ("Template/footer.php")
?>