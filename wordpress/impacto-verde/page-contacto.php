<?php get_header( null, array( 'pagina' => 'contacto' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Contacto</p>
    <h1>Contacto</h1>
    <p>Escríbenos para pedir una recolección, resolver una duda o presentar una petición, queja, reclamo o sugerencia.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor contacto-grid">
    <div class="tarjeta tarjeta--plana reveal">
      <h2>Escríbenos</h2>
      <div id="f-aviso" class="aviso-form" hidden></div>
      <form class="form" id="formulario" name="contacto" method="POST" action="/contacto?enviado=1" data-netlify="true" netlify-honeypot="campo-trampa" novalidate>
        <input type="hidden" name="form-name" value="contacto">
        <input type="hidden" name="subject" value="Nuevo mensaje desde el sitio web (%{formName})">
        <p class="trampa" aria-hidden="true"><label>No llenes este campo: <input name="campo-trampa" tabindex="-1" autocomplete="off"></label></p>
        <div class="form__fila">
          <div><label for="f-nombre">Nombre</label><input class="campo" id="f-nombre" name="nombre" type="text" autocomplete="name" required></div>
          <div><label for="f-telefono">Teléfono</label><input class="campo" id="f-telefono" name="telefono" type="tel" inputmode="tel" autocomplete="tel" required></div>
        </div>
        <div class="form__fila">
          <div><label for="f-correo">Correo <span style="font-weight:400">(opcional)</span></label><input class="campo" id="f-correo" name="correo" type="email" inputmode="email" autocomplete="email" spellcheck="false"></div>
          <div><label for="f-barrio">Barrio <span style="font-weight:400">(opcional)</span></label><input class="campo" id="f-barrio" name="barrio" type="text" list="lista-barrios" autocomplete="off"><datalist id="lista-barrios"></datalist></div>
        </div>
        <div><label for="f-asunto">Asunto</label>
          <select class="campo" id="f-asunto" name="asunto" required>
            <option value="">Elige una opción</option>
            <option value="solicitud">Solicitud (pedir una recolección o información)</option>
            <option value="peticion">Petición</option>
            <option value="queja">Queja</option>
            <option value="reclamo">Reclamo</option>
            <option value="sugerencia">Sugerencia</option>
          </select></div>
        <div><label for="f-mensaje">Mensaje</label><textarea class="campo" id="f-mensaje" name="mensaje" required></textarea></div>
        <div>
          <label class="form__consent" style="font-weight:400;font-family:var(--f-texto)"><input type="checkbox" name="consentimiento" value="si" required><span id="consent-texto"></span></label>
          <div id="consent-pend"></div>
        </div>
        <button class="btn btn--grande" type="submit"><span>Enviar mensaje</span></button>
      </form>
    </div>
    <aside>
      <div class="tarjeta tarjeta--plana reveal">
        <h2>Datos de contacto</h2>
        <ul class="datos-contacto" id="c-datos"></ul>
      </div>
      <div class="reveal" id="c-redes" style="margin-top:1.4rem"></div>
      <figure class="foto foto--fachada reveal"><img src="<?php echo esc_url( IV_URI . 'img/fotos/fachada-letrero.webp' ); ?>" width="900" height="1542" loading="lazy" alt="Fachada de la bodega de Impacto Verde con su portón verde y el mural de la asociación"><figcaption>Busca el portón verde con el mural de Impacto Verde.</figcaption></figure>
    </aside>
  </div>
</section>
<section class="seccion seccion--cielo" id="c-sec-mapa">
  <div class="contenedor">
    <div class="seccion__cab reveal"><span class="etiqueta">Cómo llegar</span><h2>Encuéntranos</h2></div>
    <div id="c-mapa"></div>
  </div>
</section>

</main>
<?php get_footer(); ?>
