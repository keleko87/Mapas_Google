<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
        <?php
        require_once('database.php');
        $bd = new Database();
        
        // MOSTRAR TIPOS DE LOCALES
        $result = $bd->mostrarTipoLocales();
        
        echo "<h2>Tipos de locales</h2>
            <form method='post' action='".$_SERVER['PHP_SELF']."'>
            <p>Selecciona un tipo de local:
            <select name='tipo_local'></p>";

            if(isset($_POST['tipo_local'])){
               echo "<option>".$_POST['tipo_local']."</option>";
            }else{
                echo "<option>--- No seleccionado ---</option>";
            }

            foreach($result as $tipo_local){
                //print_r($categoria);
                extract($tipo_local);
                echo "<option value='$tipo'>$tipo</option>";        
            }

        echo "</select>
            <input type='submit' name='aceptar' value='Ver locales'/>
            </form>";
        ?>

        <?php
            require_once 'mapa.php';
        ?>
    </body>
</html>
