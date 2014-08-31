<?php 

// Get Taxonomy Rewrite URL slug
function getrewritetaxslug ($tax){
	$getdataslug = get_taxonomy($tax);
	$dataslug = $getdataslug->rewrite['slug'];
	return $dataslug;
}

// Lista di custom taxonomy non linkate
function lista_tax ($nome_tax){
$terms = get_the_terms( $post->ID, $nome_tax );						
if ( $terms && ! is_wp_error( $terms ) ) : 
$tipi = array();
foreach ( $terms as $term ) {
	$tipi[] = $term->name;
}					
$tipo = join( ", ", $tipi );
return $tipo;
endif;
}

// De-Register theme post types
/*function remove_1() {   
    remove_action( 'init', 'create_package_post' );   
}
add_action( 'after_setup_theme','remove_1', 100 );*/

// qTranslate: Edit Taxonomies
/*function qtranslate_edit_taxonomies(){
   $args=array(
      'public' => true ,
      '_builtin' => false
   );
   $output = 'object'; // or objects
   $operator = 'and'; // 'and' or 'or'

   $taxonomies = get_taxonomies($args,$output,$operator);

   if  ($taxonomies) {
     foreach ($taxonomies  as $taxonomy ) {
         add_action( $taxonomy->name.'_add_form', 'qtrans_modifyTermFormFor');
         add_action( $taxonomy->name.'_edit_form', 'qtrans_modifyTermFormFor');
     }
   }
}
add_action('admin_init', 'qtranslate_edit_taxonomies');
*/

/*========================================================================================================================================================================
		Register Custom Post Types
========================================================================================================================================================================*/

/*----------------------------------------------------------------------
			Portfolio
----------------------------------------------------------------------*/
/*add_action( 'init', 'create_post_type_portfolio' );

function create_post_type_portfolio() {
	$portfolio_labels = array(
		'name' => __('Portfolio'),
		'singular_name' => __('Portfolio'),
		'add_new' => __('Add new Project'),
		'add_new_item' => __('Add new Project'),
		'edit_item' => __('Edit Project'),
		'new_item' => __('New Project'),
		'all_items' => __('All Projects'),
		'view_item' => __('View'),
		'search_items' => __('Search'),
		'not_found' =>  __('No Projects found.'),
		'not_found_in_trash' => __('No Projects found.'), 
		'parent_item_colon' => '',
		'menu_name' => 'Portfolio'
	);
	$portfolio_args = array(
		'labels' => $portfolio_labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true, 
		'show_in_menu' => true, 
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'has_archive' => true, 
		'hierarchical' => false,
		'menu_position' => 5, // or null
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields' 'revisions', 'comments','author','page-attributes'),
		'taxonomies' => array('type_portfolio', 'post_tag')
	);

register_post_type( 'portfolio', $portfolio_args);
}

// Servizi
add_action( 'init', 'create_post_type_servizi' );

function create_post_type_servizi() {
	register_post_type( 'services',
		array(
			'labels' => array(
				'name' => __( 'Services' ),
				'singular_name' => __( 'Service' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
	  'title',
	  'editor',
	  'excerpt',
	  'trackbacks',
	  'custom-fields',
	  //'revisions',
	  'thumbnail',
	  'author',
	  'page-attributes'
	  ),
	'menu_position' => 5,
	  'taxonomies' => array('type_service', 'post_tag')
		)
	);
}

// Team
add_action( 'init', 'create_post_type_team' );

function create_post_type_team() {
	register_post_type( 'team',
		array(
			'labels' => array(
				'name' => __( 'People' ),
				'singular_name' => __( 'People' )
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array(
	  'title',
	  'editor',
	  'excerpt',
	  'trackbacks',
	  'custom-fields',
	  //'revisions',
	  'thumbnail',
	  'author',
	  'page-attributes'
	  ),
	'menu_position' => 5,
	  'taxonomies' => array('team_people')
		)
	);
}*/

/* Custom Taxonomies
---------------------------------------------------------------------------------------------- */

