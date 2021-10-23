<!--

###################
Validación de datos
###################

RUTA: http://localhost:8080/form/form-02.php

-->

<form method="POST">
    <label for="fname">First name: *</label><br>
    <input type="text" name="first_name" value="<?php echo $_POST['first_name']; ?>"><br>
    <label for="lname">Last name:</label><br>
    <input type="text" name="last_name" value="<?php echo $_POST['last_name']; ?>">
    <input type="submit" value="Enviar">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validación
    if (empty($_POST['first_name'])) {
        echo '<span style="color:red">Nombre requerido</span><br>';
    }

    // Cláusula de guarda
    if (empty($_POST['first_name'])) {
        return;
    }

    // Persistencia de datos
    if (!is_dir($dir = __DIR__ . '/../../tmp')) {
        mkdir($dir, 0755);
    }

    $dto = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
    ];

    file_put_contents($dir . '/database.txt', json_encode($dto) . PHP_EOL, FILE_APPEND);

    // INFO
    echo "<b>EVOILÀ, YA TENEMOS DATOS VÁLIDOS!!!</b>";
}
