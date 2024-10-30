<?php
if(!defined('ABSPATH')){
	exit;
} // Exit if accessed directly

function congoro_widget_activate(){
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if(get_option('congoro_widget_installed')!=='true'){
		delete_option('congoro_widgets_settings');
		update_option('congoro_widget_installed','true');
	}

	register_uninstall_hook(__FILE__,'congoro_widget_uninstall');
}

register_activation_hook(__FILE__,'congoro_widget_activate');

// And here goes the uninstalling function:
function congoro_widget_uninstall(){
	// if uninstall.php is not called by WordPress, die
	if(!defined('WP_UNINSTALL_PLUGIN')){
		return;
	}

	//remove widgets settings
	delete_option('congoro_widgets_settings');
	delete_option('congoro_widget_installed');
}