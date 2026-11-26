<?php
/**
 * Tema Impacto Verde.
 * - Las noticias son las Entradas de WordPress (en el menú se llaman "Noticias").
 * - Datos de contacto y textos del inicio: Apariencia → Personalizar → Datos de la asociación.
 * - Los mensajes del formulario de contacto quedan en el menú "Mensajes".
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'IV_VER', wp_get_theme()->get( 'Version' ) );
define( 'IV_URI', trailingslashit( get_template_directory_uri() ) );
define( 'IV_DIR', trailingslashit( get_template_directory() ) );

/* Páginas del sitio: slug de WordPress ⇄ nombre del archivo estático */
function iv_paginas() {
	return array(
		'quienes-somos'    => 'Quiénes somos',
		'servicios'        => 'Servicios',
		'como-reciclar'    => 'Cómo reciclar',
		'rutas-y-horarios' => 'Rutas y horarios',
		'toneladas'        => 'Toneladas aprovechadas',
		'noticias'         => 'Noticias',
		'contacto'         => 'Contacto',
	);
}

function iv_url( $slug ) {
	if ( 'index' === $slug || 'inicio' === $slug ) { return home_url( '/' ); }
	if ( 'noticias' === $slug ) {
		$id = (int) get_option( 'page_for_posts' );
		if ( $id ) { return get_permalink( $id ); }
	}
	$p = get_page_by_path( $slug );
	return $p ? get_permalink( $p ) : home_url( '/' . $slug . '/' );
}

function iv_fecha( $ymd ) {
	$m = array( 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre' );
	list( $a, $mes, $d ) = array_map( 'intval', explode( '-', $ymd ) );
	return $d . ' de ' . $m[ $mes - 1 ] . ' de ' . $a;
}

function iv_descripcion( $pagina ) {
	static $d = null;
	if ( null === $d ) { $d = json_decode( '{"inicio": "Consulta tu ruta, aprende a separar tus residuos y pide una recolección de material reciclable.", "quienes": "Historia, misión, visión, equipo y certificaciones de la asociación de recicladores.", "servicios": "Materiales que recibimos, qué recolectamos y cómo pedir una recolección.", "reciclar": "Guía para separar aluminio, chatarra, PET, papel, bolsas, vidrio y cartón, y qué va en cada bolsa.", "rutas": "Consulta los días y horarios de recolección de tu zona.", "toneladas": "Gráfica mensual y total anual de las toneladas de material aprovechado.", "contacto": "Escríbenos por WhatsApp o por el formulario: solicitudes, peticiones, quejas, reclamos y sugerencias.", "noticias": "Noticias y novedades de la asociación de recicladores.", "404": "Página no encontrada."}', true ); }
	if ( 'noticia' === $pagina && is_singular() ) { return wp_strip_all_tags( get_the_excerpt() ); }
	return isset( $d[ $pagina ] ) ? $d[ $pagina ] : get_bloginfo( 'description' );
}

/* ---------- Soporte del tema ---------- */
add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
} );

add_filter( 'document_title_separator', function () { return '·'; } );

/* ---------- Estilos y código ---------- */
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'iv-estilos', IV_URI . 'css/styles.css', array(), IV_VER );
	wp_enqueue_style( 'iv-wp', IV_URI . 'css/wp.css', array( 'iv-estilos' ), IV_VER );
	wp_enqueue_script( 'iv-iconos', IV_URI . 'js/icons.js', array(), IV_VER, array( 'strategy' => 'defer' ) );
	wp_enqueue_script( 'iv-app', IV_URI . 'js/app.js', array( 'iv-iconos' ), IV_VER, array( 'strategy' => 'defer' ) );
	$rutas = array( 'index' => home_url( '/' ) );
	foreach ( array_keys( iv_paginas() ) as $s ) { $rutas[ $s ] = iv_url( $s ); }
	wp_add_inline_script( 'iv-iconos', 'window.IV_CFG=' . wp_json_encode( array(
		'base'     => home_url( '/' ),
		'tema'     => IV_URI,
		'datos'    => rest_url( 'impacto/v1/datos' ),
		'contacto' => rest_url( 'impacto/v1/contacto' ),
		'rutas'    => $rutas,
	) ) . ';', 'before' );
	// WordPress agrega estilos de bloques que no usamos en el sitio
	wp_dequeue_style( 'global-styles' );
	wp_dequeue_style( 'classic-theme-styles' );
}, 20 );

