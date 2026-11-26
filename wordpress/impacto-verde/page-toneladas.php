<?php get_header( null, array( 'pagina' => 'toneladas' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Toneladas aprovechadas</p>
    <h1>Toneladas aprovechadas</h1>
    <p>Cuánto material recuperamos cada mes. Lo que se separa bien, se aprovecha.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor">
    <div id="t-vacio"></div>
    <div id="t-contenido">
      <div class="grafica reveal">
        <div class="grafica__cab">
          <h2>Toneladas aprovechadas por mes</h2>
          <div><label for="sel-anio" class="solo-lectores">Año</label><select id="sel-anio"></select></div>
        </div>
        <div id="t-barras"></div>
      </div>
      <div class="totales" id="t-totales"></div>
      <details class="tarjeta tarjeta--plana" style="margin-top:1.4rem">
        <summary style="cursor:pointer;font:800 1rem var(--f-titulo);min-height:44px;display:flex;align-items:center">Ver los datos en tabla</summary>
        <div class="tabla-caja" style="box-shadow:none;margin-top:1rem">
          <table id="t-tabla"><caption class="solo-lectores">Toneladas por mes</caption><thead><tr><th scope="col">Mes</th><th scope="col" class="num">Aprovechadas (t)</th><th scope="col" class="num">Rechazo (t)</th></tr></thead><tbody></tbody><tfoot></tfoot></table>
        </div>
      </details>
    </div>
  </div>
</section>

</main>
<?php get_footer(); ?>
