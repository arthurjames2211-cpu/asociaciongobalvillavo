<?php get_header( null, array( 'pagina' => '404' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Página no encontrada</p>
    <h1>Página no encontrada</h1>
    <p>Esta dirección no existe o cambió de lugar.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion"><div class="contenedor"><div class="vacio"><p>Puedes volver al inicio o consultar la ruta de tu barrio.</p><p><a class="btn" href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Ir al inicio</a> <a class="btn btn--borde" href="<?php echo esc_url( iv_url( 'rutas-y-horarios' ) ); ?>">Rutas y horarios</a></p></div></div></section>

</main>
<?php get_footer(); ?>
