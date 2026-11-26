<?php
$iv_pagina = isset( $args['pagina'] ) ? $args['pagina'] : 'generica';
$iv_desc   = iv_descripcion( $iv_pagina );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo esc_attr( $iv_desc ); ?>">
<meta name="theme-color" content="#0b3550">
<meta property="og:type" content="website">
<meta property="og:locale" content="es_CO">
<meta property="og:title" content="<?php echo esc_attr( wp_get_document_title() ); ?>">
<meta property="og:description" content="<?php echo esc_attr( $iv_desc ); ?>">
<meta property="og:image" content="<?php echo esc_url( is_singular( 'post' ) && has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'large' ) : IV_URI . 'img/og-image.jpg' ); ?>">
<link rel="icon" type="image/png" sizes="48x48" href="<?php echo esc_url( IV_URI . 'img/favicon-32.png' ); ?>">
<link rel="apple-touch-icon" href="<?php echo esc_url( IV_URI . 'img/apple-touch-icon.png' ); ?>">
<link rel="preload" href="<?php echo esc_url( IV_URI . 'fonts/nunito-latin-wght-normal.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?php echo esc_url( IV_URI . 'fonts/atkinson-hyperlegible-next-latin-wght-normal.woff2' ); ?>" as="font" type="font/woff2" crossorigin>
<script>try{var d=document.documentElement,t=localStorage.getItem('tam');if(t)d.dataset.tam=t;if(localStorage.getItem('contraste')==='1')d.classList.add('alto-contraste');}catch(e){}document.documentElement.classList.add('con-js');</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> data-page="<?php echo esc_attr( $iv_pagina ); ?>">
<?php wp_body_open(); ?>
