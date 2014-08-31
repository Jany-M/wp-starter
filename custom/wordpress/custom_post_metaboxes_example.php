<?php 

/*----------------------------------------------------------------------
	Add_meta_boxes Action For 'Portfolio' Post Type
----------------------------------------------------------------------*/
	
add_action( 'add_meta_boxes', 'shambix_portfolio_add_custom_box' );
	
/*----------------------------------------------------------------------
	Properties Of client Options Meta Box 
----------------------------------------------------------------------*/
	
function shambix_portfolio_add_custom_box() {
	add_meta_box( 
		'shambix_portfolio_sectionid',
		__( 'Portfolio Info', 'shambix' ),
		'shambix_portfolio_inner_custom_box',
		'portfolio'
	);
}
	
/*----------------------------------------------------------------------
	Content Of 'Portfolio' Options Meta Box 
----------------------------------------------------------------------*/
	
function shambix_portfolio_inner_custom_box( $post ) {

	add_action('admin_print_styles-post-new.php', 'gallery_add_media_upload_scripts');
	add_action('admin_print_styles-post.php', 'gallery_add_media_upload_scripts');
	function gallery_add_media_upload_scripts()
	{
		//if ($GLOBALS['post_type'] == 'gallery') {
			add_thickbox();
			wp_enqueue_script('media-upload');
		//}
	}

	// Use nonce for verification
	wp_nonce_field( basename( __FILE__ ), 'shambix_portfolio_customboxes_nonce' );
	?>

	<!-- Styles -->
	<!-- <link rel="stylesheet" href="<?php echo get_template_directory_uri().'/css/admin.css'; ?>"> -->

	<!-- Project Website -->
	<p><label for="shambix_metabox_portfolio_prwebsite_var"><strong>Project Website</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_prwebsite_var" id="shambix_metabox_portfolio_prwebsite_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_prwebsite', true); ?>" />
	<p><span class="description">Example: (http://www.example.com)</span></p>

	<!-- Client Name -->
	<p><label for="shambix_metabox_portfolio_name_var"><strong>Client</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_name_var" id="shambix_metabox_portfolio_name_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_name', true); ?>" />
	<!-- <p><span class="description">Example: </span></p> -->

	<!-- Client Website -->
	<p><label for="shambix_metabox_portfolio_clwebsite_var"><strong>Client Website</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_clwebsite_var" id="shambix_metabox_portfolio_clwebsite_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_clwebsite', true); ?>" />
	<p><span class="description">Example: (http://www.example.com)</span></p>

	<!-- Agency -->
	<p><label for="shambix_metabox_portfolio_agency_var"><strong>Agency</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_agency_var" id="shambix_metabox_portfolio_agency_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_agency', true); ?>" />
	<!-- <p><span class="description">Example: </span></p> -->

	<!-- Agency Website -->
	<p><label for="shambix_metabox_portfolio_agwebsite_var"><strong>Agency Website</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_agwebsite_var" id="shambix_metabox_portfolio_agwebsite_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_agwebsite', true); ?>" />
	<p><span class="description">Example: (http://www.example.com)</span></p>

	<!-- Year -->
	<p><label for="shambix_metabox_portfolio_year_var"><strong>Year</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_year_var" id="shambix_metabox_portfolio_year_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_year', true); ?>" />
	<!-- <p><span class="description">Example: </span></p> -->

	<!-- Tools -->
	<p><label for="shambix_metabox_portfolio_tools_var"><strong>Tools</strong></label></p>	
	<input type="text" name="shambix_metabox_portfolio_tools_var" id="shambix_metabox_portfolio_tools_var" class="regular-text code" value="<?php echo get_post_meta($post->ID, 'shambix_metabox_portfolio_tools', true); ?>" />
	<!-- <p><span class="description">Example: </span></p> -->

	<!-- Logo Img -->
	<?php
		$img = '<span class="wp-media-buttons-icon"></span> ';
		echo '<a href="#" class="button insert-media add_media" data-editor="' . esc_attr( $editor_id ) . '" title="' . esc_attr__( 'Add Media' ) . '">' . $img . __( 'Add Media' ) . '</a>';
	 ?>

	<!-- Logo Size -->
	<p><label for="shambix_metabox_portfolio_logo_size"><strong>Logo Size</strong></label></p>
	<select id="shambix_metabox_portfolio_logo_size" name="shambix_metabox_portfolio_logo_size">
		<?php
		for($i=100 ; $i>=10 ; $i-=5) { 
			echo '<option ';
			if(get_post_meta($post->ID, 'shambix_metabox_portfolio_logo_size', true) == '' && $i == 100) {
				echo 'selected ';
			} else if( get_post_meta($post->ID, 'shambix_metabox_portfolio_logo_size', true) == $i.'%' ) {
				echo 'selected ';
			}
			echo 'value="'.$i.'%">'.$i.'%</option>';
		}
		?>
        </select>

<?php }
	
/*========================================================================================================================================================================
	Save 'Portfolio' Options Meta Box Function
========================================================================================================================================================================*/
	
function shambix_save_metabox_portfolio_meta_box($post_id) {
	
	if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
	/*if ( $post->post_type != 'portfolio' ) return;*/
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	/*if ( is_int( wp_is_post_revision( $post ) ) ) return;
	if ( is_int( wp_is_post_autosave( $post ) ) ) return;*/
	if( !current_user_can( 'edit_post' ) ) return;
	/*if ( !isset( $_POST['shambix_portfolio_customboxes_nonce'] ) || !wp_verify_nonce( $_POST['shambix_portfolio_customboxes_nonce'], basename( __FILE__ ) ) ) return;*/
	
	/*----------------------------------------------------------------------
		Project Website
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_prwebsite_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_prwebsite', $_POST['shambix_metabox_portfolio_prwebsite_var']);
	}
	
	/*----------------------------------------------------------------------
		Client Name
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_name_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_name', $_POST['shambix_metabox_portfolio_name_var']);
	}

	/*----------------------------------------------------------------------
		Client Website
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_clwebsite_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_clwebsite', $_POST['shambix_metabox_portfolio_clwebsite_var']);
	}

	/*----------------------------------------------------------------------
		Agency
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_agency_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_agency', $_POST['shambix_metabox_portfolio_agency_var']);
	}

	/*----------------------------------------------------------------------
		Agency Website
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_agwebsite_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_agwebsite', $_POST['shambix_metabox_portfolio_agwebsite_var']);
	}

	/*----------------------------------------------------------------------
		Year
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_year_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_year', $_POST['shambix_metabox_portfolio_year_var']);
	}
	
	/*----------------------------------------------------------------------
		Tools
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_tools_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_tools', $_POST['shambix_metabox_portfolio_tools_var']);
	}

	/*----------------------------------------------------------------------
		Logo Size
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_logo_size_var'])) {
		update_post_meta( $post_id, 'shambix_metabox_portfolio_logo_image', $_POST['shambix_metabox_portfolio_logo_image_var'] );
	}
			
	/*----------------------------------------------------------------------
		Logo Size
	----------------------------------------------------------------------*/
	if(isset($_POST['shambix_metabox_portfolio_logo_size_var'])) {
		update_post_meta($post_id, 'shambix_metabox_portfolio_logo_size', $_POST['shambix_metabox_portfolio_logo_size_var']);
	}
	
}
	
/*----------------------------------------------------------------------
	Save 'Portfolio' Options Meta Box Action
----------------------------------------------------------------------*/
	add_action('save_post', 'shambix_save_metabox_portfolio_meta_box');

?>