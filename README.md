# Sitio web — Asociación Global Villavo

Sitio estático (HTML, CSS y JavaScript, sin build) para una asociación de recicladores de Villavicencio.
Todo el contenido que cambia vive en **un solo archivo: `datos.json`**.

## Páginas

Inicio · Quiénes somos · Servicios · Cómo reciclar · Rutas y horarios · Toneladas aprovechadas · Noticias · Contacto

## Cómo editar el contenido (sin programar)

1. Abre `datos.json` en GitHub (botón del lápiz ✏️) o en cualquier editor de texto.
2. Cambia solo lo que está entre comillas o dentro de `[ ]`. Los datos que faltan están en `null` o `[]`.
3. Guarda (*Commit changes*). Netlify publica el cambio en uno o dos minutos.

> Cuidado: respeta las comillas `"`, las comas `,` y los corchetes. Si algo se rompe, el sitio sigue abierto pero sin datos; revisa el archivo con https://jsonlint.com.

### Datos de la empresa y redes

```json
"empresa": {
  "nombre": "Asociación Global Villavo",
  "ciudad": "Villavicencio",
  "fundacion": 2021,
  "telefono": "608 000 0000",
  "whatsapp": "573001234567",
  "correo": "contacto@dominio.com",
  "direccion": "Carrera 1 # 2-34, barrio X",
  "horario": "Lunes a sábado, 8:00 a. m. a 5:00 p. m.",
  "mapaUrl": "https://www.google.com/maps/embed?pb=..."
},
"redes": { "facebook": "https://facebook.com/...", "instagram": "https://instagram.com/...", "tiktok": null, "youtube": null }
```

- `whatsapp`: solo números, con el 57 adelante. Con este dato aparecen el botón verde del encabezado y el flotante «¿Dudas? Escríbenos».
- `mapaUrl`: en Google Maps → *Compartir* → *Insertar un mapa* → copia solo la dirección `src="..."`.
- Una red con `null` no se muestra.

### Rutas y horarios

```json
"zonas": [
  { "nombre": "Comuna 1", "barrios": ["Barrio A", "Barrio B"], "dias": "Lunes y jueves",
    "horario": "7:00 a. m. a 12:00 m.", "reciclador": "Nombre", "telefono": "3001234567", "publicarTelefono": false }
]
```

**Teléfonos de recicladores:** solo se muestran si hay autorización escrita (Ley 1581 de 2012). Para publicar uno, pon `"publicarTelefono": true` en esa zona **y** `"mostrarTelefonosRecicladores": true` arriba en el archivo. Con `"mostrarTelefonosRecicladores": false` se ocultan todos de una vez.

### Toneladas (la gráfica se actualiza sola)

```json
"toneladas": [
  { "anio": 2026, "mes": 1, "aprovechadas": 12.4, "rechazo": 2.1 },
  { "anio": 2026, "mes": 2, "aprovechadas": 15.8, "rechazo": 2.5 }
]
```

Una línea por mes. `rechazo` es opcional (si lo pones, se calcula el porcentaje aprovechado).

### Noticias (una por semana, con archivo por año)

```json
"noticias": [
  { "titulo": "Jornada de capacitación", "fecha": "2026-11-05", "resumen": "Una línea corta.",
    "texto": "Texto completo.\nOtro párrafo.", "foto": "img/noticias/jornada.jpg", "fotoAlt": "Descripción de la foto" }
]
```

Sube la foto a la carpeta `img/noticias/` (comprímela antes: máximo ~200 KB). Las más recientes salen primero y el inicio muestra las 3 últimas.

### Galería y video

```json
"inicio": {
  "galeria": [ { "src": "img/galeria/foto1.jpg", "alt": "Recicladores clasificando material" } ],
  "video": { "src": "video/recorrido.mp4", "poster": "img/galeria/portada-video.jpg", "titulo": "Así trabajamos" }
}
```

Usa de 6 a 8 fotos buenas (recicladores con uniforme, sin basura ni piso sucio). Videos verticales (9:16), comprimidos (H.264, menos de 15 MB).

