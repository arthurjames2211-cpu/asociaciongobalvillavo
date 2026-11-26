<?php get_header( null, array( 'pagina' => 'quienes' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Quiénes somos</p>
    <h1>Quiénes somos</h1>
    <p>Conoce a la asociación: nuestra historia, lo que nos mueve y las personas que hacemos este trabajo.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor">
    <div id="q-vacio"></div>
    <div id="q-historia"></div>
    <figure class="foto foto--grande reveal"><img src="<?php echo esc_url( IV_URI . 'img/fotos/grupo-celebra.webp' ); ?>" width="1600" height="900" loading="lazy" alt="Recicladores de Impacto Verde y sus familias celebrando juntos en Villavicencio"><figcaption>Somos recicladores, familias y vecinos de Villavicencio.</figcaption></figure>
  </div>
</section>

<section class="seccion seccion--cielo" id="q-video">
  <div class="contenedor video-bloque">
    <div class="reveal">
      <span class="etiqueta">En video</span>
      <h2>Conócenos en 40 segundos</h2>
      <p class="lead">Un recorrido por nuestra bodega del barrio Industrial: la recolección en la calle, el pesaje, la clasificación, las pacas y, sobre todo, la gente.</p>
      <a class="btn btn--borde" href="<?php echo esc_url( iv_url( 'servicios' ) ); ?>">Ver nuestros servicios <span data-icon="arrow-right"></span></a>
    </div>
    <video class="video-vertical reveal" controls playsinline preload="none" poster="<?php echo esc_url( IV_URI . 'img/fotos/tour-v2-portada.jpg' ); ?>" width="540" height="960"><source src="<?php echo esc_url( IV_URI . 'video/tour-v2.mp4' ); ?>" type="video/mp4">Tu navegador no puede reproducir este video.</video>
  </div>
</section>
<section class="seccion seccion--cielo" id="q-sec-mv">
  <div class="contenedor">
    <div class="rejilla rejilla--2" id="q-mv"></div>
    <div class="obj-bloque" id="q-obj"></div>
  </div>
</section>
<section class="seccion" id="q-social-sec">
  <a id="trabajo-social"></a>
  <div class="contenedor">
    <div class="seccion__cab reveal"><span class="etiqueta">Más que reciclaje</span><h2>Trabajo social</h2></div>
    <div id="q-social"></div>
  </div>
</section>
<section class="seccion seccion--cielo" id="q-sec-equipo">
  <div class="contenedor">
    <div class="seccion__cab reveal"><span class="etiqueta">Las personas</span><h2>Nuestro equipo</h2></div>
    <div id="q-equipo"></div>
  </div>
</section>
<section class="seccion" id="q-sec-info">
  <div class="contenedor dos-col">
    <div id="q-col-certs"><div class="seccion__cab reveal"><span class="etiqueta">Confianza</span><h2>Certificaciones y registros</h2></div><div id="q-certs"></div></div>
    <div id="q-col-legal"><div class="seccion__cab reveal"><span class="etiqueta">Transparencia</span><h2>Datos de la organización</h2></div><div id="q-legal"></div></div>
  </div>
</section>
<section class="seccion seccion--cielo" id="q-sec-norma">
  <div class="contenedor">
    <div class="seccion__cab reveal"><span class="etiqueta">Normatividad</span><h2>Las normas que cumplimos</h2></div>
    <div id="q-norma"></div>
  </div>
</section>

</main>
<?php get_footer(); ?>
