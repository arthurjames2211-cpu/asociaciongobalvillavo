<?php
// Recibe el formulario de contacto en el hosting (cPanel).
// Guarda cada mensaje en ../mensajes-contacto.csv (fuera de public_html, no es público)
// y, si se escribe un correo en $CORREO_DESTINO, también lo envía por correo.
$CORREO_DESTINO = ''; // ej.: 'contacto@asoimpactoverde.com'

header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo '{"ok":false}'; exit; }
if (!empty($_POST['campo-trampa'])) { echo '{"ok":true}'; exit; } // spam

function limpio($k, $max = 2000) {
  $v = isset($_POST[$k]) ? trim((string) $_POST[$k]) : '';
  $v = str_replace(["\r", "\0"], '', $v);
  return mb_substr($v, 0, $max);
}
$nombre = limpio('nombre', 120);
$telefono = limpio('telefono', 40);
$mensaje = limpio('mensaje', 3000);
$consent = !empty($_POST['consentimiento']);
if (mb_strlen($nombre) < 3 || strlen(preg_replace('/\D/', '', $telefono)) < 7 || mb_strlen($mensaje) < 10 || !$consent) {
  http_response_code(422); echo '{"ok":false}'; exit;
}
$campos = [date('Y-m-d H:i:s')];
foreach ($_POST as $k => $v) {
  if (in_array($k, ['form-name', 'campo-trampa'], true) || is_array($v)) continue;
  $campos[] = $k . ': ' . limpio($k);
}
$archivo = dirname(__DIR__) . '/mensajes-contacto.csv';
$f = @fopen($archivo, 'a');
if (!$f) { http_response_code(500); echo '{"ok":false}'; exit; }
flock($f, LOCK_EX); fputcsv($f, $campos); flock($f, LOCK_UN); fclose($f);

if ($CORREO_DESTINO) {
  $cuerpo = implode("\n", array_slice($campos, 1)) . "\n\nRecibido: " . $campos[0];
  @mail($CORREO_DESTINO, '=?UTF-8?B?' . base64_encode('Nuevo mensaje desde la página web') . '?=', $cuerpo,
    "Content-Type: text/plain; charset=UTF-8\r\nFrom: web@asoimpactoverde.com");
}
echo '{"ok":true}';
