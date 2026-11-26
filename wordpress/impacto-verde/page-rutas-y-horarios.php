<?php get_header( null, array( 'pagina' => 'rutas' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Rutas y horarios</p>
    <h1>Rutas y horarios</h1>
    <p>Elige tu zona y mira los días, el horario y a quién contactar.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor">
    <div id="rutas-info"></div>
    <div id="rutas-contenido">
      <div class="grafica__cab">
        <div><label for="sel-zona" class="h3" style="display:block;margin-bottom:.4rem">Elige tu zona</label>
        <select id="sel-zona" class="campo" style="min-width:min(100%,320px)"></select></div>
      </div>
      <div class="tabla-caja">
        <table id="tabla-rutas">
          <caption class="solo-lectores">Rutas de recolección por zona</caption>
          <thead><tr><th scope="col">Zona</th><th scope="col">Días</th><th scope="col">Horario</th><th scope="col">Contacto</th></tr></thead>
          <tbody></tbody>
        </table>
      </div>
      <p style="margin-top:1rem;color:var(--texto-suave)">¿No ves tu barrio? <a href="<?php echo esc_url( iv_url( 'contacto' ) ); ?>#formulario">Escríbenos</a> y te decimos si llegamos.</p>
    </div>
  </div>
</section>

</main>
<?php get_footer(); ?>