/* El panel superior de WordPress (cuando inician sesión) empuja la cabecera flotante */
add_action( 'wp_head', function () {
	if ( is_admin_bar_showing() ) {
		echo '<style>.cab{top:calc(var(--wp-admin--admin-bar--height,32px) + .6rem)!important}</style>';
	}
} );

/* ---------- Datos que lee la página (datos.json + lo que se edita en WordPress) ---------- */
function iv_opciones() {
	return array(
		'empresa.telefono'        => array( 'Teléfono principal', 'text' ),
		'empresa.telefono2'       => array( 'Otro teléfono', 'text' ),
		'empresa.whatsapp'        => array( 'WhatsApp (con 57 adelante, sin espacios. Ej: 573115253957)', 'text' ),
		'empresa.whatsappVisible' => array( 'WhatsApp como se muestra (Ej: 311 525 3957)', 'text' ),
		'empresa.correo'          => array( 'Correo', 'email' ),
		'empresa.direccion'       => array( 'Dirección', 'text' ),
		'empresa.horario'         => array( 'Horario de atención', 'text' ),
		'redes.instagram'         => array( 'Enlace de Instagram', 'url' ),
		'redes.facebook'          => array( 'Enlace de Facebook', 'url' ),
		'redes.tiktok'            => array( 'Enlace de TikTok', 'url' ),
		'inicio.titular'          => array( 'Título grande del inicio', 'text' ),
		'inicio.subtitulo'        => array( 'Texto debajo del título', 'textarea' ),
	);
}

function iv_datos() {
	$d = json_decode( file_get_contents( IV_DIR . 'datos.json' ), true );
	if ( ! is_array( $d ) ) { $d = array(); }
	foreach ( iv_opciones() as $clave => $info ) {
		$v = get_theme_mod( 'iv_' . str_replace( '.', '_', $clave ), '' );
		if ( '' === $v || null === $v ) { continue; }
		list( $a, $b ) = explode( '.', $clave );
		if ( ! isset( $d[ $a ] ) || ! is_array( $d[ $a ] ) ) { $d[ $a ] = array(); }
		$d[ $a ][ $b ] = $v;
	}
	// Las noticias salen de las entradas publicadas
	$d['noticias'] = array();
	foreach ( get_posts( array( 'numberposts' => 60, 'post_status' => 'publish' ) ) as $p ) {
		$d['noticias'][] = array(
			'titulo'  => html_entity_decode( get_the_title( $p ), ENT_QUOTES, 'UTF-8' ),
			'fecha'   => get_the_date( 'Y-m-d', $p ),
			'resumen' => html_entity_decode( wp_strip_all_tags( has_excerpt( $p ) ? get_the_excerpt( $p ) : wp_trim_words( strip_shortcodes( $p->post_content ), 26, '…' ) ), ENT_QUOTES, 'UTF-8' ),
			'foto'    => get_the_post_thumbnail_url( $p, 'large' ) ?: null,
			'fotoAlt' => get_post_meta( get_post_thumbnail_id( $p ), '_wp_attachment_image_alt', true ),
			'url'     => get_permalink( $p ),
		);
	}
	// Rutas de imágenes y videos relativas → dirección completa del tema
	$fix = function ( &$x ) use ( &$fix ) {
		if ( is_array( $x ) ) { foreach ( $x as &$y ) { $fix( $y ); } return; }
		if ( is_string( $x ) && preg_match( '#^(img|video|fonts)/#', $x ) ) { $x = IV_URI . $x; }
	};
	$fix( $d );
	return $d;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'impacto/v1', '/datos', array(
		'methods'             => 'GET',
		'permission_callback' => '__return_true',
		'callback'            => function () {
			$r = rest_ensure_response( iv_datos() );
			$r->header( 'Cache-Control', 'no-cache, must-revalidate' );
			return $r;
		},
	) );
	register_rest_route( 'impacto/v1', '/contacto', array(
		'methods'             => 'POST',
		'permission_callback' => '__return_true',
		'callback'            => 'iv_recibir_contacto',
	) );
} );