// - Tipologie (Portfolio)
/*add_action( 'init', 'create_portfolio_tipologies', 1 );

function create_portfolio_tipologies() 
{
  $labels = array(
    'name' => _x( 'Tipologie Portfolio', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipologia Portfolio', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca Tipologie' ),
    'all_items' => __( 'Tutte le Tipologie' ),
    'parent_item' => __( 'Tipologia Principale' ),
    'parent_item_colon' => __( 'Tipologia Principale:' ),
    'edit_item' => __( 'Modifica Tipologia' ), 
    'update_item' => __( 'Aggiorna Tipologia' ),
    'add_new_item' => __( 'Aggiungi Nuova Tipologia' ),
    'new_item_name' => __( 'Nome Nuova Tipologia' ),
    'menu_name' => __( 'Tipologie' ),
  ); 	

  register_taxonomy('type_portfolio',array('portfolio'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type_portfolio' ),
  ));
}

// - Tipologie (Servizi)
add_action( 'init', 'create_service_tipologies', 1 );

function create_service_tipologies() 
{
  $labels = array(
    'name' => _x( 'Tipologie Servizi', 'taxonomy general name' ),
    'singular_name' => _x( 'Tipologia Servizio', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca Tipologie' ),
    'all_items' => __( 'Tutte le Tipologie' ),
    'parent_item' => __( 'Tipologia Principale' ),
    'parent_item_colon' => __( 'Tipologia Principale:' ),
    'edit_item' => __( 'Modifica Tipologia' ), 
    'update_item' => __( 'Aggiorna Tipologia' ),
    'add_new_item' => __( 'Aggiungi Nuova Tipologia' ),
    'new_item_name' => __( 'Nome Nuova Tipologia' ),
    'menu_name' => __( 'Tipologie' ),
  ); 	

  register_taxonomy('type_service',array('services'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'type_service' ),
  ));
}

// - People (Team)
add_action( 'init', 'create_team_people', 1 );

function create_team_people() 
{
  $labels = array(
    'name' => _x( 'Teams', 'taxonomy general name' ),
    'singular_name' => _x( 'Teams', 'taxonomy singular name' ),
    'search_items' =>  __( 'Find Team' ),
    'all_items' => __( 'All Teams' ),
    'parent_item' => __( 'Main Team' ),
    'parent_item_colon' => __( 'Main Team:' ),
    'edit_item' => __( 'Edit Team' ), 
    'update_item' => __( 'Update Team' ),
    'add_new_item' => __( 'Add New Team' ),
    'new_item_name' => __( 'New Team Name' ),
    'menu_name' => __( 'Teams' ),
  ); 	

  register_taxonomy('team_people',array('team'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'team_people' ),
  ));
}*/

/* Colonne Custom Edit Screen
------------------------------------------------------------------------------------------------- */

// Portfolio
/*function sh_portfolio_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Progetto'),
			'thumbnail_port' => __( 'Thumb'),
            "type_portfolio" => __( 'Tipologia')
        );    
        return $columns;  
}  
  
function sh_portfolio_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
            case 'type_portfolio':  
                echo get_the_term_list($post->ID, 'type_portfolio', '', ', ','');  
                break;
			 
			case 'thumbnail_port':
				$thumbnail = get_the_post_thumbnail($post->ID, array(150, 85));
				if( isset($thumbnail) ) {
					echo $thumbnail;
				} 
	        break;
        }  
}  

add_filter('manage_edit-portfolio_columns', 'sh_portfolio_edit_columns');  
add_action('manage_posts_custom_column', 'sh_portfolio_custom_columns');  

// -- Servizi

function sh_services_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'Service'),
			"thumbnail_serv" => __( 'Thumb'),
            "type_service" => __( 'Tipologia')
        );    
        return $columns;  
}  
  
function sh_services_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
            case 'type_service':  
                echo get_the_term_list($post->ID, 'type_service', '', ', ','');  
                break;
			
			case 'thumbnail_serv':
				$thumbnail = get_the_post_thumbnail($post->ID, array(50,50));
				if( isset($thumbnail) ) {
					echo $thumbnail;
				} 
	        break;
        }  
}  

add_filter('manage_edit-services_columns', 'sh_services_edit_columns');  
add_action('manage_posts_custom_column', 'sh_services_custom_columns');  

// -- Team

function sh_team_edit_columns($columns){  
        $columns = array(  
            "cb" => "<input type=\"checkbox\" />",  
            "title" => __( 'People'),
			"thumbnail_team" => __( 'Thumb'),
            "team_people" => __( 'Team')
        );    
        return $columns;  
}  
  
function sh_team_custom_columns($column){  
        global $post;  
        switch ($column)  
        {    
            case 'team_people':  
                echo get_the_term_list($post->ID, 'team_people', '', ', ','');  
                break;
			
			case 'thumbnail_team':
				$thumbnail = get_the_post_thumbnail($post->ID, array(50,50));
				if( isset($thumbnail) ) {
					echo $thumbnail;
				} 
	        break;
        }  
}  

add_filter('manage_edit-team_columns', 'sh_team_edit_columns');  
add_action('manage_posts_custom_column', 'sh_team_custom_columns');  */

/* Icone Custom Post Type
------------------------------------------------------------------------------------------------------- */

// Portfolio
//function sh_portfolio_icons() { ?>
    <!-- <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
           background:  url(<?php //echo get_template_directory_uri(); ?>/img/sticky-note.png)  no-repeat 6px -17px !important;
        }
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:6px 7px!important;
        }
		#icon-edit.icon32-posts-portfolio {background:  url(<?php //echo get_template_directory_uri(); ?>/img/sticky-note-32x32.png) no-repeat;}
    </style> -->
<?php //} add_action( 'admin_head', 'sh_portfolio_icons' );

// Servizi
//function sh_servizi_icons() { ?>
  <!--  <style type="text/css" media="screen">
        #menu-posts-portfolio .wp-menu-image {
            background:  url(<?php //echo get_template_directory_uri(); ?>/img/portfolio-icon.png) no-repeat 6px 6px !important;
        }
		#menu-posts-portfolio:hover .wp-menu-image, #menu-posts-portfolio.wp-has-current-submenu .wp-menu-image {
            background-position:6px -16px !important;
        }
		#icon-edit.icon32-posts-portfolio {background:  url(<?php //echo get_template_directory_uri(); ?>/img/portfolio-32x32.png) no-repeat;}
    </style> -->
<?php //} add_action( 'admin_head', 'sh_servizi_icons' );

?>