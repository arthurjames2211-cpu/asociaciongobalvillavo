<?php get_header( null, array( 'pagina' => 'generica' ) ); ?>
<main id="contenido">
<?php while ( have_posts() ) : the_post(); ?>
<section class="portada-pagina"><div class="contenedor"><p class="migas"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Inicio</a> / <?php the_title(); ?></p><h1><?php the_title(); ?></h1></div><svg class="ola" viewBox="0 0 1440 100" preserveAspectRatio="none" aria-hidden="true" focusable="false"><path class="o1" d="M0,52 C180,12 360,92 600,56 C840,20 1040,82 1240,44 C1330,28 1390,36 1440,46 L1440,100 L0,100 Z"/><path class="o2" d="M0,70 C220,34 420,100 700,66 C960,36 1200,92 1440,58 L1440,100 L0,100 Z"/></svg></section>
<section class="seccion"><div class="contenedor texto-wp"><?php the_content(); ?></div></section>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
