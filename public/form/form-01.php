<!--

#######################
Form tradicional en PHP
#######################

Notas:
- Si no se indica el atributo action en el form, se hará post sobre la misma url
- El campo idenfiticativo de los elementos de formulario es el "name" NO el id.
- RUTA: http://localhost:8080/form/form-01.php

-->

<!-- 1.- CREACIÓN -->
<form method="POST">

    <!-- 2.- ESTABLECIMIENTO -->
    <label for="fname">First name:</label><br>
    <input type="text" name="first_name" id="the_first_name_id" value="<?php echo $_POST['first_name']; ?>"><br>

    <!-- 2.- ESTABLECIMIENTO -->
    <label for="lname">Last name:</label><br>
    <input type="text" name="last_name" id="the_last_name_id" value="<?php echo $_POST['last_name']; ?>">

    <input type="submit" value="Enviar">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 3.- CAPTURA DE DATOS
    $dto = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
    ];

    // LA VALIDACIÓN la veremos en el siguiente ejemplo

    if (!is_dir($dir = __DIR__ . '/../../tmp')) {
        mkdir($dir, 0755);
    }

    // 5.- TRATAMIENTO DE DATOS
    file_put_contents($dir . '/contact_form_php.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);


    // DEBUG VISUAL
    echo '<b>ME HAN HECHO CLICK!!!</b>';
    echo '<br><hr>';
    echo '<b>Valor en crudo</b>: ';
    echo var_dump($_POST);
    echo '<br><hr>';
    echo 'Valor de First Name: "' . $_POST['first_name'] . '"<br>';
    echo sprintf('Valor de Last Name: "%s".<br>', $_POST['last_name']);
}


