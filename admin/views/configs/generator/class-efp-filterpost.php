<?php
/**
 * The Filter Post Meta-box configurations.
 *
 * @package Eventful
 * @subpackage admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	die; } // Cannot access pages directly.

/**
 * The Filter post building class.
 */
class EFP_FilterPost {

	/**
	 * Filter Post section metabox.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFP::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Filter Content', 'eventful-pro' ),
				'icon'   => 'fas fa-filter',
				'fields' => array(



					array(
						'id'          => 'efp_include_only_posts',
						'type'        => 'select',
						'title'       => esc_html__( 'Include Only', 'eventful-pro' ),
						'subtitle'    => esc_html__( 'Choose posts to include by title.', 'eventful-pro' ),
						'options'     => 'posts',
						'ajax'        => true,
						'sortable'    => true,
						'chosen'      => true,
						'class'       => 'ta_efp_include_only_posts',
						'multiple'    => true,
						'placeholder' => esc_html__( 'Choose posts', 'eventful-pro' ),
						'query_args'  => array(
							'post_type' => 'tribe_events',
							'cache_results' => false,
							'no_found_rows' => true,
						),
					),
					array(
						'id'       => 'efp_exclude_post_set',
						'type'     => 'fieldset',
						'title'    => esc_html__( 'Exclude', 'eventful-pro' ),
						'subtitle' => esc_html__( 'Choose posts to exclude by title.', 'eventful-pro' ),
						'class'    => 'ta_efp_exclude_post_set',
						'fields'   => array(
							array(
								'id'          => 'efp_exclude_posts',
								'type'        => 'select',
								'options'     => 'posts',
								'chosen'      => true,
								'class'       => 'ta_efp_exclude_posts',
								'multiple'    => true,
								'ajax'        => true,
								'placeholder' => esc_html__( 'Choose posts to exclude', 'eventful-pro' ),
								'query_args'  => array(
									'post_type' => 'tribe_events',
									'cache_results' => false,
									'no_found_rows' => true,
								),
								'dependency'  => array( 'efp_include_only_posts', '==', '', true ),
							),
							array(
								'id'      => 'efp_exclude_too',
								'type'    => 'checkbox',
								'class'   => 'ta_efp_exclude_too',
								'options' => array(
									'current'            => esc_html__( 'Current Post', 'eventful-pro' ),
									'password_protected' => esc_html__( 'Password Protected Posts', 'eventful-pro' ),
									'children'           => esc_html__( 'Children Posts', 'eventful-pro' ),
								),
							),
						),
					),
					array(
						'id'       => 'efp_post_limit',
						'title'    => esc_html__( 'Limit', 'eventful-pro' ),
						'type'     => 'spinner',
						'subtitle' => esc_html__( 'Number of total items to display. Leave it empty to show all found items.', 'eventful-pro' ),
						'sanitize' => 'efp_sanitize_number_field',
						'default'  => '15',
						'min'      => 1,
					),
					array(
						'id'       => 'efp_post_offset',
						'type'     => 'spinner',
						'title'    => esc_html__( 'Offset', 'eventful-pro' ),
						'subtitle' => esc_html__( 'Number of items to skip.', 'eventful-pro' ),
						'sanitize' => 'efp_sanitize_number_field',
						'default'  => 0,
					),
					array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Advanced Filtering', 'eventful-pro' ),
					),
					array(
						'id'       => 'efp_advanced_filter',
						'type'     => 'checkbox',
						'class'    => 'efp_column_2 efp_advanced_filter',
						'title'    => esc_html__( 'Filter by', 'eventful-pro' ),
						'subtitle' => esc_html__( 'Check the option(s) to filter by.', 'eventful-pro' ),
						'options'  => array(
							'taxonomy'     => esc_html__( 'Taxonomy', 'eventful-pro' ),
							'author'       => esc_html__( 'Author', 'eventful-pro' ),
							'sortby'       => esc_html__( 'Sort By', 'eventful-pro' ),
							'status'       => esc_html__( 'Status', 'eventful-pro' ),
							'keyword'      => esc_html__( 'Keyword', 'eventful-pro' ),
						),
					),
					array(
						'id'         => 'efp_filter_by_taxonomy',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Taxonomy', 'eventful-pro' ),
								'icon'   => 'fas fa-folder-open',
								'fields' => array(
									// The Group Fields.
									array(
										'id'     => 'efp_taxonomy_and_terms',
										'type'   => 'group',
										'class'  => 'efp_taxonomy_terms_group efp_custom_group_design',
										'accordion_title_auto' => true,
										'fields' => array(
											array(
												'id'      => 'efp_select_taxonomy',
												'type'    => 'select',
												'title'   => esc_html__( 'Select Taxonomy', 'eventful-pro' ),
												'class'   => 'ta_efp_post_taxonomy',
												'options' => 'taxonomy',
												'query_args' => array(
													'type' => 'post',
												),
												'attributes' => array(
													'style' => 'width: 200px;',
												),
												'empty_message' => esc_html__( 'No taxonomies found.', 'eventful-pro' ),
											),
											array(
												'id'      => 'hide_taxonomy_name',
												'type'    => 'checkbox',
												'title'   => esc_html__('Hide Taxonomy Name', 'eventful'),
												'class'   => 'hide_taxonomy_name',
												'default' => false,
											),
											array(
												'id'       => 'efp_select_terms',
												'type'     => 'select',
												'title'    => esc_html__( 'Choose Term(s)', 'eventful-pro' ),
												'title_help' => esc_html__( 'Choose the taxonomy term(s) to show the posts from. Leave empty to show all found taxonomy term(s).', 'eventful-pro' ),
												'options'  => 'terms',
												'class'    => 'ta_efp_taxonomy_terms',
												'width'    => '300px',
												'multiple' => true,
												'sortable' => true,
												'empty_message' => esc_html__( 'No terms found.', 'eventful-pro' ),
												'placeholder' => esc_html__( 'Select Term(s)', 'eventful-pro' ),
												'chosen'   => true,
											),
											array(
												'id'      => 'efp_taxonomy_term_operator',
												'type'    => 'select',
												'title'   => esc_html__( 'Operator', 'eventful-pro' ),
												'options' => array(
													'IN'  => esc_html__( 'IN', 'eventful-pro' ),
													'AND' => esc_html__( 'AND', 'eventful-pro' ),
													'NOT IN' => esc_html__( 'NOT IN', 'eventful-pro' ),
												),
												'default' => 'IN',
												'title_help' => esc_html__( 'IN - Show posts which associate with one or more terms<br>AND - Show posts which match all terms<br>NOT IN - Show posts which don\'t match the terms', 'eventful-pro' ),
											),
											array(
												'id'    => 'add_filter_post',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Add to Ajax Live Filters', 'eventful-pro' ),
												'title_help' => esc_html__( 'Check to add ajax live filters.', 'eventful-pro' ),
											),
											array(
												'id'     => 'ajax_filter_options',
												'type'   => 'fieldset',
												'title'  => esc_html__( 'Ajax Live Filters', 'eventful-pro' ),
												'dependency' => array( 'add_filter_post', '==', 'true' ),
												'fields' => array(
													array(
														'id'       => 'ajax_filter_style',
														'type'     => 'select',
														'title'    => esc_html__( 'Filter Type', 'eventful-pro' ),
														'title_help' => esc_html__( 'Select a type for live filter.', 'eventful-pro' ),
														'options'  => array(
															'fl_dropdown' => esc_html__( 'Dropdown', 'eventful-pro' ),
															'fl_radio'    => esc_html__( 'Radio', 'eventful-pro' ),
															'fl_checkbox'      => esc_html__( 'Checkbox', 'eventful-pro' ),
															'fl_btn'      => esc_html__( 'Button', 'eventful-pro' ),
														),
														'default'  => 'fl_btn',
													),
													array(
														'id'       => 'efp_filter_btn_color',
														'type'     => 'color_group',
														'title'    => esc_html__( 'Button Color', 'eventful-pro' ),
														'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
														'options'  => array(
															'text_color'        => esc_html__( 'Text Color', 'eventful-pro' ),
															'text_acolor'       => esc_html__( 'Text Hover', 'eventful-pro' ),
															'border_color'      => esc_html__( 'Border Color', 'eventful-pro' ),
															'border_acolor'     => esc_html__( 'Border Hover', 'eventful-pro' ),
															'background'        => esc_html__( 'Background', 'eventful-pro' ),
															'active_background' => esc_html__( 'Active/Hover BG', 'eventful-pro' ),
														),
														'default'  => array(
															'text_color'        => '#5e5e5e',
															'text_acolor'       => '#ffffff',
															'border_color'      => '#bbbbbb',
															'border_acolor'     => '#0015b5',
															'background'        => '#ffffff',
															'active_background' => '#0015b5',
														),
													),
													array(
														'id'         => 'efp_margin_between_button',
														'type'       => 'spacing',
														'title'      => esc_html__( 'Margin Between Buttons', 'eventful-pro' ),
														'sanitize'   => 'efp_sanitize_number_array_field',
														'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful-pro' ),
														'units'      => array( 'px' ),
														'default'    => array(
															'top'    => '0',
															'right'  => '8',
															'bottom' => '8',
															'left'   => '0',
															'unit'   => 'px',
														),
														'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
													),
													array(
														'id'       => 'ajax_filter_label',
														'type'     => 'text',
														'title'    => esc_html__( 'Label', 'eventful-pro' ),
														'title_help' => esc_html__( 'Type live filter label.', 'eventful-pro' ),
													),
													array(
														'id'       => 'ajax_rename_all_text',
														'type'     => 'text',
														'title'    => esc_html__( 'Rename "All" Text', 'eventful-pro' ),
														'title_help' => esc_html__( 'Leave it empty to hide "All" text.', 'eventful-pro' ),
														'default'  => esc_html__( 'All', 'eventful-pro' ),
														'dependency' => array( 'ajax_filter_style', '!=', 'fl_checkbox' ),
													),
													array(
														'id'       => 'ajax_hide_empty',
														'type'     => 'checkbox',
														'title'    => esc_html__( 'Hide Empty Term(s)', 'eventful-pro' ),
														'title_help' => esc_html__( 'Check to hide empty terms.', 'eventful-pro' ),
													),
													array(
														'id'       => 'ajax_show_count',
														'type'     => 'checkbox',
														'title'    => esc_html__( 'Show Post Count', 'eventful-pro' ),
														'title_help' => esc_html__( 'Check to show post count.', 'eventful-pro' ),
														'default'  => false,
													),
													array(
														'id'       => 'efp_live_filter_align',
														'type'     => 'button_set',
														'title'    => esc_html__( 'Alignment', 'eventful-pro' ),
														'options'    => array(
															'left'   => wp_kses( __('<i class="fas fa-align-left" title="Left"></i>', 'eventful'), array('i' => array('class' => array()))),
															'center' => wp_kses( __('<i class="fas fa-align-center" title="Center"></i>', 'eventful'), array('i' => array('class' => array()))),
															'right'  => wp_kses( __('<i class="fas fa-align-right" title="Right"></i>', 'eventful'), array('i' => array('class' => array()))),
														),
														'default'  => 'center',
													),
												),
											),

										),
									), // Group field end.
									array(
										'id'         => 'efp_taxonomies_relation',
										'type'       => 'select',
										'title'      => esc_html__( 'Relation', 'eventful-pro' ),
										'class'      => 'efp_relate_among_taxonomies',
										'options'    => array(
											'AND' => esc_html__( 'AND', 'eventful-pro' ),
											'OR'  => esc_html__( 'OR', 'eventful-pro' ),
										),
										'default'    => 'AND',
										'title_help' => esc_html__( 'The logical relationship between/among above taxonomies.', 'eventful-pro' ),
									),

								), // Fields array.
							),
						), // Accordions end.
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'author,sortby,custom_field,status,keyword' ),
					),
					array(
						'id'         => 'efp_filter_by_author',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Author', 'eventful-pro' ),
								'icon'   => 'fas fa-user',
								'fields' => array(
									array(
										'id'      => 'efp_select_author_by',
										'type'    => 'checkbox',
										'title'   => esc_html__( 'Post by Author', 'eventful-pro' ),
										'options' => 'users',
									),
									array(
										'id'         => 'add_author_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful-pro' ),
										'title_help' => esc_html__( 'Check to add ajax live filters.', 'eventful-pro' ),
										'dependency' => array( 'efp_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful-pro' ),
										'dependency' => array( 'add_author_filter_post', '==', 'true', true ),
										'fields'     => array(
											array(
												'id'      => 'ajax_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful-pro' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful-pro' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful-pro' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful-pro' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful-pro' ),
												),
												'default' => 'fl_btn',
											),
											array(
												'id'       => 'efp_author_btn_color',
												'type'     => 'color_group',
												'title'    => esc_html__( 'Button Color', 'eventful-pro' ),
												'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
												'options'  => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful-pro' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful-pro' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful-pro' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful-pro' ),
													'background'        => esc_html__( 'Background', 'eventful-pro' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful-pro' ),
												),
												'default'  => array(
													'text_color'        => '#5e5e5e',
													'text_acolor'       => '#ffffff',
													'border_color'      => '#bbbbbb',
													'border_acolor'     => '#0015b5',
													'background'        => '#ffffff',
													'active_background' => '#0015b5',
												),
											),
											array(
												'id'         => 'author_margin_between_button',
												'type'       => 'spacing',
												'title'      => esc_html__( 'Margin Between Buttons', 'eventful-pro' ),
												'sanitize'   => 'efp_sanitize_number_array_field',
												'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful-pro' ),
												'units'      => array( 'px' ),
												'default'    => array(
													'top'    => '0',
													'right'  => '8',
													'bottom' => '8',
													'left'   => '0',
													'unit'   => 'px',
												),
												'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
											),
											array(
												'id'    => 'ajax_filter_label',
												'type'  => 'text',
												'title' => esc_html__( 'Label', 'eventful-pro' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful-pro' ),
											),
											array(
												'id'      => 'ajax_rename_all_text',
												'type'    => 'text',
												'title'   => esc_html__( 'Rename "All" Text', 'eventful-pro' ),
												'title_help' => esc_html__( 'Rename "All" text.', 'eventful-pro' ),
												'default' => esc_html__( 'All', 'eventful-pro' ),
											),
											array(
												'id'    => 'ajax_hide_empty',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Hide Empty author', 'eventful-pro' ),
												'title_help' => esc_html__( 'Check to hide empty author.', 'eventful-pro' ),
											),
											array(
												'id'    => 'ajax_show_count',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Show Post Count', 'eventful-pro' ),
												'title_help' => esc_html__( 'Check to show post count.', 'eventful-pro' ),
											),
											array(
												'id'      => 'efp_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful-pro' ),
												'options'    => array(
													'left'   => wp_kses( __('<i class="fas fa-align-left" title="Left"></i>', 'eventful'), array('i' => array('class' => array()))),
													'center' => wp_kses( __('<i class="fas fa-align-center" title="Center"></i>', 'eventful'), array('i' => array('class' => array()))),
													'right'  => wp_kses( __('<i class="fas fa-align-right" title="Right"></i>', 'eventful'), array('i' => array('class' => array()))),
												),
												'default' => 'center',
											),
										),
									),
									array(
										'id'      => 'efp_select_author_not_by',
										'type'    => 'checkbox',
										'title'   => esc_html__( 'Post Not by Author ', 'eventful-pro' ),
										'options' => 'users',
									),
								),
							),
						),
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'taxonomy,sortby,custom_field,status,keyword' ),
					),
					array(
						'id'         => 'efp_filter_by_order',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__('Sort By', 'eventful'),
								'icon'   => 'fas fa-sort',
								'fields' => array(
									array(
										'id'      => 'efp_select_filter_orderby',
										'type'    => 'select',
										'title'   => esc_html__( 'Order by', 'eventful-pro' ),
										'options' => array(
											'ID'           => esc_html__( 'ID', 'eventful-pro' ),
											'title'        => esc_html__( 'Title', 'eventful-pro' ),
											'date'         => esc_html__( 'Date', 'eventful-pro' ),
											'modified'     => esc_html__( 'Modified date', 'eventful-pro' ),
											'post_slug'    => esc_html__( 'Post slug', 'eventful-pro' ),
											'post_type'    => esc_html__( 'Post type', 'eventful-pro' ),
											'rand'         => esc_html__( 'Random', 'eventful-pro' ),
											'comment_count' => esc_html__( 'Comment count', 'eventful-pro' ),
											'menu_order'   => esc_html__( 'Menu order', 'eventful-pro' ),
											'author'       => esc_html__( 'Author', 'eventful-pro' ),
											'most_liked'   => esc_html__( 'Most Liked', 'eventful-pro' ),
											'most_viewed'  => esc_html__( 'Most Viewed', 'eventful-pro' ),
										),
										'default' => 'date',
									),
									array(
										'id'         => 'orderby_custom_field_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Order by Custom Field', 'eventful-pro' ),
										'dependency' => array( 'efp_select_filter_orderby', '==', 'custom_field', true ),
										'fields'     => array(
											array(
												'id'      => 'efp_select_custom_field_key',
												'type'    => 'select',
												'title'   => esc_html__( 'Custom Fields Keys', 'eventful-pro' ),
												'title_help' => esc_html__( 'Select custom fields key.', 'eventful-pro' ),
												'options' => 'custom_fields',
												'chosen'  => true,
												'attributes' => array(
													'style' => 'width: 200px;',
												),
												'empty_message' => esc_html__( 'No custom field keys found.', 'eventful-pro' ),
											),
											array(
												'id'      => 'efp_select_custom_field_value_type',
												'type'    => 'select',
												'title'   => esc_html__( 'Value Type', 'eventful-pro' ),
												'title_help' => esc_html__( 'Select a value type.', 'eventful-pro' ),
												'options' => array(
													'CHAR' => esc_html__( 'Text', 'eventful-pro' ),
													'NUMERIC' => esc_html__( 'Number', 'eventful-pro' ),
													'DATE' => esc_html__( 'Date', 'eventful-pro' ),
													'BOOLEAN' => esc_html__( 'True/False', 'eventful-pro' ),
												),
												'default' => 'NUMERIC',
											),
										),
									),
									array(
										'id'         => 'add_orderby_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful-pro' ),
										'title_help' => esc_html__( 'Check to add ajax live filter for Order by.', 'eventful-pro' ),
										'dependency' => array( 'efp_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'orderby_ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful-pro' ),
										'fields'     => array(
											array(
												'id'      => 'orderby_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful-pro' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful-pro' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful-pro' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful-pro' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful-pro' ),
												),
												'default' => 'fl_dropdown',
											),
											array(
												'id'      => 'efp_orderby_filter_btn_color',
												'type'    => 'color_group',
												'title'   => esc_html__( 'Button Color', 'eventful-pro' ),
												'dependency' => array( 'orderby_filter_style', '==', 'fl_btn' ),
												'options' => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful-pro' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful-pro' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful-pro' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful-pro' ),
													'background'        => esc_html__( 'Background', 'eventful-pro' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful-pro' ),
												),
												'default' => array(
													'text_color'        => '#5e5e5e',
													'text_acolor'       => '#ffffff',
													'border_color'      => '#bbbbbb',
													'border_acolor'     => '#0015b5',
													'background'        => '#ffffff',
													'active_background' => '#0015b5',
												),
											),
											array(
												'id'         => 'order_margin_between_button',
												'type'       => 'spacing',
												'title'      => esc_html__( 'Margin Between Buttons', 'eventful-pro' ),
												'sanitize'   => 'efp_sanitize_number_array_field',
												'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful-pro' ),
												'units'      => array( 'px' ),
												'default'    => array(
													'top'    => '0',
													'right'  => '8',
													'bottom' => '8',
													'left'   => '0',
													'unit'   => 'px',
												),
												'dependency' => array( 'orderby_filter_style', '==', 'fl_btn' ),
											),
											array(
												'id'       => 'efp_add_filter_orderby',
												'type'     => 'select',
												'title'    => esc_html__( 'Order by', 'eventful-pro' ),
												'title_help' => esc_html__( 'Choose order by options to show to the visitors.', 'eventful-pro' ),
												'chosen'   => true,
												'multiple' => true,
												'sortable' => true,
												'options'  => array(
													'ID'   => esc_html__( 'ID', 'eventful-pro' ),
													'title' => esc_html__( 'Title', 'eventful-pro' ),
													'date' => esc_html__( 'Date', 'eventful-pro' ),
													'modified' => esc_html__( 'Modified date', 'eventful-pro' ),
													'post_type' => esc_html__( 'Post type', 'eventful-pro' ),
													'rand' => esc_html__( 'Random', 'eventful-pro' ),
													'comment_count' => esc_html__( 'Comment count', 'eventful-pro' ),
													'menu_order' => esc_html__( 'Menu order', 'eventful-pro' ),
													'author' => esc_html__( 'Author', 'eventful-pro' ),
													'most_liked' => esc_html__( 'Most Liked', 'eventful-pro' ),
													'most_viewed' => esc_html__( 'Most Viewed', 'eventful-pro' ),
												),
											),
											array(
												'id'      => 'ajax_filter_label',
												'type'    => 'text',
												'title'   => esc_html__( 'Label', 'eventful-pro' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful-pro' ),
												'default' => esc_html__( 'Order by', 'eventful-pro' ),
											),
											array(
												'id'      => 'efp_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful-pro' ),
												'options'    => array(
													'left'   => wp_kses( __('<i class="fas fa-align-left" title="Left"></i>', 'eventful'), array('i' => array('class' => array()))),
													'center' => wp_kses( __('<i class="fas fa-align-center" title="Center"></i>', 'eventful'), array('i' => array('class' => array()))),
													'right'  => wp_kses( __('<i class="fas fa-align-right" title="Right"></i>', 'eventful'), array('i' => array('class' => array()))),
												),
												'default' => 'center',
											),
										),
										'dependency' => array( 'add_orderby_filter_post', '==', 'true' ),
									),
									array(
										'id'         => 'efp_select_filter_order',
										'type'       => 'select',
										'title'      => esc_html__( 'Order', 'eventful-pro' ),
										'options'    => array(
											'ASC'  => esc_html__( 'Ascending', 'eventful-pro' ),
											'DESC' => esc_html__( 'Descending', 'eventful-pro' ),
										),
										'default'    => 'DESC',
										'dependency' => array( 'efp_select_filter_orderby', '!=', 'post__in' ),
									),
									array(
										'id'         => 'add_order_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful-pro' ),
										'title_help' => esc_html__( 'Check to add ajax live filter for order.', 'eventful-pro' ),
										'dependency' => array( 'efp_select_filter_orderby|efp_layout_preset', '!=|!=', 'post__in|filter_layout', true ),
									),
									array(
										'id'         => 'order_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful-pro' ),
										'dependency' => array( 'add_order_filter_post|efp_select_filter_orderby', '==|!=', 'true|post__in', true ),
										'fields'     => array(
											array(
												'id'      => 'order_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful-pro' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful-pro' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful-pro' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful-pro' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful-pro' ),
												),
												'default' => 'fl_btn',
											),
											array(
												'id'      => 'efp_order_filter_button_color',
												'type'    => 'color_group',
												'title'   => esc_html__( 'Button Color', 'eventful-pro' ),
												'dependency' => array( 'order_filter_style', '==', 'fl_btn' ),
												'options' => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful-pro' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful-pro' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful-pro' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful-pro' ),
													'background'        => esc_html__( 'Background', 'eventful-pro' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful-pro' ),
												),
												'default' => array(
													'text_color'        => '#5e5e5e',
													'text_acolor'       => '#ffffff',
													'border_color'      => '#bbbbbb',
													'border_acolor'     => '#0015b5',
													'background'        => '#ffffff',
													'active_background' => '#0015b5',
												),
											),
											array(
												'id'      => 'order_filter_label',
												'type'    => 'text',
												'title'   => esc_html__( 'Label', 'eventful-pro' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful-pro' ),
												'default' => esc_html__( 'Order', 'eventful-pro' ),
											),
											array(
												'id'      => 'efp_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful-pro' ),
												'options'    => array(
													'left'   => wp_kses( __('<i class="fas fa-align-left" title="Left"></i>', 'eventful'), array('i' => array('class' => array()))),
													'center' => wp_kses( __('<i class="fas fa-align-center" title="Center"></i>', 'eventful'), array('i' => array('class' => array()))),
													'right'  => wp_kses( __('<i class="fas fa-align-right" title="Right"></i>', 'eventful'), array('i' => array('class' => array()))),
												),
												'default' => 'center',
											),

										),
									),
								),
							),
						),
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'taxonomy,author,status,date,keyword' ),
					),
					array(
						'id'         => 'efp_filter_by_status',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Status', 'eventful-pro' ),
								'icon'   => 'fas fa-lock',
								'fields' => array(
									array(
										'id'       => 'efp_select_post_status',
										'type'     => 'select',
										'title'    => esc_html__( 'Post Status', 'eventful-pro' ),
										'options'  => 'post_statuses',
										'multiple' => true,
										'chosen'   => true,
									),
								),
							),
						),
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,date,keyword' ),
					),
					array(
						'id'         => 'efp_filter_by_date',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Published Date', 'eventful-pro' ),
								'icon'   => 'fas fa-calendar',
								'fields' => array(
									array(
										'id'      => 'efp_select_post_date_type',
										'type'    => 'radio',
										'class'   => 'efp_column_2',
										'options' => array(
											'yesterday'  => esc_html__( 'Yesterday', 'eventful-pro' ),
											'today_only' => esc_html__( 'Today Only', 'eventful-pro' ),
											'today_onwards' => esc_html__( 'Today and Onwards', 'eventful-pro' ),
											'this_week'  => esc_html__( 'This Week', 'eventful-pro' ),
											'this_month' => esc_html__( 'This Month', 'eventful-pro' ),
											'this_year'  => esc_html__( 'This Year', 'eventful-pro' ),
											'week_ago'   => esc_html__( '1 Week ago to today', 'eventful-pro' ),
											'month_ago'  => esc_html__( '1 month ago to today', 'eventful-pro' ),
											'year_ago'   => esc_html__( '1 year ago to today', 'eventful-pro' ),
											'specific_date' => esc_html__( 'Specific Date', 'eventful-pro' ),
											'specific_month' => esc_html__( 'Specific Month', 'eventful-pro' ),
											'specific_year' => esc_html__( 'Specific Year', 'eventful-pro' ),
											'specific_period' => esc_html__( 'Specific Period ( From & To )', 'eventful-pro' ),
										),
										'default' => 'today_only',
									),
									array(
										'id'          => 'efp_select_post_date_from_to',
										'type'        => 'date',
										'title'       => esc_html__( 'Set Period', 'eventful-pro' ),
										'from_to'     => true,
										'text_from'   => esc_html__( 'From:', 'eventful-pro' ),
										'text_to'     => esc_html__( 'To:', 'eventful-pro' ),
										'settings'    => array(
											'dateFormat'  => 'yy-mm-dd',
											'changeMonth' => true,
											'changeYear'  => true,
										),
										'placeholder' => esc_html__( 'yy-mm-dd', 'eventful-pro' ),
										'dependency'  => array( 'efp_select_post_date_type', '==', 'specific_period' ),
									),
									array(
										'id'          => 'efp_select_post_specific_date',
										'type'        => 'date',
										'title'       => esc_html__( 'Select Date', 'eventful-pro' ),
										'settings'    => array(
											'dateFormat'  => 'yy-mm-dd',
											'changeMonth' => true,
											'changeYear'  => true,
										),
										'placeholder' => esc_html__( 'yy-mm-dd', 'eventful-pro' ),
										'dependency'  => array( 'efp_select_post_date_type', '==', 'specific_date' ),
									),
									array(
										'id'         => 'efp_select_specific_month',
										'type'       => 'select',
										'title'      => esc_html__( 'Select Month', 'eventful-pro' ),
										'options'    => array(
											'1'  => esc_html__( 'January', 'eventful-pro' ),
											'2'  => esc_html__( 'February', 'eventful-pro' ),
											'3'  => esc_html__( 'March', 'eventful-pro' ),
											'4'  => esc_html__( 'April', 'eventful-pro' ),
											'0'  => esc_html__( 'May', 'eventful-pro' ),
											'6'  => esc_html__( 'June', 'eventful-pro' ),
											'7'  => esc_html__( 'July', 'eventful-pro' ),
											'8'  => esc_html__( 'August', 'eventful-pro' ),
											'9'  => esc_html__( 'September', 'eventful-pro' ),
											'10' => esc_html__( 'October', 'eventful-pro' ),
											'11' => esc_html__( 'November', 'eventful-pro' ),
											'12' => esc_html__( 'December', 'eventful-pro' ),
										),
										'dependency' => array( 'efp_select_post_date_type', '==', 'specific_month' ),
									),
									array(
										'id'              => 'efp_select_post_specific_year',
										'type'            => 'spacing',
										'title'           => esc_html__( 'Set Year', 'eventful-pro' ),
										'sanitize'        => 'efp_sanitize_number_array_field',
										'all'             => true,
										'all_icon'        => false,
										'all_placeholder' => '2019',
										'show_units'      => false,
										'default'         => array(
											'all' => '2019',
										),
										'min'             => '1990',
										'dependency'      => array( 'efp_select_post_date_type', '==', 'specific_year' ),
									),
								), // Fields.
							),
						), // Accordions.
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,status,keyword' ),
					),
					array(
						'id'         => 'efp_filter_by_keyword',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 efp-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Keyword', 'eventful-pro' ),
								'icon'   => 'fas fa-key',
								'fields' => array(
									array(
										'id'         => 'efp_set_post_keyword',
										'type'       => 'text',
										'title'      => esc_html__( 'Type Keyword', 'eventful-pro' ),
										'title_help' => esc_html__( 'Enter keyword(s) for searching the posts.', 'eventful-pro' ),
										'options'    => 'post_statuses',
									),
									array(
										'id'         => 'add_search_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful-pro' ),
										'title_help' => esc_html__( 'Check to add ajax live filter.', 'eventful-pro' ),
										'dependency' => array( 'efp_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful-pro' ),
										'dependency' => array( 'add_search_filter_post', '==', 'true', true ),
										'fields'     => array(
											array(
												'id'    => 'ajax_filter_label',
												'type'  => 'text',
												'title' => esc_html__( 'Label', 'eventful-pro' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful-pro' ),
											),
											array(
												'id'      => 'efp_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful-pro' ),
												'options'    => array(
													'left'   => wp_kses( __('<i class="fas fa-align-left" title="Left"></i>', 'eventful'), array('i' => array('class' => array()))),
													'center' => wp_kses( __('<i class="fas fa-align-center" title="Center"></i>', 'eventful'), array('i' => array('class' => array()))),
													'right'  => wp_kses( __('<i class="fas fa-align-right" title="Right"></i>', 'eventful'), array('i' => array('class' => array()))),
												),
												'default' => 'center',
											),
										),
									),
								),
							),
						),
						'dependency' => array( 'efp_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,date,status' ),
					),
				),
			)
		); // Filter settings section end.
	}
}
