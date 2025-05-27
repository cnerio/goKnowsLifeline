<?php
// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Leer el cuerpo de la solicitud
$data = json_decode(file_get_contents("php://input"), true);
file_put_contents("receiving2.txt", $raw);
// Verifica si llegaron datos
if (isset($data['orderId'])) {
    $nombre = $data['nombre'];
    $email = $data['email'];

    // Aquí podrías hacer alguna lógica, como guardar en base de datos

    echo json_encode([
        'status' => 'success',
        'message' => 'Datos recibidos correctamente',
        'nombre' => $nombre,
        'email' => $email
    ]);
} else {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Faltan datos requeridos (nombre y email)'
    ]);
}
