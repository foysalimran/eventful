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
class EFUL_FilterPost {

	/**
	 * Filter Post section metabox.
	 *
	 * @param string $prefix The metabox key.
	 * @return void
	 */
	public static function section( $prefix ) {
		EFUL::createSection(
			$prefix,
			array(
				'title'  => esc_html__( 'Filter Content', 'eventful' ),
				'icon'   => 'fas fa-filter',
				'fields' => array(

					array(
						'id'          => 'eful_include_only_posts',
						'type'        => 'select',
						'title'       => esc_html__( 'Include Only', 'eventful' ),
						'subtitle'    => esc_html__( 'Choose posts to include by title.', 'eventful' ),
						'options'     => 'posts',
						'ajax'        => true,
						'sortable'    => true,
						'chosen'      => true,
						'class'       => 'eful_include_only_posts',
						'multiple'    => true,
						'placeholder' => esc_html__( 'Choose posts', 'eventful' ),
						'query_args'  => array(
							'post_type' => 'tribe_events',
							'cache_results' => false,
							'no_found_rows' => true,
						),
					),
					array(
						'id'       => 'eful_exclude_post_set',
						'type'     => 'fieldset',
						'title'    => esc_html__( 'Exclude', 'eventful' ),
						'subtitle' => esc_html__( 'Choose posts to exclude by title.', 'eventful' ),
						'class'    => 'eful_exclude_post_set',
						'fields'   => array(
							array(
								'id'          => 'eful_exclude_posts',
								'type'        => 'select',
								'options'     => 'posts',
								'chosen'      => true,
								'class'       => 'eful_exclude_posts',
								'multiple'    => true,
								'ajax'        => true,
								'placeholder' => esc_html__( 'Choose posts to exclude', 'eventful' ),
								'query_args'  => array(
									'post_type' => 'tribe_events',
									'cache_results' => false,
									'no_found_rows' => true,
								),
								'dependency'  => array( 'eful_include_only_posts', '==', '', true ),
							),
							array(
								'id'      => 'eful_exclude_too',
								'type'    => 'checkbox',
								'class'   => 'eful_exclude_too',
								'options' => array(
									'current'            => esc_html__( 'Current Post', 'eventful' ),
									'password_protected' => esc_html__( 'Password Protected Posts', 'eventful' ),
									'children'           => esc_html__( 'Children Posts', 'eventful' ),
								),
							),
						),
					),
					array(
						'id'       => 'eful_post_limit',
						'title'    => esc_html__( 'Limit', 'eventful' ),
						'type'     => 'spinner',
						'subtitle' => esc_html__( 'Number of total items to display. Leave it empty to show all found items.', 'eventful' ),
						'sanitize' => 'eful_sanitize_number_field',
						'default'  => '15',
						'min'      => 1,
					),
					array(
						'id'       => 'eful_post_offset',
						'type'     => 'spinner',
						'title'    => esc_html__( 'Offset', 'eventful' ),
						'subtitle' => esc_html__( 'Number of items to skip.', 'eventful' ),
						'sanitize' => 'eful_sanitize_number_field',
						'default'  => 0,
					),
					array(
						'type'    => 'subheading',
						'content' => esc_html__( 'Advanced Filtering', 'eventful' ),
					),
					array(
						'id'       => 'eful_advanced_filter',
						'type'     => 'checkbox',
						'class'    => 'eful_column_2 eful_advanced_filter',
						'title'    => esc_html__( 'Filter by', 'eventful' ),
						'subtitle' => esc_html__( 'Check the option(s) to filter by.', 'eventful' ),
						'options'  => array(
							'taxonomy'     => esc_html__( 'Taxonomy', 'eventful' ),
							'author'       => esc_html__( 'Author', 'eventful' ),
							'sortby'       => esc_html__( 'Sort By', 'eventful' ),
							'status'       => esc_html__( 'Status', 'eventful' ),
							'keyword'      => esc_html__( 'Keyword', 'eventful' ),
						),
					),
					array(
						'id'         => 'eful_filter_by_taxonomy',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Taxonomy', 'eventful' ),
								'icon'   => 'fas fa-folder-open',
								'fields' => array(
									// The Group Fields.
									array(
										'id'     => 'eful_taxonomy_and_terms',
										'type'   => 'group',
										'class'  => 'eful_taxonomy_terms_group eful_custom_group_design',
										'accordion_title_auto' => true,
										'fields' => array(
											array(
												'id'      => 'eful_select_taxonomy',
												'type'    => 'select',
												'title'   => esc_html__( 'Select Taxonomy', 'eventful' ),
												'class'   => 'eful_post_taxonomy',
												'options' => 'taxonomy',
												'query_args' => array(
													'type' => 'post',
												),
												'attributes' => array(
													'style' => 'width: 200px;',
												),
												'empty_message' => esc_html__( 'No taxonomies found.', 'eventful' ),
											),
											array(
												'id'      => 'hide_taxonomy_name',
												'type'    => 'checkbox',
												'title'   => esc_html__('Hide Taxonomy Name', 'eventful'),
												'class'   => 'hide_taxonomy_name',
												'default' => false,
											),
											array(
												'id'       => 'eful_select_terms',
												'type'     => 'select',
												'title'    => esc_html__( 'Choose Term(s)', 'eventful' ),
												'title_help' => esc_html__( 'Choose the taxonomy term(s) to show the posts from. Leave empty to show all found taxonomy term(s).', 'eventful' ),
												'options'  => 'terms',
												'class'    => 'eful_taxonomy_terms',
												'width'    => '300px',
												'multiple' => true,
												'sortable' => true,
												'empty_message' => esc_html__( 'No terms found.', 'eventful' ),
												'placeholder' => esc_html__( 'Select Term(s)', 'eventful' ),
												'chosen'   => true,
											),
											array(
												'id'      => 'eful_taxonomy_term_operator',
												'type'    => 'select',
												'title'   => esc_html__( 'Operator', 'eventful' ),
												'options' => array(
													'IN'  => esc_html__( 'IN', 'eventful' ),
													'AND' => esc_html__( 'AND', 'eventful' ),
													'NOT IN' => esc_html__( 'NOT IN', 'eventful' ),
												),
												'default' => 'IN',
												'title_help' => esc_html__( 'IN - Show posts which associate with one or more terms<br>AND - Show posts which match all terms<br>NOT IN - Show posts which don\'t match the terms', 'eventful' ),
											),
											array(
												'id'    => 'add_filter_post',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Add to Ajax Live Filters', 'eventful' ),
												'title_help' => esc_html__( 'Check to add ajax live filters.', 'eventful' ),
											),
											array(
												'id'     => 'ajax_filter_options',
												'type'   => 'fieldset',
												'title'  => esc_html__( 'Ajax Live Filters', 'eventful' ),
												'dependency' => array( 'add_filter_post', '==', 'true' ),
												'fields' => array(
													array(
														'id'       => 'ajax_filter_style',
														'type'     => 'select',
														'title'    => esc_html__( 'Filter Type', 'eventful' ),
														'title_help' => esc_html__( 'Select a type for live filter.', 'eventful' ),
														'options'  => array(
															'fl_dropdown' => esc_html__( 'Dropdown', 'eventful' ),
															'fl_radio'    => esc_html__( 'Radio', 'eventful' ),
															'fl_checkbox'      => esc_html__( 'Checkbox', 'eventful' ),
															'fl_btn'      => esc_html__( 'Button', 'eventful' ),
														),
														'default'  => 'fl_btn',
													),
													array(
														'id'       => 'eful_filter_btn_color',
														'type'     => 'color_group',
														'title'    => esc_html__( 'Button Color', 'eventful' ),
														'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
														'options'  => array(
															'text_color'        => esc_html__( 'Text Color', 'eventful' ),
															'text_acolor'       => esc_html__( 'Text Hover', 'eventful' ),
															'border_color'      => esc_html__( 'Border Color', 'eventful' ),
															'border_acolor'     => esc_html__( 'Border Hover', 'eventful' ),
															'background'        => esc_html__( 'Background', 'eventful' ),
															'active_background' => esc_html__( 'Active/Hover BG', 'eventful' ),
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
														'id'         => 'eful_margin_between_button',
														'type'       => 'spacing',
														'title'      => esc_html__( 'Margin Between Buttons', 'eventful' ),
														'sanitize'   => 'eful_sanitize_number_array_field',
														'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful' ),
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
														'title'    => esc_html__( 'Label', 'eventful' ),
														'title_help' => esc_html__( 'Type live filter label.', 'eventful' ),
													),
													array(
														'id'       => 'ajax_rename_all_text',
														'type'     => 'text',
														'title'    => esc_html__( 'Rename "All" Text', 'eventful' ),
														'title_help' => esc_html__( 'Leave it empty to hide "All" text.', 'eventful' ),
														'default'  => esc_html__( 'All', 'eventful' ),
														'dependency' => array( 'ajax_filter_style', '!=', 'fl_checkbox' ),
													),
													array(
														'id'       => 'ajax_hide_empty',
														'type'     => 'checkbox',
														'title'    => esc_html__( 'Hide Empty Term(s)', 'eventful' ),
														'title_help' => esc_html__( 'Check to hide empty terms.', 'eventful' ),
													),
													array(
														'id'       => 'ajax_show_count',
														'type'     => 'checkbox',
														'title'    => esc_html__( 'Show Post Count', 'eventful' ),
														'title_help' => esc_html__( 'Check to show post count.', 'eventful' ),
														'default'  => false,
													),
													array(
														'id'       => 'eful_live_filter_align',
														'type'     => 'button_set',
														'title'    => esc_html__( 'Alignment', 'eventful' ),
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
										'id'         => 'eful_taxonomies_relation',
										'type'       => 'select',
										'title'      => esc_html__( 'Relation', 'eventful' ),
										'options'    => array(
											'AND' => esc_html__( 'AND', 'eventful' ),
											'OR'  => esc_html__( 'OR', 'eventful' ),
										),
										'default'    => 'AND',
										'title_help' => esc_html__( 'The logical relationship between/among above taxonomies.', 'eventful' ),
									),

								), // Fields array.
							),
						), // Accordions end.
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'author,sortby,custom_field,status,keyword' ),
					),
					array(
						'id'         => 'eful_filter_by_author',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Author', 'eventful' ),
								'icon'   => 'fas fa-user',
								'fields' => array(
									array(
										'id'      => 'eful_select_author_by',
										'type'    => 'checkbox',
										'title'   => esc_html__( 'Post by Author', 'eventful' ),
										'options' => 'users',
									),
									array(
										'id'         => 'add_author_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful' ),
										'title_help' => esc_html__( 'Check to add ajax live filters.', 'eventful' ),
										'dependency' => array( 'eful_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful' ),
										'dependency' => array( 'add_author_filter_post', '==', 'true', true ),
										'fields'     => array(
											array(
												'id'      => 'ajax_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful' ),
												),
												'default' => 'fl_btn',
											),
											array(
												'id'       => 'eful_author_btn_color',
												'type'     => 'color_group',
												'title'    => esc_html__( 'Button Color', 'eventful' ),
												'dependency' => array( 'ajax_filter_style', '==', 'fl_btn' ),
												'options'  => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful' ),
													'background'        => esc_html__( 'Background', 'eventful' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful' ),
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
												'title'      => esc_html__( 'Margin Between Buttons', 'eventful' ),
												'sanitize'   => 'eful_sanitize_number_array_field',
												'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful' ),
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
												'title' => esc_html__( 'Label', 'eventful' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful' ),
											),
											array(
												'id'      => 'ajax_rename_all_text',
												'type'    => 'text',
												'title'   => esc_html__( 'Rename "All" Text', 'eventful' ),
												'title_help' => esc_html__( 'Rename "All" text.', 'eventful' ),
												'default' => esc_html__( 'All', 'eventful' ),
											),
											array(
												'id'    => 'ajax_hide_empty',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Hide Empty author', 'eventful' ),
												'title_help' => esc_html__( 'Check to hide empty author.', 'eventful' ),
											),
											array(
												'id'    => 'ajax_show_count',
												'type'  => 'checkbox',
												'title' => esc_html__( 'Show Post Count', 'eventful' ),
												'title_help' => esc_html__( 'Check to show post count.', 'eventful' ),
											),
											array(
												'id'      => 'eful_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful' ),
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
										'id'      => 'eful_select_author_not_by',
										'type'    => 'checkbox',
										'title'   => esc_html__( 'Post Not by Author ', 'eventful' ),
										'options' => 'users',
									),
								),
							),
						),
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'taxonomy,sortby,custom_field,status,keyword' ),
					),
					array(
						'id'         => 'eful_filter_by_order',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__('Sort By', 'eventful'),
								'icon'   => 'fas fa-sort',
								'fields' => array(
									array(
										'id'      => 'eful_select_filter_orderby',
										'type'    => 'select',
										'title'   => esc_html__( 'Order by', 'eventful' ),
										'options' => array(
											'ID'           => esc_html__( 'ID', 'eventful' ),
											'title'        => esc_html__( 'Title', 'eventful' ),
											'date'         => esc_html__( 'Date', 'eventful' ),
											'modified'     => esc_html__( 'Modified date', 'eventful' ),
											'post_slug'    => esc_html__( 'Post slug', 'eventful' ),
											'post_type'    => esc_html__( 'Post type', 'eventful' ),
											'rand'         => esc_html__( 'Random', 'eventful' ),
											'comment_count' => esc_html__( 'Comment count', 'eventful' ),
											'menu_order'   => esc_html__( 'Menu order', 'eventful' ),
											'author'       => esc_html__( 'Author', 'eventful' ),
											'most_liked'   => esc_html__( 'Most Liked', 'eventful' ),
											'most_viewed'  => esc_html__( 'Most Viewed', 'eventful' ),
										),
										'default' => 'date',
									),
									array(
										'id'         => 'orderby_custom_field_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Order by Custom Field', 'eventful' ),
										'dependency' => array( 'eful_select_filter_orderby', '==', 'custom_field', true ),
										'fields'     => array(
											array(
												'id'      => 'eful_select_custom_field_key',
												'type'    => 'select',
												'title'   => esc_html__( 'Custom Fields Keys', 'eventful' ),
												'title_help' => esc_html__( 'Select custom fields key.', 'eventful' ),
												'options' => 'custom_fields',
												'chosen'  => true,
												'attributes' => array(
													'style' => 'width: 200px;',
												),
												'empty_message' => esc_html__( 'No custom field keys found.', 'eventful' ),
											),
											array(
												'id'      => 'eful_select_custom_field_value_type',
												'type'    => 'select',
												'title'   => esc_html__( 'Value Type', 'eventful' ),
												'title_help' => esc_html__( 'Select a value type.', 'eventful' ),
												'options' => array(
													'CHAR' => esc_html__( 'Text', 'eventful' ),
													'NUMERIC' => esc_html__( 'Number', 'eventful' ),
													'DATE' => esc_html__( 'Date', 'eventful' ),
													'BOOLEAN' => esc_html__( 'True/False', 'eventful' ),
												),
												'default' => 'NUMERIC',
											),
										),
									),
									array(
										'id'         => 'add_orderby_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful' ),
										'title_help' => esc_html__( 'Check to add ajax live filter for Order by.', 'eventful' ),
										'dependency' => array( 'eful_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'orderby_ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful' ),
										'fields'     => array(
											array(
												'id'      => 'orderby_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful' ),
												),
												'default' => 'fl_dropdown',
											),
											array(
												'id'      => 'eful_orderby_filter_btn_color',
												'type'    => 'color_group',
												'title'   => esc_html__( 'Button Color', 'eventful' ),
												'dependency' => array( 'orderby_filter_style', '==', 'fl_btn' ),
												'options' => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful' ),
													'background'        => esc_html__( 'Background', 'eventful' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful' ),
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
												'title'      => esc_html__( 'Margin Between Buttons', 'eventful' ),
												'sanitize'   => 'eful_sanitize_number_array_field',
												'subtitle'   => esc_html__( 'Set margin between buttons.', 'eventful' ),
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
												'id'       => 'eful_add_filter_orderby',
												'type'     => 'select',
												'title'    => esc_html__( 'Order by', 'eventful' ),
												'title_help' => esc_html__( 'Choose order by options to show to the visitors.', 'eventful' ),
												'chosen'   => true,
												'multiple' => true,
												'sortable' => true,
												'options'  => array(
													'ID'   => esc_html__( 'ID', 'eventful' ),
													'title' => esc_html__( 'Title', 'eventful' ),
													'date' => esc_html__( 'Date', 'eventful' ),
													'modified' => esc_html__( 'Modified date', 'eventful' ),
													'post_type' => esc_html__( 'Post type', 'eventful' ),
													'rand' => esc_html__( 'Random', 'eventful' ),
													'comment_count' => esc_html__( 'Comment count', 'eventful' ),
													'menu_order' => esc_html__( 'Menu order', 'eventful' ),
													'author' => esc_html__( 'Author', 'eventful' ),
													'most_liked' => esc_html__( 'Most Liked', 'eventful' ),
													'most_viewed' => esc_html__( 'Most Viewed', 'eventful' ),
												),
											),
											array(
												'id'      => 'ajax_filter_label',
												'type'    => 'text',
												'title'   => esc_html__( 'Label', 'eventful' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful' ),
												'default' => esc_html__( 'Order by', 'eventful' ),
											),
											array(
												'id'      => 'eful_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful' ),
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
										'id'         => 'eful_select_filter_order',
										'type'       => 'select',
										'title'      => esc_html__( 'Order', 'eventful' ),
										'options'    => array(
											'ASC'  => esc_html__( 'Ascending', 'eventful' ),
											'DESC' => esc_html__( 'Descending', 'eventful' ),
										),
										'default'    => 'DESC',
										'dependency' => array( 'eful_select_filter_orderby', '!=', 'post__in' ),
									),
									array(
										'id'         => 'add_order_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful' ),
										'title_help' => esc_html__( 'Check to add ajax live filter for order.', 'eventful' ),
										'dependency' => array( 'eful_select_filter_orderby|eful_layout_preset', '!=|!=', 'post__in|filter_layout', true ),
									),
									array(
										'id'         => 'order_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful' ),
										'dependency' => array( 'add_order_filter_post|eful_select_filter_orderby', '==|!=', 'true|post__in', true ),
										'fields'     => array(
											array(
												'id'      => 'order_filter_style',
												'type'    => 'select',
												'title'   => esc_html__( 'Filter Type', 'eventful' ),
												'title_help' => esc_html__( 'Select a type for live filter.', 'eventful' ),
												'options' => array(
													'fl_dropdown' => esc_html__( 'Dropdown', 'eventful' ),
													'fl_radio'    => esc_html__( 'Radio', 'eventful' ),
													'fl_btn'      => esc_html__( 'Button', 'eventful' ),
												),
												'default' => 'fl_btn',
											),
											array(
												'id'      => 'eful_order_filter_button_color',
												'type'    => 'color_group',
												'title'   => esc_html__( 'Button Color', 'eventful' ),
												'dependency' => array( 'order_filter_style', '==', 'fl_btn' ),
												'options' => array(
													'text_color'        => esc_html__( 'Text Color', 'eventful' ),
													'text_acolor'       => esc_html__( 'Text Hover', 'eventful' ),
													'border_color'      => esc_html__( 'Border Color', 'eventful' ),
													'border_acolor'     => esc_html__( 'Border Hover', 'eventful' ),
													'background'        => esc_html__( 'Background', 'eventful' ),
													'active_background' => esc_html__( 'Active/Hover BG', 'eventful' ),
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
												'title'   => esc_html__( 'Label', 'eventful' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful' ),
												'default' => esc_html__( 'Order', 'eventful' ),
											),
											array(
												'id'      => 'eful_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful' ),
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
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'taxonomy,author,status,date,keyword' ),
					),
					array(
						'id'         => 'eful_filter_by_status',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Status', 'eventful' ),
								'icon'   => 'fas fa-lock',
								'fields' => array(
									array(
										'id'       => 'eful_select_post_status',
										'type'     => 'select',
										'title'    => esc_html__( 'Post Status', 'eventful' ),
										'options'  => 'post_statuses',
										'multiple' => true,
										'chosen'   => true,
									),
								),
							),
						),
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,date,keyword' ),
					),
					array(
						'id'         => 'eful_filter_by_date',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Published Date', 'eventful' ),
								'icon'   => 'fas fa-calendar',
								'fields' => array(
									array(
										'id'      => 'eful_select_post_date_type',
										'type'    => 'radio',
										'class'   => 'eful_column_2',
										'options' => array(
											'yesterday'  => esc_html__( 'Yesterday', 'eventful' ),
											'today_only' => esc_html__( 'Today Only', 'eventful' ),
											'today_onwards' => esc_html__( 'Today and Onwards', 'eventful' ),
											'this_week'  => esc_html__( 'This Week', 'eventful' ),
											'this_month' => esc_html__( 'This Month', 'eventful' ),
											'this_year'  => esc_html__( 'This Year', 'eventful' ),
											'week_ago'   => esc_html__( '1 Week ago to today', 'eventful' ),
											'month_ago'  => esc_html__( '1 month ago to today', 'eventful' ),
											'year_ago'   => esc_html__( '1 year ago to today', 'eventful' ),
											'specific_date' => esc_html__( 'Specific Date', 'eventful' ),
											'specific_month' => esc_html__( 'Specific Month', 'eventful' ),
											'specific_year' => esc_html__( 'Specific Year', 'eventful' ),
											'specific_period' => esc_html__( 'Specific Period ( From & To )', 'eventful' ),
										),
										'default' => 'today_only',
									),
									array(
										'id'          => 'eful_select_post_date_from_to',
										'type'        => 'date',
										'title'       => esc_html__( 'Set Period', 'eventful' ),
										'from_to'     => true,
										'text_from'   => esc_html__( 'From:', 'eventful' ),
										'text_to'     => esc_html__( 'To:', 'eventful' ),
										'settings'    => array(
											'dateFormat'  => 'yy-mm-dd',
											'changeMonth' => true,
											'changeYear'  => true,
										),
										'placeholder' => esc_html__( 'yy-mm-dd', 'eventful' ),
										'dependency'  => array( 'eful_select_post_date_type', '==', 'specific_period' ),
									),
									array(
										'id'          => 'eful_select_post_specific_date',
										'type'        => 'date',
										'title'       => esc_html__( 'Select Date', 'eventful' ),
										'settings'    => array(
											'dateFormat'  => 'yy-mm-dd',
											'changeMonth' => true,
											'changeYear'  => true,
										),
										'placeholder' => esc_html__( 'yy-mm-dd', 'eventful' ),
										'dependency'  => array( 'eful_select_post_date_type', '==', 'specific_date' ),
									),
									array(
										'id'         => 'eful_select_specific_month',
										'type'       => 'select',
										'title'      => esc_html__( 'Select Month', 'eventful' ),
										'options'    => array(
											'1'  => esc_html__( 'January', 'eventful' ),
											'2'  => esc_html__( 'February', 'eventful' ),
											'3'  => esc_html__( 'March', 'eventful' ),
											'4'  => esc_html__( 'April', 'eventful' ),
											'0'  => esc_html__( 'May', 'eventful' ),
											'6'  => esc_html__( 'June', 'eventful' ),
											'7'  => esc_html__( 'July', 'eventful' ),
											'8'  => esc_html__( 'August', 'eventful' ),
											'9'  => esc_html__( 'September', 'eventful' ),
											'10' => esc_html__( 'October', 'eventful' ),
											'11' => esc_html__( 'November', 'eventful' ),
											'12' => esc_html__( 'December', 'eventful' ),
										),
										'dependency' => array( 'eful_select_post_date_type', '==', 'specific_month' ),
									),
									array(
										'id'              => 'eful_select_post_specific_year',
										'type'            => 'spacing',
										'title'           => esc_html__( 'Set Year', 'eventful' ),
										'sanitize'        => 'eful_sanitize_number_array_field',
										'all'             => true,
										'all_icon'        => false,
										'all_placeholder' => '2019',
										'show_units'      => false,
										'default'         => array(
											'all' => '2019',
										),
										'min'             => '1990',
										'dependency'      => array( 'eful_select_post_date_type', '==', 'specific_year' ),
									),
								), // Fields.
							),
						), // Accordions.
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,status,keyword' ),
					),
					array(
						'id'         => 'eful_filter_by_keyword',
						'type'       => 'accordion',
						'class'      => 'padding-t-0 eventful-opened-accordion',
						'accordions' => array(
							array(
								'title'  => esc_html__( 'Keyword', 'eventful' ),
								'icon'   => 'fas fa-key',
								'fields' => array(
									array(
										'id'         => 'eful_set_post_keyword',
										'type'       => 'text',
										'title'      => esc_html__( 'Type Keyword', 'eventful' ),
										'title_help' => esc_html__( 'Enter keyword(s) for searching the posts.', 'eventful' ),
										'options'    => 'post_statuses',
									),
									array(
										'id'         => 'add_search_filter_post',
										'type'       => 'checkbox',
										'title'      => esc_html__( 'Add to Ajax Live Filters', 'eventful' ),
										'title_help' => esc_html__( 'Check to add ajax live filter.', 'eventful' ),
										'dependency' => array( 'eful_layout_preset', '!=', 'filter_layout', true ),
									),
									array(
										'id'         => 'ajax_filter_options',
										'type'       => 'fieldset',
										'title'      => esc_html__( 'Ajax Live Filters', 'eventful' ),
										'dependency' => array( 'add_search_filter_post', '==', 'true', true ),
										'fields'     => array(
											array(
												'id'    => 'ajax_filter_label',
												'type'  => 'text',
												'title' => esc_html__( 'Label', 'eventful' ),
												'title_help' => esc_html__( 'Type live filter label.', 'eventful' ),
											),
											array(
												'id'      => 'eful_live_filter_align',
												'type'    => 'button_set',
												'title'   => esc_html__( 'Alignment', 'eventful' ),
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
						'dependency' => array( 'eful_advanced_filter', 'not-any', 'taxonomy,author,custom_field,sortby,date,status' ),
					),
				),
			)
		); // Filter settings section end.
	}
}