/* ---------- Formulario de contacto → menú "Mensajes" + correo ---------- */
add_action( 'init', function () {
	register_post_type( 'iv_mensaje', array(
		'labels'          => array( 'name' => 'Mensajes', 'singular_name' => 'Mensaje', 'all_items' => 'Todos los mensajes', 'edit_item' => 'Mensaje', 'search_items' => 'Buscar mensajes', 'not_found' => 'Todavía no han llegado mensajes.' ),
		'public'          => false,
		'show_ui'         => true,
		'show_in_menu'    => true,
		'menu_position'   => 6,
		'menu_icon'       => 'dashicons-email-alt',
		'supports'        => array( 'title', 'editor' ),
		'capability_type' => 'post',
		'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		'map_meta_cap'    => true,
	) );
} );

function iv_recibir_contacto( WP_REST_Request $req ) {
	$p = $req->get_body_params();
	if ( ! empty( $p['campo-trampa'] ) ) { return array( 'ok' => true ); }
	$campo = function ( $k, $max = 2000 ) use ( $p ) { return isset( $p[ $k ] ) ? mb_substr( sanitize_textarea_field( wp_unslash( $p[ $k ] ) ), 0, $max ) : ''; };
	$nombre = $campo( 'nombre', 120 ); $tel = $campo( 'telefono', 40 ); $msj = $campo( 'mensaje', 3000 );
	if ( mb_strlen( $nombre ) < 3 || strlen( preg_replace( '/\D/', '', $tel ) ) < 7 || mb_strlen( $msj ) < 10 || empty( $p['consentimiento'] ) ) {
		return new WP_REST_Response( array( 'ok' => false ), 422 );
	}
	$lineas = array();
	foreach ( $p as $k => $v ) {
		if ( in_array( $k, array( 'form-name', 'campo-trampa', 'consentimiento', 'subject', 'bot-field' ), true ) || is_array( $v ) || '' === trim( (string) $v ) ) { continue; }
		$lineas[] = ucfirst( str_replace( '-', ' ', $k ) ) . ': ' . $campo( $k );
	}
	$asunto = $campo( 'asunto', 80 );
	$id = wp_insert_post( array(
		'post_type'    => 'iv_mensaje',
		'post_status'  => 'private',
		'post_title'   => $nombre . ( $asunto ? ' · ' . $asunto : '' ) . ' · ' . $tel,
		'post_content' => implode( "\n", $lineas ),
	) );
	if ( ! $id || is_wp_error( $id ) ) { return new WP_REST_Response( array( 'ok' => false ), 500 ); }
	$para = get_theme_mod( 'iv_empresa_correo' ) ?: get_option( 'admin_email' );
	wp_mail( $para, 'Nuevo mensaje desde la página web', implode( "\n", $lineas ) . "\n\nVer en WordPress: " . admin_url( 'post.php?post=' . $id . '&action=edit' ) );
	return array( 'ok' => true );
}

