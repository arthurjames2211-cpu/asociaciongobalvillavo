<?php get_header( null, array( 'pagina' => 'reciclar' ) ); ?>
<main id="contenido">
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( iv_url( 'index' ) ); ?>">Inicio</a> / Cómo reciclar</p>
    <h1>Cómo reciclar</h1>
    <p>Una guía sencilla para separar bien: qué va en cada bolsa y qué hacer con cada material.</p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <div class="contenedor">
    <div class="pendiente" role="note"><strong>Información pendiente</strong>Esta es una guía general de separación. Confirma con la asociación qué materiales recibe cada ruta y ajusta los textos si hace falta.</div>
    <div class="seccion__cab reveal"><span class="etiqueta">Código de colores</span><h2>¿En qué bolsa va cada cosa?</h2><p class="lead">En Colombia se usan tres colores para separar los residuos en casa (Resolución 2184 de 2019).</p></div>
    <div class="bolsas reveal">
      <div class="bolsa-tipo bolsa-tipo--blanca"><i></i><div><h3>Bolsa blanca</h3><p>Aprovechables, limpios y secos: aluminio, chatarra, PET, papel, bolsas, vidrio y cartón.</p></div></div>
      <div class="bolsa-tipo bolsa-tipo--negra"><i></i><div><h3>Bolsa negra</h3><p>No aprovechables: papel higiénico, servilletas usadas, residuos de barrido y más.</p></div></div>
      <div class="bolsa-tipo bolsa-tipo--verde"><i></i><div><h3>Bolsa verde</h3><p>Orgánicos: restos de comida, cáscaras y residuos de jardín.</p></div></div>
    </div>
    <div class="seccion__cab reveal"><span class="etiqueta">Materiales</span><h2>Qué sí y qué no, material por material</h2></div>
    <nav class="indice reveal" aria-label="Materiales"><a href="#aluminio">Aluminio</a><a href="#chatarra">Chatarra</a><a href="#pet">PET</a><a href="#papel">Papel</a><a href="#bolsas">Bolsas</a><a href="#vidrio">Vidrio</a><a href="#carton">Cartón</a></nav>
    <div class="rejilla" style="gap:1.4rem">
    <article class="tarjeta tarjeta--plana material reveal" id="aluminio">
      <div class="material__cab"><div class="icono-caja" data-icon="cup-soda"></div><h3>Aluminio</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Latas de gaseosa, cerveza y energizantes</li><li>Tapas y bandejas de aluminio limpias</li><li>Papel aluminio limpio, hecho una bola</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Aerosoles con contenido</li><li>Papel aluminio con comida o grasa</li><li>Empaques metalizados de papas o galletas</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Enjuágalas y aplástalas: ocupan menos espacio.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="chatarra">
      <div class="material__cab"><div class="icono-caja" data-icon="wrench"></div><h3>Chatarra</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Ollas, tubos, varillas y herramientas viejas</li><li>Rejas, rines y piezas de hierro o acero</li><li>Cables y piezas de cobre, bronce o aluminio</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Pilas y baterías</li><li>Cilindros o tanques con gas o líquido</li><li>Electrodomésticos completos con aceite o gas</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Cuidado con los bordes filosos: empácala en una caja o costal resistente.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="pet">
      <div class="material__cab"><div class="icono-caja" data-icon="recycle"></div><h3>PET</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Botellas transparentes de agua, gaseosa y jugo</li><li>Botellas de colores del mismo plástico</li><li>Frascos de PET sin restos</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Envases de aceite de motor o químicos</li><li>Bandejas negras y vasos desechables</li><li>Icopor</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Vacíalas, enjuágalas y aplástalas de arriba hacia abajo.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="papel">
      <div class="material__cab"><div class="icono-caja" data-icon="file-text"></div><h3>Papel</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Hojas de oficina, cuadernos y revistas</li><li>Periódico, folletos y sobres</li><li>Papel de impresora usado</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Papel higiénico, servilletas y pañuelos usados</li><li>Papel con grasa o comida</li><li>Papel carbón, encerado o plastificado</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Mantenlo seco y recogido en un paquete atado: mojado pierde su valor.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="bolsas">
      <div class="material__cab"><div class="icono-caja" data-icon="shopping-bag"></div><h3>Bolsas</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Bolsas de mercado y de tiendas, limpias</li><li>Plástico flexible limpio y seco (film)</li><li>Bolsas de empaque de arroz o papel higiénico</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Empaques metalizados (papas, galletas, dulces)</li><li>Bolsas con comida o grasa</li><li>Bolsas de basura usadas</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Estíralas y mételas todas dentro de una sola bolsa grande.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="vidrio">
      <div class="material__cab"><div class="icono-caja" data-icon="wine"></div><h3>Vidrio</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Botellas de gaseosa, cerveza, licor o jugo</li><li>Frascos de conservas y salsas</li><li>Vidrio de cualquier color</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Espejos, vidrios de ventana y parabrisas</li><li>Bombillos y tubos fluorescentes</li><li>Loza, cerámica y cristalería</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Si se rompe, empácalo en una caja y márcala «vidrio» para proteger a quien lo recoge.</p>
    </article>
    <article class="tarjeta tarjeta--plana material reveal" id="carton">
      <div class="material__cab"><div class="icono-caja" data-icon="box"></div><h3>Cartón</h3></div>
      <div class="dos-col">
        <div><h4>Sí va</h4><ul class="lista-chulos"><li>Cajas de cartón corrugado</li><li>Cajas de cereal, de zapatos y de galletas</li><li>Tubos y bandejas de cartón de huevos</li></ul></div>
        <div><h4>No va</h4><ul class="lista-chulos lista-equis"><li>Cartón con grasa (caja de pizza engrasada)</li><li>Cartón mojado o con moho</li><li>Cartón plastificado o encerado</li></ul></div>
      </div>
      <p class="consejo"><strong>Consejo:</strong> Desármalo, aplánalo y guárdalo seco.</p>
    </article>
    </div>
  </div>
