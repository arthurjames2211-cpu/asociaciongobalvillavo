<?php get_header( null, array( 'pagina' => 'noticias' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Noticias</p>
    <h1>Noticias</h1>
    <p>Lo que hacemos: capacitaciones, jornadas y novedades. Aquí queda el archivo de todo lo que vamos publicando.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor">
    <div class="grafica__cab" id="n-filtro"><div><label for="n-anio" class="solo-lectores">Filtrar por año</label><select id="n-anio" class="campo" style="min-width:200px"></select></div></div>
    <div id="n-lista"></div>
  </div>
</section>

</main>
<?php get_footer(); ?>
