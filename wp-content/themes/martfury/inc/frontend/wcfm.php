<?php

/**
 * Class for all Vendor template modification
 *
 * @version 1.0
 */
class Martfury_WCFM {

	/**
	 * Construction function
	 *
	 * @since  1.0
	 * @return Martfury WCFM
	 */
	function __construct() {
		// Check if Woocomerce plugin is actived
		if ( ! class_exists( 'WCFM' ) ) {
			return;
		}

		if ( class_exists( 'TAWC_Deals' ) ) {
			add_filter( 'wcfm_product_manage_fields_pricing', array( $this, 'product_manage_fields_pricing' ), 20, 2 );
		}

		add_filter( 'wcfm_product_manage_fields_linked', array( $this, 'products_custom_fields_linked' ), 100, 3 );

		add_action( 'after_wcfm_products_manage_meta_save', array( $this, 'product_meta_save' ), 500, 2 );

		add_filter( 'wcfmmp_stores_default_args', array( $this, 'stores_list_default_args' ) );

	}

	function product_manage_fields_pricing( $fields, $product_id ) {
		$quantity                 = get_post_meta( $product_id, '_deal_quantity', true );
		$sales_counts             = get_post_meta( $product_id, '_deal_sales_counts', true );
		$sales_counts             = intval( $sales_counts );
		$fields["_deal_quantity"] = array(
			'label'       => esc_html__( 'Sale quantity', 'martfury' ),
			'type'        => 'number',
			'class'       => 'wcfm-text wcfm_ele wcfm_half_ele sales_schedule_ele simple external non-variable-subscription non-auction non-redq_rental non-accommodation-booking',
			'label_class' => 'wcfm_ele wcfm_half_ele_title sales_schedule_ele wcfm_title simple external non-variable-subscription non-auction non-redq_rental non-accommodation-booking',
			'value'       => $quantity
		);

		$fields["_deal_sales_counts"] = array(
			'label'       => esc_html__( 'Sold Items', 'martfury' ),
			'type'        => 'number',
			'class'       => 'wcfm-text wcfm_ele wcfm_half_ele sales_schedule_ele simple external non-variable-subscription non-auction non-redq_rental non-accommodation-booking',
			'label_class' => 'wcfm_ele wcfm_half_ele_title sales_schedule_ele wcfm_title simple external non-variable-subscription non-auction non-redq_rental non-accommodation-booking',
			'value'       => $sales_counts
		);

		return $fields;
	}

	function product_meta_save( $new_product_id, $wcfm_products_manage_form_data ) {
		if ( class_exists( 'TAWC_Deals' ) ) {
			$_deal_quantity     = ( isset( $wcfm_products_manage_form_data['_deal_quantity'] ) ) ? intval( $wcfm_products_manage_form_data['_deal_quantity'] ) : 0;
			$_deal_sales_counts = ( isset( $wcfm_products_manage_form_data['_deal_sales_counts'] ) ) ? intval( $wcfm_products_manage_form_data['_deal_sales_counts'] ) : 0;
			update_post_meta( $new_product_id, '_deal_quantity', $_deal_quantity );
			update_post_meta( $new_product_id, '_deal_sales_counts', $_deal_sales_counts );
		}

		$pbt_product_ids = ( isset( $wcfm_products_manage_form_data['mf_pbt_product_ids'] ) ) ? array_map( 'intval', (array) $wcfm_products_manage_form_data['mf_pbt_product_ids'] ) : array();
		update_post_meta( $new_product_id, 'mf_pbt_product_ids', $pbt_product_ids );
	}

	function products_custom_fields_linked( $fields, $product_id, $products_array ) {
		$pbt_product_ids = get_post_meta( $product_id, 'mf_pbt_product_ids', true );
		$pbt_product_ids = $pbt_product_ids ? $pbt_product_ids : array();
		if ( ! empty( $pbt_product_ids ) ) {
			foreach ( $pbt_product_ids as $pbt_product_id ) {
				$products_array[ $pbt_product_id ] = get_post( absint( $pbt_product_id ) )->post_title;
			}
		}
		$fields["mf_pbt_product_ids"] = array(
			'label'       => esc_html__( 'Frequently Bought Together', 'martfury' ),
			'type'        => 'select',
			'attributes'  => array( 'multiple' => 'multiple', 'style' => 'width: 60%;' ),
			'class'       => 'wcfm-select wcfm_ele simple variable',
			'label_class' => 'wcfm_title',
			'options'     => $products_array,
			'value'       => $pbt_product_ids,
		);

		return $fields;

	}

	function stores_list_default_args( $default ) {
		$default['per_row']  = 2;
		$default['per_page'] = 8;
		$default['theme']    = '';

		return $default;
	}

}