</section>
<section class="seccion seccion--cielo">
  <div class="contenedor dos-col">
    <div class="seccion__cab reveal" style="margin:0"><span class="etiqueta">Glosario</span><h2>Palabras que verás en el sitio</h2><p class="lead">Explicadas sin enredos.</p></div>
    <div class="glosario reveal">
      <details><summary>Residuo aprovechable</summary><p>Material que puede volver a usarse o transformarse en un producto nuevo: papel, cartón, vidrio, metales y plásticos, entre otros.</p></details>
      <details><summary>Aprovechamiento</summary><p>El conjunto de pasos que hacen que esos materiales vuelvan a la industria: recolección selectiva, transporte, clasificación y pesaje.</p></details>
      <details><summary>ECA (estación de clasificación y aprovechamiento)</summary><p>La bodega donde se recibe el material, se separa por tipo, se pesa y se alista para entregarlo.</p></details>
      <details><summary>Rechazo</summary><p>La parte del material que llega mezclada, mojada o sucia y ya no se puede aprovechar.</p></details>
      <details><summary>Ruta selectiva</summary><p>El recorrido, con día y horario, en que un reciclador pasa por un barrio para recoger el material que separaste.</p></details>
    </div>
  </div>
</section>
<section class="seccion" style="padding-top:0">
  <div class="contenedor">
    <div class="cta-final reveal">
      <h2>Ya separaste. ¿Quién lo recoge?</h2>
      <p>Mira el día y la hora en que pasa la ruta por tu barrio.</p>
      <div class="heroe__acciones"><a class="btn btn--sol btn--grande" href="<?php echo esc_url( iv_url( 'rutas-y-horarios' ) ); ?>"><span data-icon="map-pin"></span> Consultar mi ruta</a></div>
    </div>
  </div>
</section>

</main>
<?php get_footer(); ?>
