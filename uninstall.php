<?php // em caso de desintalação, apaga tabelas do plugin no banco
if (!defined('WP_UNINSTALL_PLUGIN')) exit();
global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS " . $wpdb->prefix . "term_colors");
delete_option( 'ne_noticias' );
delete_site_option( 'ne_noticias' ); ?>