## Información pendiente (modo administrador)

El público **no ve** lo que falta. Para ver los recuadros «Información pendiente» y la lista completa, entra al sitio con `?admin=1` al final de la dirección, por ejemplo `https://tu-sitio.netlify.app/?admin=1`. Para salir: `?admin=0` o el botón de la barra inferior. La lista también está en `PENDIENTES.md`.

## Formulario de contacto

Usa Netlify Forms. Para que los mensajes lleguen a un correo:
Netlify → proyecto → **Forms** → *Form notifications* → *Add notification* → *Email notification* (form: `contacto`).
El correo debe ser de un miembro activo del equipo de Netlify. Los mensajes también quedan guardados en **Forms**.

## Accesibilidad

Enlace «Saltar al contenido», botón flotante de accesibilidad (tamaño del texto A−/A+, alto contraste y restablecer), foco visible, tipografía de alta legibilidad y respeto por `prefers-reduced-motion` (también se detienen las animaciones del ciclo). Las preferencias se recuerdan en el navegador.

## Colores, tipografía y logo

- Colores: bloque `:root` al inicio de `css/styles.css`. Azul cielo (`--c500`, `--c600`) como color de marca, verde hoja y amarillo sol como acentos.
- Fuentes: Nunito (títulos) y Atkinson Hyperlegible Next (texto, pensada para leer fácil), incluidas en `fonts/`.
- **Logo:** `img/logo.png` (720 px, fondo transparente) se usa en la portada; `img/logo-sm.png` (192 px) en el encabezado y el pie. Si cambias el logo, reemplaza esos dos archivos y genera de nuevo `img/favicon-32.png` (32 px), `img/apple-touch-icon.png` (180 px) e `img/og-image.jpg` (1200 × 630 px, la imagen que sale al compartir el enlace en WhatsApp). Si tienes el logo original en alta resolución (PNG transparente, 1500 px o más), úsalo: el actual se recortó de una captura de baja resolución.
- **WordPress:** más adelante la asociación pasará las noticias (y quizá todo el sitio) a WordPress. Este sitio está pensado para esa migración: el contenido está separado en `datos.json`.

## Versión pequeña

La asociación es pequeña (pocos afiliados y pocas rutas), así que el sitio se mantiene básico: el menú solo muestra **Toneladas** y **Noticias** cuando ya hay datos en `datos.json` (en modo administrador, `?admin=1`, siempre se ven). El inicio es corto: portada, buscador de barrio, cómo funciona, guía de materiales y llamado a pedir recolección. La escena animada del ciclo y los mosaicos de trámites se quitaron para simplificar; están en el historial de Git (commit «Rediseño Cielo») por si se quieren recuperar.

## Información regulada (Servicios y Quiénes somos)

Campos opcionales en `datos.json`: `servicios.certificados`, `servicios.contratoUrl`, `servicios.bodega`, `quienes.normatividad` (lista), `quienes.objetivoGeneral`, `quienes.objetivos` (lista), `legal.razonSocial`, `legal.nit`, `legal.representanteLegal`. Los que están vacíos no se muestran al público. En Servicios siempre aparece el bloque de peticiones, quejas, reclamos y sugerencias, que usa el formulario de contacto.

## Noticias: cómo las va a publicar la asociación

Este sitio es estático: publicar una noticia significa agregar un bloque a `noticias` en `datos.json` (y subir la foto). Es sencillo, pero no es un panel con botones. Si la persona que publicará cada semana prefiere un editor visual, hay dos caminos: (1) pasar el sitio a WordPress en el hosting que ya tiene, o (2) agregar un panel como Decap CMS sobre este mismo repositorio. Se decide con la asociación.

## Publicación

No hay build. Netlify publica la carpeta raíz (`netlify.toml`). Cada cambio en la rama `main` se publica solo. Si no ves un cambio, recarga con Ctrl + F5 o limpia la caché (*Deploys → Trigger deploy → Clear cache and deploy site*).