/* ---------- Personalizar → Datos de la asociación ---------- */
add_action( 'customize_register', function ( $wp ) {
	$wp->add_section( 'iv_datos', array( 'title' => 'Datos de la asociación', 'priority' => 20, 'description' => 'Lo que escribas aquí reemplaza lo que trae la página. Deja vacío para usar el dato actual.' ) );
	$base = json_decode( file_get_contents( IV_DIR . 'datos.json' ), true );
	foreach ( iv_opciones() as $clave => $info ) {
		$id = 'iv_' . str_replace( '.', '_', $clave );
		list( $a, $b ) = explode( '.', $clave );
		$actual = isset( $base[ $a ][ $b ] ) ? (string) $base[ $a ][ $b ] : '';
		$wp->add_setting( $id, array( 'default' => '', 'sanitize_callback' => 'url' === $info[1] ? 'esc_url_raw' : ( 'textarea' === $info[1] ? 'sanitize_textarea_field' : 'sanitize_text_field' ) ) );
		$wp->add_control( $id, array( 'label' => $info[0], 'section' => 'iv_datos', 'type' => $info[1], 'input_attrs' => array( 'placeholder' => $actual ) ) );
	}
} );

/* ---------- Escritorio de WordPress más sencillo ---------- */
// Editor clásico: título, texto, foto y Publicar (más fácil que el editor de bloques)
add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
add_action( 'add_meta_boxes_post', function () {
	foreach ( array( 'tagsdiv-post_tag', 'categorydiv', 'postexcerpt', 'postcustom', 'commentstatusdiv', 'commentsdiv', 'trackbacksdiv', 'slugdiv', 'authordiv', 'formatdiv', 'revisionsdiv' ) as $c ) {
		remove_meta_box( $c, 'post', 'normal' ); remove_meta_box( $c, 'post', 'side' ); remove_meta_box( $c, 'post', 'advanced' );
	}
}, 99 );
add_filter( 'disable_categories_dropdown', '__return_true' );
add_filter( 'manage_post_posts_columns', function ( $c ) { unset( $c['categories'], $c['tags'], $c['comments'], $c['author'] ); return $c; } );
add_filter( 'enter_title_here', function ( $t, $post ) { return 'post' === $post->post_type ? 'Escribe aquí el título de la noticia' : $t; }, 10, 2 );

// "Entradas" se llama "Noticias"
add_action( 'init', function () {
	global $wp_post_types;
	$l = &$wp_post_types['post']->labels;
	$l->name = 'Noticias'; $l->singular_name = 'Noticia'; $l->add_new = 'Añadir noticia'; $l->add_new_item = 'Nueva noticia';
	$l->edit_item = 'Editar noticia'; $l->all_items = 'Todas las noticias'; $l->menu_name = 'Noticias'; $l->name_admin_bar = 'Noticia';
	$l->search_items = 'Buscar noticias'; $l->view_items = 'Ver noticias'; $l->not_found = 'Todavía no hay noticias.'; $l->view_item = 'Ver noticia'; $l->item_published = 'Noticia publicada.'; $l->item_updated = 'Noticia actualizada.';
	$l->featured_image = 'Foto de la noticia'; $l->set_featured_image = 'Elegir foto de la noticia'; $l->remove_featured_image = 'Quitar foto'; $l->use_featured_image = 'Usar como foto de la noticia';
} );
add_action( 'admin_menu', function () {
	remove_menu_page( 'edit-comments.php' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
	global $menu;
	foreach ( $menu as &$m ) { if ( 'edit.php' === $m[2] ) { $m[6] = 'dashicons-megaphone'; } }
} );
add_filter( 'post_updated_messages', function ( $m ) {
	global $post;
	$ver = $post ? ' <a href="' . esc_url( get_permalink( $post ) ) . '" target="_blank">Ver la noticia en la página</a>' : '';
	$m['post'][1] = 'Noticia actualizada.' . $ver;
	$m['post'][6] = 'Noticia publicada.' . $ver;
	$m['post'][7] = 'Noticia guardada.';
	$m['post'][10] = 'Borrador guardado.';
	return $m;
} );
// Sin comentarios en el sitio
add_action( 'init', function () { remove_post_type_support( 'post', 'comments' ); remove_post_type_support( 'post', 'trackbacks' ); }, 100 );
add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );

// Guía en el escritorio
add_action( 'wp_dashboard_setup', function () {
	wp_add_dashboard_widget( 'iv_guia', 'Cómo publicar una noticia (3 pasos)', function () {
		echo '<ol style="font-size:15px;line-height:1.7;margin-left:1.2em">';
		echo '<li>Haz clic en <b>Noticias → Añadir noticia</b>.</li>';
		echo '<li>Escribe el <b>título</b> y el <b>texto</b>. A la derecha, en <b>Foto de la noticia</b>, sube una foto.</li>';
		echo '<li>Haz clic en <b>Publicar</b>. Listo: aparece en la página de Noticias y en el inicio.</li>';
		echo '</ol>';
		echo '<p><a class="button button-primary button-hero" href="' . esc_url( admin_url( 'post-new.php' ) ) . '">+ Añadir noticia</a> ';
		echo '<a class="button button-hero" href="' . esc_url( iv_url( 'noticias' ) ) . '" target="_blank">Ver noticias en la página</a></p>';
		echo '<p style="color:#555">Para cambiar teléfonos, WhatsApp, correo o el título del inicio: <a href="' . esc_url( admin_url( 'customize.php?autofocus[section]=iv_datos' ) ) . '">Apariencia → Personalizar → Datos de la asociación</a>. Los mensajes del formulario llegan a <a href="' . esc_url( admin_url( 'edit.php?post_type=iv_mensaje' ) ) . '">Mensajes</a>.</p>';
	} );
	global $wp_meta_boxes;
	$g = $wp_meta_boxes['dashboard']['normal']['core']['iv_guia'] ?? null;
	if ( $g ) { unset( $wp_meta_boxes['dashboard']['normal']['core']['iv_guia'] ); $wp_meta_boxes['dashboard']['normal']['high']['iv_guia'] = $g; }
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
} );

/* ---------- Al activar el tema: crea las páginas y deja todo configurado ---------- */
add_action( 'after_switch_theme', 'iv_configurar' );
function iv_configurar() {
	$inicio = get_page_by_path( 'inicio' );
	$inicio_id = $inicio ? $inicio->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Inicio', 'post_name' => 'inicio' ) );
	$ids = array();
	foreach ( iv_paginas() as $slug => $titulo ) {
		$p = get_page_by_path( $slug );
		$ids[ $slug ] = $p ? $p->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => $titulo, 'post_name' => $slug ) );
	}
	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', $inicio_id );
	update_option( 'page_for_posts', $ids['noticias'] );
	update_option( 'blogname', 'Asociación Impacto Verde' );
	update_option( 'blogdescription', 'Recicladores de oficio de Villavicencio' );
	update_option( 'default_comment_status', 'closed' );
	update_option( 'timezone_string', 'America/Bogota' );
	update_option( 'date_format', 'j \d\e F \d\e Y' );
	if ( ! get_option( 'permalink_structure' ) ) { update_option( 'permalink_structure', '/%postname%/' ); }
	// La entrada de ejemplo de WordPress no sirve en el sitio
	foreach ( array( 'hola-mundo', 'hello-world' ) as $s ) { $x = get_page_by_path( $s, OBJECT, 'post' ); if ( $x ) { wp_delete_post( $x->ID, true ); } }
	foreach ( array( 'pagina-ejemplo', 'sample-page' ) as $s ) { $x = get_page_by_path( $s ); if ( $x ) { wp_delete_post( $x->ID, true ); } }
	flush_rewrite_rules();
}

/* Las direcciones viejas *.html llevan a las nuevas */
add_action( 'template_redirect', function () {
	$ruta = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	if ( preg_match( '#/([a-z-]+)\.html$#', (string) $ruta, $m ) ) {
		$s = 'index' === $m[1] ? 'index' : $m[1];
		if ( 'index' === $s || isset( iv_paginas()[ $s ] ) ) { wp_safe_redirect( iv_url( $s ), 301 ); exit; }
	}
} );
