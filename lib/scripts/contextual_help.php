<?php

/* --------------------------------------------------------------------------------
*
* [WP] Starter - SETUP
* [WP] Starter is a custom framework developed by Shambix @ http://www.shambix.com
*
-------------------------------------------------------------------------------- */

// DISPLAY SCREEN + REGISTERED POST TYPES for Admins

if(!function_exists('add_screen_help')) {

    if(current_user_can('activate_plugins')) :
        add_action('contextual_help', 'add_screen_help', 10, 3);
    endif;

    function add_screen_help( $contextual_help, $screen_id, $screen ) {
        if ( ! method_exists( $screen, 'add_help_tab' ) )
            return $contextual_help;
        global $hook_suffix;

        $infotitle = '<div>
            <h1 style="width:30%;float:left;">[WP] Starter System Info</h1>
            <p style="width:70%;float:right; text-align:right;">Theme documentation on <a href="https://github.com/Jany-M/WP-Starter" target="_blank">GitHub</a> - developed by <a href="http://www.sgambix.com" target="_blank">Shambix</a></p>;
        </div><hr>';
        // List screen properties
        $variables = '<ul style="width:50%;float:left;"><h3 style="cleare:both; width:100%">Screen variables</h3>'
            . sprintf( '<li> Screen id : %s</li>', $screen_id )
            . sprintf( '<li> Screen base : %s</li>', $screen->base )
            . sprintf( '<li>Parent base : %s</li>', $screen->parent_base )
            . sprintf( '<li> Parent file : %s</li>', $screen->parent_file )
            . sprintf( '<li> Hook suffix : %s</li>', $hook_suffix )
            . '</ul>';
        // Append global $hook_suffix to the hook stems
        $hooks = array(
            "load-$hook_suffix",
            "admin_print_styles-$hook_suffix",
            "admin_print_scripts-$hook_suffix",
            "admin_head-$hook_suffix",
            "admin_footer-$hook_suffix"
        );
        // If add_meta_boxes or add_meta_boxes_{screen_id} is used, list these too
        if ( did_action( 'add_meta_boxes_' . $screen_id ) )
            $hooks[] = 'add_meta_boxes_' . $screen_id;
        if ( did_action( 'add_meta_boxes' ) )
            $hooks[] = 'add_meta_boxes';
        // Get List HTML for the hooks
        $hooks = '<ul style="width:50%;float:left;"><h3 style="cleare:both; width:100%">Hooks</h3><li>' . implode( '</li><li>', $hooks ) . '</li></ul>';
        // Get Registered Post Types
        $post_types = get_post_types( '', 'names' );
        $regposts = '<h3 style="cleare:both; width:100%">Registered Post Types</h3><ul style="width:100%; display:block;">';
        foreach ( $post_types as $post_type ) {
           $regposts .= '<li style="float:left;">'.$post_type.'</li>';
        }
        $regposts .= '</ul>';
        // Combine $variables list with $hooks list.
        $help_content = $infotitle . $variables . $hooks . $regposts;

        // Add [WP] Starter Debug tab
        $screen->add_help_tab( array(
            'id'      => 'wpstarter-debug',
            'title'   => '[WP] General',
            'content' => $help_content,
        ));

        // Info about Admin Backend Menu
        global $menu;
        $menu_info = array();
        $menu_info = $menu;

        $menu_before = '<h3 style="cleare:both; width:100%">Admin Menu Items</h3>';
        $menu_content= '<pre>'.var_export($menu, true).'</pre>';
        $menu_after = '</li></ul>';

        $menu_info_output = $menu_before . $menu_content .$menu_after;

        // Add [WP] Starter Admin Menu Info
        $screen->add_help_tab( array(
            'id'      => 'wpstarter-adminmenu',
            'title'   => '[WP] Admin Menu',
            'content' => $menu_info_output,
        ));

        // Quick Reference Links
        $links = '<ul style="width:50%;float:left;"><h3 style="cleare:both; width:100%">Quick Reference Links</h3>
            <li><a href="https://codex.wordpress.org/Global_Variables" target="_blank">WordPress Globals</a></li>
            <li><a href="http://wpengineer.com/2382/wordpress-constants-overview/" target="_blank">WordPress Constants</li>
            <li><a href="https://codex.wordpress.org/Class_Reference/WP_Query" target="_blank">WP Query</a></li>
        </ul>';

        // [WP]Starter Quick links
        $screen->add_help_tab( array(
            'id'      => 'wpstarter-reflinks',
            'title'   => '[WP] Quick Links',
            'content' => $links,
        ));

        return $contextual_help;
    }
}

// ADD Custom Tab to HELP
/*add_action( "load-{$GLOBALS['pagenow']}", 'add_debug_tab', 20 );
function add_debug_tab () {
    $screen = get_current_screen();
    $screen->add_help_tab( array(
        'id'    => 'wpstarter_debug_tab',
        'title' => __('DEBUG'),
        'content'   => '<p>' . __( '[WP] Starter - Debug Information.' ) . '</p>',
    ));
}*/

?>
