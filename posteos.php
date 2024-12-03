<?php
// Conexión a la base de datos
$servidor = "localhost";
$usuario = "root";
$contraseña = "";
$BDName = "esi";

$conn = new mysqli($servidor, $usuario, $contraseña, $BDName);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las publicaciones de la base de datos
$sql = "SELECT img, nombre, descripcion FROM info";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result->num_rows > 0) {
    echo "<h2>Publicaciones</h2>";
    echo "<div class='posteo-container'>"; // Contenedor para las tarjetas

    // Mostrar cada fila de resultados en una tarjeta
    while ($row = $result->fetch_assoc()) {
        echo "<div class='posteo'>";
        echo "<img src='" . $row['img'] . "' alt='Imagen' class='posteo-img'>";
        echo "<div class='posteo-body'>";
        echo "<h3 class='posteo-title'>" . htmlspecialchars($row['nombre']) . "</h3>";
        echo "<p class='posteo-description'>" . htmlspecialchars($row['descripcion']) . "</p>";
        echo "</div>";
        echo "</div>";
    }

    echo "</div>";
} else {
    echo "No se encontraron publicaciones.";
}

// Cerrar la conexión
$conn->close();
?>

<!-- CSS para el diseño de tarjetas -->
<style>
    body {
    margin: 0;
    color: white;
    padding: 0;
    background: rgb(131, 58, 180);
    background: linear-gradient(180deg, rgba(131, 58, 180, 1) 0%, rgba(251, 29, 253, 1) 50%, rgba(69, 252, 241, 1) 100%);
    }

    h2 {
        text-align: center;
        margin-top: 20px;
        color: #333;
    }

    .posteo-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 20px;
    }

    .posteo {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .posteo:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .posteo-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .posteo-body {
        padding: 15px;
    }

    .posteo-title {
        font-size: 1.5em;
        margin: 0 0 10px;
        color: #333;
    }

    .posteo-description {
        font-size: 1em;
        color: #555;
        line-height: 1.4;
    }
</style>
