<?php
session_start();

// Configuración de la base de datos
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$BDName = "esi";

// Conexión a la base de datos
$conn = new mysqli($servidor, $usuario, $contraseña, $BDName);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Definir el directorio de destino para las imágenes
$target_dir = "uploads/";

// Crear el directorio si no existe
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); 
}

// Comprobar si se ha enviado una imagen
if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
    $img = $_FILES['img']['name'];
    $target_file = $target_dir . basename($img);
    
    // Verificar que el archivo sea una imagen (opcional, para mayor seguridad)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Solo se permiten archivos de imagen (JPG, PNG, JPEG, GIF).";
    } else {
        // Intentar mover la imagen al directorio de destino
        if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
            // Obtener los datos del formulario
            $descripcion = isset($_POST['descripcion']) ? $_POST['descripcion'] : '';
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';

            // Verificar que los campos no estén vacíos
            if ($nombre != '' && $descripcion != '') {
                // Insertar los datos en la base de datos
                $sql = "INSERT INTO info (img, nombre, descripcion) VALUES ('$target_file', '$nombre', '$descripcion')";
                
                if ($conn->query($sql) === TRUE) {
                    echo '<script>alert("Publicación agregada con éxito.");</script>';
                } else {
                    echo "Error al agregar la publicación: " . $conn->error;
                }
            } else {
                echo "Los campos de nombre y descripción son obligatorios.";
            }
        } else {
            echo "Error al subir la imagen.";
        }
    }
} else {
    echo "No se ha enviado ninguna imagen o ha ocurrido un error durante la carga.";
}

// Cerrar la conexión
$conn->close();
?>
