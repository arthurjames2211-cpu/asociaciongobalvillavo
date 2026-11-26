<?php get_header( null, array( 'pagina' => 'noticia' ) ); ?>
<main id="contenido">
<?php while ( have_posts() ) : the_post(); ?>
<section class="portada-pagina">
  <div class="contenedor">
    <p class="migas"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a> / <a href="<?php echo esc_url( iv_url( 'noticias' ) ); ?>">Noticias</a></p>
    <h1><?php the_title(); ?></h1>
    <p><time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( iv_fecha( get_the_date( 'Y-m-d' ) ) ); ?></time></p>
  </div>
  <svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg>
</section>
<section class="seccion">
  <article class="contenedor noticia-completa">
    <?php if ( has_post_thumbnail() ) : ?>
      <figure class="foto noticia-completa__foto"><?php the_post_thumbnail( 'large' ); ?></figure>
    <?php endif; ?>
    <div class="texto-wp"><?php the_content(); ?></div>
    <p class="noticia-completa__volver"><a class="btn btn--borde" href="<?php echo esc_url( iv_url( 'noticias' ) ); ?>">Ver todas las noticias</a></p>
  </article>
</section>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
