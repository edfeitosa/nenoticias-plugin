<?php
/**
 * Plugin Name: NE Notícias
 * Plugin URI: http://www.nenoticias.com.br
 * Description: Plugin para controle e administração do tema do NE Notícias.
 * Version: 1.0
 * Author: Eduardo Feitosa
 * Author URI: http://www.nenoticias.com.br
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Ne_Noticias')) {
    class NE_Noticias {

        const VERSION = '1.0';

        protected static $instance = null;

        private function __construct() {

            $this->ne_includes();

            // registra css e js
            add_action('admin_enqueue_scripts', array(NE_Front, 'ne_front_admin'));

            // cria tabelas no banco
            register_activation_hook(__FILE__, $this->ne_create_db_table());

            // registra menu
            $this->ne_plugin_menu();

            // arquivo de desinstalação
            define('WP_UNINSTALL_PLUGIN', plugins_url('uninstall.php', __FILE__));

        }

        public static function ne_get_instance() {
            if ( null === self::$instance ) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        private function ne_create_db_table() {
            global $wpdb;
            $charset_collate = $wpdb->get_charset_collate();
            $sql = "CREATE TABLE " . $wpdb->prefix . "terms_colors (
                    `col_id` int(11) NOT NULL AUTO_INCREMENT,
                    `term_id` int(11) NOT NULL,
                    `col_name` varchar(100) NULL,
                    `col_slug` varchar(100) NOT NULL,
                    `col_hexa` varchar(7),
                    PRIMARY KEY (`col_id`)
                  ) $charset_collate;";
        
            require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
            dbDelta($sql);
        }

        private function ne_includes() {
            include_once dirname( __FILE__ ) . '/functions/class-ne-front.php';
            include_once dirname( __FILE__ ) . '/componentes/nenoticias/nenoticias.php';
            include_once dirname( __FILE__ ) . '/componentes/cores/cores.php';
        }

        private function ne_plugin_menu() {
            add_action('admin_menu', 'ne_plugin_action_links');
            function ne_plugin_action_links() {
                add_menu_page('NE_Noticias', 'NE Notícias', 'manage_options', 'nenoticias', 'ne_noticias', 'dashicons-businessman', 6);
	            add_submenu_page('nenoticias', 'NE_Noticias', 'Categorias/Cores', 'manage_options', 'cores', 'ne_cores');
            }
        }
    }

    // em caso de desativação do plugin
    function ne_truncate_db_table() {
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE " . $wpdb->prefix . "term_colors");
        delete_option("ne_noticias");
        delete_site_option('ne_noticias');
    }
    register_deactivation_hook(__FILE__, 'ne_truncate_db_table');
    add_action('plugins_loaded', array('NE_Noticias', 'ne_get_instance'));
    
} ?>