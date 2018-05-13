<?php
/**
 * Carregamento dos scripts e styles do plugin.
 *
 * @class   NE_Styles
 * @version 1.0.0
 * @author  Eduardo Feitosa
 */
if (!defined('ABSPATH')) {
	exit;
}
class NE_Front {
    public function ne_front_admin() {
        wp_enqueue_style('ne_styles', plugins_url('assets/css/styles.css', dirname(__FILE__)));
        wp_enqueue_script('ne_scripts', plugins_url('assets/scripts/scripts.js', dirname(__FILE__)));
    }
} ?>