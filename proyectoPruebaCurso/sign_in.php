<?php
include ("Config/connection.php");
include ("Template/header.php");
?>

<div class="contenedor_form">
        <form action="" class="form" method="post">
            <h2 class="form_titulo">Sign In</h2>
            <p class="form_parrafo"> Complete con sus datos para registrarse</p>

            <div class="form_contenedor">
                <div class="form_grupo">
                    <input type="text" id="leg" name="legajo"  class="form_input" placeholder="" value="<?php if(isset($_POST["legajo"])) echo $_POST["legajo"] ?>" required>
                    <label for="leg" class="form_label">Legajo</label>
                    <span class="form_linea"></span>
                </div>
                <div class="form_grupo">
                    <input type="password" id="pass" name="password" class="form_input" placeholder="" value="<?php if(isset($_POST["password"])) echo $_POST["password"] ?>" required>
                    <label for="pass" class="form_label">Contraseña</label>
                    <span class="form_linea"></span>
                </div>
                <div class="form_grupo">
                    <input type="text" id="nom" name="name" class="form_input" placeholder="" value="<?php if(isset($_POST["name"])) echo $_POST["name"] ?>" required>
                    <label for="nom" class="form_label">Nombre</label>
                    <span class="form_linea"></span>
                </div>
                <div class="form_grupo">
                    <input type="text" id="ape" name="surname" class="form_input" placeholder="" value="<?php if(isset($_POST["surname"])) echo $_POST["surname"] ?>" required>
                    <label for="ape" class="form_label">Apellido</label>
                    <span class="form_linea"></span>
                </div>
                <div class="form_grupo">
                    <input type="text" id="e_mail" name="mail" class="form_input" placeholder="" value="<?php if(isset($_POST["mail"])) echo $_POST["mail"] ?>" required>
                    <label for="e_mail" class="form_label">Email</label>
                    <span class="form_linea"></span>
                </div>
            
                <input type="submit" value="Registrarse" name="btn_sign_in" class="form_submit" required>
                
                <?php
                    include("./Controllers/controller_sign_in.php");
                ?>

            </div>
        </form>
    </div>
    <!-- agregamos script js para evitar reenvio del form al recargar pagina -->
    <script type="module" src="./Js/browser_history.js"></script>
<?php
include ("Template/footer.php")
?>