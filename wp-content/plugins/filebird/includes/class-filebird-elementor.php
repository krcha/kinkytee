<?php 
class FileBird_Elementor{
    public function init() {
        add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'elementor_scripts' ] );
        add_action( 'elementor/editor/before_enqueue_styles', [ $this, 'elementor_styles' ] );
    }

    public function elementor_styles(){
        wp_register_style( 'media-upload-elementor', NJT_FILEBIRD_PLUGIN_URL . '/admin/css/filebird-elementor.css');
        wp_enqueue_style('media-upload-elementor');
    }

    public function elementor_scripts(){
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

        wp_enqueue_media();

        wp_register_script( 'filebird-builder-util-elementor', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/filebird-util.js', array( 'jquery' ) );
        wp_enqueue_script( 'filebird-builder-util-elementor' );
    
        wp_register_script( 'filebird-builder-upload-hook-elementor', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/hook-post-add-media.js', array( 'jquery' ) );
        wp_enqueue_script( 'filebird-builder-upload-hook-elementor' );

        wp_register_script( 'media-library-elementor', NJT_FILEBIRD_PLUGIN_URL . '/admin/js/filebird-admin-topbar.js', array( 'jquery' ) );
        wp_enqueue_script('media-library-elementor');
    }
}