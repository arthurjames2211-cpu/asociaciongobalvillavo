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

Enlace «Saltar al contenido», botones A−/A+ para el tamaño del texto, modo de alto contraste, foco visible y respeto por `prefers-reduced-motion`. Las preferencias se recuerdan en el navegador.

## Colores y tipografía

Los colores están al inicio de `css/styles.css` (bloque `:root`). Fuentes: Montserrat (títulos) y Open Sans (texto), incluidas en `fonts/`.

## Publicación

No hay build. Netlify publica la carpeta raíz (`netlify.toml`). Cada cambio en la rama `main` se publica solo. Si no ves un cambio, recarga con Ctrl + F5 o limpia la caché (*Deploys → Trigger deploy → Clear cache and deploy site*).
