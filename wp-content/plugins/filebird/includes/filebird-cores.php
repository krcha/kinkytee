<?php

function filebird_core_init(){
	if(class_exists('FileBird_Topbar')){
		return;
	}
	add_action( 'wp_enqueue_scripts', 'filebird_register_scripts', 20);
}

function filebird_register_scripts(){
	if (!is_user_logged_in()){
		return;
	}
	global $pagenow;

	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';
	$taxonomy = NJT_FILEBIRD_FOLDER;
	$taxonomy = apply_filters( 'filebird_taxonomy', $taxonomy );

	if ( $taxonomy != NJT_FILEBIRD_FOLDER ) {
		$dropdown_options = array(
			'taxonomy'        => $taxonomy,
			'hide_empty'      => false,
			'hierarchical'    => true,
			'orderby'         => 'name',
			'show_count'      => true,
			'walker'          => new filebird_walker_category_mediagridfilter(),
			'value'           => 'id',
			'echo'            => false
		);
	} else {
		$dropdown_options = array(
			'taxonomy'        => $taxonomy,
			'hide_empty'      => false,
			'hierarchical'    => true,
			'orderby'         => 'name',
			'show_count'      => true,
			'walker'          => new filebird_walker_category_mediagridfilter(),
			'value'           => 'id',
			'echo'            => false
		);
	}
	$attachment_terms = wp_dropdown_categories( $dropdown_options );
	$attachment_terms = preg_replace( array( "/<select([^>]*)>/", "/<\/select>/" ), "", $attachment_terms );
	$all_count = wp_count_posts('attachment')->inherit;
	$uncatetory_count = FileBird_Topbar::get_uncategories_attachment();

	echo '<script type="text/javascript">';
	echo '/* <![CDATA[ */';
	echo 'var filebird_folder = "'. NJT_FILEBIRD_FOLDER .'";';
	echo 'var filebird_taxonomies = {"folder":{"list_title":"' . html_entity_decode( __( 'All categories' , NJT_FILEBIRD_TEXT_DOMAIN ), ENT_QUOTES, 'UTF-8' ) . '","term_list":[{"term_id":"-1","term_name":"'.__( 'Uncategorized' , NJT_FILEBIRD_TEXT_DOMAIN ).'"},' . substr( $attachment_terms, 2 ) . ']}};';
	echo '/* ]]> */';
	echo '</script>';
	add_action('wp_enqueue_scripts', function(){
		wp_enqueue_media();
	});


	wp_enqueue_media();
	add_thickbox();
	
	wp_register_style( 'filebird-builder-style', NJT_FILEBIRD_PLUGIN_URL . '/admin/css/filebird-elementor.css');
	wp_enqueue_style('filebird-builder-style');

	wp_register_script( 'filebird-builder-util', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/filebird-util.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'filebird-builder-util' );

	wp_register_script( 'filebird-builder-upload-hook', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/hook-post-add-media.js', array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'filebird-builder-upload-hook' );

	wp_register_script( 'filebird-builder', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/filebird-admin-topbar.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'filebird-builder' );
};

function filebird_cores(){
	$free = false;

	if (NJT_FILEBIRD_PLUGIN_NAME == 'FileBird Lite'){
		$free = true;
	}
    
	if ($free){
		add_filter( 'plugin_action_links_' . NJT_FILEBIRD_FOLDER_BASE, 'go_pro_version' );
	
		function go_pro_version($links){
			$links[] = '<a target="_blank" href="https://goo.gl/8e19F6" style="color: #43B854; font-weight: bold">'. __('Go Pro', NJT_FILEBIRD_TEXT_DOMAIN) .'</a>';
			return $links;
		}
	}
}

call_user_func('filebird_core_init');
