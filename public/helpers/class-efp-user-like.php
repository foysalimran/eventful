<?php

/**
 * Post like helper method file.
 *
 * @package Eventful
 * @subpackage Eventful/public/helper
 *
 * @since 2.0.0
 */

/**
 * User post like helper method.
 *
 * @since 2.0.0
 */
class EFP_User_Like
{
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    2.0
	 */
	public function __construct()
	{
		add_action('wp_ajax_process_efp_like', array($this, 'process_efp_like'));
		add_action('wp_ajax_nopriv_process_efp_like', array($this, 'process_efp_like'));
		add_action('wp_enqueue_scripts', array($this, 'likes_enqueue_scripts'));
	}

	/**
	 * Enqueue Script for like button.
	 *
	 * @return void
	 * 
	 */
	public function likes_enqueue_scripts()
	{
		wp_register_script('efp-likes-public-js', EFP_URL . 'public/assets/js/efp-likes-public.js', array('jquery'), '2.0.0', true);
		wp_localize_script(
			'efp-likes-public-js',
			'simpleLikes',
			array(
				'ajaxurl' => admin_url('admin-ajax.php'),
				'like'    => esc_html__('Like', 'eventful'),
				'unlike'  => esc_html__('Unlike', 'eventful'),
			)
		);
		wp_enqueue_script('efp-likes-public-js');
	}
	/**
	 * Process post likes.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function process_efp_like()
	{

		// Security.
		if (isset($_REQUEST['nonce']) && !wp_verify_nonce(sanitize_text_field(wp_unslash($_REQUEST['nonce'])), 'efp-likes-nonce')) {
			exit(esc_html__('Not permitted', 'eventful'));
		}
		// Test if javascript is disabled.
		$disabled = (isset($_REQUEST['disabled']) && sanitize_text_field(wp_unslash($_REQUEST['disabled']))) ? true : false;
		// Test if this is a comment.
		$is_comment = (isset($_REQUEST['is_comment']) && 1 === $_REQUEST['is_comment']) ? 1 : 0;
		// Base variables.
		$post_id    = (isset($_REQUEST['post_id']) && is_numeric(sanitize_text_field(wp_unslash($_REQUEST['post_id'])))) ? sanitize_text_field(wp_unslash($_REQUEST['post_id'])) : '';
		$result     = array();
		$post_users = null;
		$like_count = 0;
		// Get plugin options.
		if ('' !== $post_id) {
			$count = (1 === $is_comment) ? get_comment_meta($post_id, '_comment_like_count', true) : get_post_meta($post_id, '_post_like_count', true); // like count.
			$count = (isset($count) && is_numeric($count)) ? $count : 0;
			if (!self::already_liked($post_id, $is_comment)) { // Like the post.
				if (is_user_logged_in()) { // user is logged in.
					$user_id    = get_current_user_id();
					$post_users = self::post_user_likes($user_id, $post_id, $is_comment);
					if (1 === $is_comment) {
						// Update User & Comment.
						$user_like_count = get_user_option('_comment_like_count', $user_id);
						$user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
						update_user_option($user_id, '_comment_like_count', ++$user_like_count);
						if ($post_users) {
							update_comment_meta($post_id, '_user_comment_liked', $post_users);
						}
					} else {
						// Update User & Post.
						$user_like_count = get_user_option('_user_like_count', $user_id);
						$user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
						update_user_option($user_id, '_user_like_count', ++$user_like_count);
						if ($post_users) {
							update_post_meta($post_id, '_user_liked', $post_users);
						}
					}
				} else { // user is anonymous.
					$user_ip    = self::efpl_get_ip();
					$post_users = self::post_ip_likes($user_ip, $post_id, $is_comment);
					// Update Post.
					if ($post_users) {
						if (1 === $is_comment) {
							update_comment_meta($post_id, '_user_comment_IP', $post_users);
						} else {
							update_post_meta($post_id, '_user_IP', $post_users);
						}
					}
				}
				$like_count         = ++$count;
				$response['status'] = 'liked';
				$response['icon']   = self::get_liked_icon();
			} else { // Unlike the post.
				if (is_user_logged_in()) { // user is logged in.
					$user_id    = get_current_user_id();
					$post_users = self::post_user_likes($user_id, $post_id, $is_comment);
					// Update User.
					if (1 === $is_comment) {
						$user_like_count = get_user_option('_comment_like_count', $user_id);
						$user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
						if ($user_like_count > 0) {
							update_user_option($user_id, '_comment_like_count', --$user_like_count);
						}
					} else {
						$user_like_count = get_user_option('_user_like_count', $user_id);
						$user_like_count = (isset($user_like_count) && is_numeric($user_like_count)) ? $user_like_count : 0;
						if ($user_like_count > 0) {
							update_user_option($user_id, '_user_like_count', --$user_like_count);
						}
					}
					// Update Post.
					if ($post_users) {
						$uid_key = array_search($user_id, $post_users, true);
						unset($post_users[$uid_key]);
						if (1 === $is_comment) {
							update_comment_meta($post_id, '_user_comment_liked', $post_users);
						} else {
							update_post_meta($post_id, '_user_liked', $post_users);
						}
					}
				} else { // user is anonymous.
					$user_ip    = self::efpl_get_ip();
					$post_users = self::post_ip_likes($user_ip, $post_id, $is_comment);
					// Update Post.
					if ($post_users) {
						$uip_key = array_search($user_ip, $post_users, true);
						unset($post_users[$uip_key]);
						if (1 === $is_comment) {
							update_comment_meta($post_id, '_user_comment_IP', $post_users);
						} else {
							update_post_meta($post_id, '_user_IP', $post_users);
						}
					}
				}
				$like_count         = ($count > 0) ? --$count : 0; // Prevent negative number.
				$response['status'] = 'unliked';
				$response['icon']   = self::get_unliked_icon();
			}
			if (1 === $is_comment) {
				update_comment_meta($post_id, '_comment_like_count', $like_count);
				update_comment_meta($post_id, '_comment_like_modified', date('Y-m-d H:i:s'));
			} else {
				update_post_meta($post_id, '_post_like_count', $like_count);
				update_post_meta($post_id, '_post_like_modified', date('Y-m-d H:i:s'));
			}
			$response['count']   = self::get_like_count($like_count);
			$response['testing'] = $is_comment;
			if ($disabled) {
				if (1 === $is_comment) {
					wp_safe_redirect(get_permalink(get_the_ID()));
					exit();
				} else {
					wp_safe_redirect(get_permalink($post_id));
					exit();
				}
			} else {
				wp_send_json($response);
			}
		}
		wp_die();
	}

	/**
	 * Utility to test if the post is already liked
	 *
	 * @param integer $post_id The post ID.
	 * @param boolean $is_comment The post comment(like).
	 * @since    2.0.0
	 */
	public static function already_liked($post_id, $is_comment)
	{
		$post_users = null;
		$user_id    = null;
		if (is_user_logged_in()) { // user is logged in.
			$user_id         = get_current_user_id();
			$post_meta_users = (1 === $is_comment) ? get_comment_meta($post_id, '_user_comment_liked') : get_post_meta($post_id, '_user_liked');
			if (0 !== count($post_meta_users)) {
				$post_users = $post_meta_users[0];
			}
		} else { // user is anonymous.
			$user_id         = self::efpl_get_ip();
			$post_meta_users = (1 === $is_comment) ? get_comment_meta($post_id, '_user_comment_IP') : get_post_meta($post_id, '_user_IP');
			if (0 !== count($post_meta_users)) { // meta exists, set up values.
				$post_users = $post_meta_users[0];
			}
		}
		if (is_array($post_users) && in_array($user_id, $post_users, true)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Output the like button
	 *
	 * @param  mixed $post_id post id.
	 * @param  mixed $is_comment comment.
	 * @return statement
	 */
	public static function get_efp_likes_button($post_id, $is_comment = null)
	{
		$is_comment = (null === $is_comment) ? 0 : 1;
		$output     = '';
		$nonce      = wp_create_nonce('efp-likes-nonce'); // Security.
		if (1 === $is_comment) {
			$post_id_class = esc_attr(' efpl-comment-button-' . $post_id);
			$comment_class = esc_attr(' efpl-comment');
			$like_count    = get_comment_meta($post_id, '_comment_like_count', true);
			$like_count    = (isset($like_count) && is_numeric($like_count)) ? $like_count : 0;
		} else {
			$post_id_class = esc_attr(' efpl-button-' . $post_id);
			$comment_class = esc_attr('');
			$like_count    = get_post_meta($post_id, '_post_like_count', true);
			$like_count    = (isset($like_count) && is_numeric($like_count)) ? $like_count : 0;
		}
		$count      = self::get_like_count($like_count);
		$icon_empty = self::get_unliked_icon();
		$icon_full  = self::get_liked_icon();
		// Loader.
		$loader = '<span id="efpl-loader"></span>';
		// Liked/Unliked Variables.
		if (self::already_liked($post_id, $is_comment)) {
			$class = esc_attr(' liked');
			$title = esc_html__('Unlike', 'eventful');
			$icon  = $icon_full;
		} else {
			$class = '';
			$title = esc_html__('Like', 'eventful');
			$icon  = $icon_empty;
		}
		$output = '<span class="efpl-wrapper"><a href="#" class="efpl-button' . $post_id_class . $class . $comment_class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" data-iscomment="' . $is_comment . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</span>';

		return $output;
	}
	/**
	 * Processes shortcode to manually add the button to posts
	 *
	 * @since 1.0.0
	 */
	public static function efpl_shortcode()
	{
		return self::get_efp_likes_button(get_the_ID(), 0);
	}

	/**
	 * Utility retrieves post meta user likes (user id array),
	 * then adds new user id to retrieved array
	 *
	 * @param array   $user_id The IDs of users.
	 * @param integer $post_id The post ID.
	 * @param boolean $is_comment User comment.
	 * @return array
	 */
	public static function post_user_likes($user_id, $post_id, $is_comment)
	{
		$post_users      = '';
		$post_meta_users = (1 === $is_comment) ? get_comment_meta($post_id, '_user_comment_liked') : get_post_meta($post_id, '_user_liked');
		if (0 !== count($post_meta_users)) {
			$post_users = $post_meta_users[0];
		}
		if (!is_array($post_users)) {
			$post_users = array();
		}
		if (!in_array($user_id, $post_users, true)) {
			$post_users['user-' . $user_id] = $user_id;
		}
		return $post_users;
	}

	/**
	 * Utility retrieves post meta ip likes (ip array),
	 * then adds new ip to retrieved array
	 *
	 * @param integer $user_ip User IP address.
	 * @param integer $post_id The post ID.
	 * @param boolean $is_comment User comment.
	 * @return array
	 */
	public static function post_ip_likes($user_ip, $post_id, $is_comment)
	{
		$post_users      = '';
		$post_meta_users = (1 === $is_comment) ? get_comment_meta($post_id, '_user_comment_IP') : get_post_meta($post_id, '_user_IP');
		// Retrieve post information.
		if (0 !== count($post_meta_users)) {
			$post_users = $post_meta_users[0];
		}
		if (!is_array($post_users)) {
			$post_users = array();
		}
		if (!in_array($user_ip, $post_users, true)) {
			$post_users['ip-' . $user_ip] = $user_ip;
		}
		return $post_users;
	}

	/**
	 * Utility to retrieve IP address
	 *
	 * @since    2.0.0
	 */
	public static function efpl_get_ip()
	{
		if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_CLIENT_IP']));
		} elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = sanitize_text_field(wp_unslash($_SERVER['HTTP_X_FORWARDED_FOR']));
		} else {
			$ip = (isset($_SERVER['REMOTE_ADDR'])) ? sanitize_text_field(wp_unslash($_SERVER['REMOTE_ADDR'])) : '0.0.0.0';
		}
		$ip = filter_var($ip, FILTER_VALIDATE_IP);
		$ip = (!$ip) ? '0.0.0.0' : $ip;
		return $ip;
	}

	/**
	 * Utility returns the button icon for "like" action
	 *
	 * @since    2.0.0
	 */
	public static function get_liked_icon()
	{
		$icon = '<i class="fas fa-heart"></i>';
		return $icon;
	}

	/**
	 * Utility returns the button icon for "unlike" action
	 *
	 * @since    2.0.0
	 */
	public static function get_unliked_icon()
	{
		$icon = '<i class="fas fa-heart"></i>';
		return $icon;
	}

	/**
	 * Utility function to format the button count,
	 * appending "K" if one thousand or greater,
	 * "M" if one million or greater,
	 * and "B" if one billion or greater (unlikely).
	 * $precision = how many decimal points to display (1.25K)
	 *
	 * @param mixed $number number.
	 *
	 * @since    2.0.0
	 */
	public static function efpl_format_count($number)
	{
		$precision = 2;
		if ($number >= 1000 && $number < 1000000) {
			$formatted = number_format($number / 1000, $precision) . 'K';
		} elseif ($number >= 1000000 && $number < 1000000000) {
			$formatted = number_format($number / 1000000, $precision) . 'M';
		} elseif ($number >= 1000000000) {
			$formatted = number_format($number / 1000000000, $precision) . 'B';
		} else {
			$formatted = $number; // Number is less than 1000.
		}
		$formatted = str_replace('.00', '', $formatted);
		return $formatted;
	}

	/**
	 * Utility retrieves count plus count options,
	 * returns appropriate format based on options.
	 *
	 * @param string $like_count The like counter.
	 * @since    2.0.0
	 */
	public static function get_like_count($like_count)
	{
		$like_text = esc_html__('Like', 'eventful');
		if (is_numeric($like_count) && $like_count > 0) {
			$number = self::efpl_format_count($like_count);
		} else {
			$number = $like_text;
		}
		$count = '<span class="efpl-count">' . $number . '</span>';
		return $count;
	}

	/**
	 *  User Profile List
	 *
	 * @param object $user User.
	 * @return void
	 */
	public static function show_user_likes($user)
	{ ?>
		<table class="form-table">
			<tr>
				<th><label for="user_likes"><?php esc_html__('You Like:', 'eventful'); ?></label></th>
				<td>
					<?php
					$types      = get_post_types(array('public' => true));
					$args       = array(
						'numberposts' => -1,
						'post_type'   => $types,
						'meta_query'  => array(
							array(
								'key'     => '_user_liked',
								'value'   => $user->ID,
								'compare' => 'LIKE',
							),
						),
					);
					$sep        = '';
					$like_query = new WP_Query($args);
					if ($like_query->have_posts()) :
					?>
						<p>
							<?php
							while ($like_query->have_posts()) :
								$like_query->the_post();
								echo wp_kses_post($sep);
							?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							<?php
								$sep = ' &middot; ';
							endwhile;
							?>
						</p>
					<?php else : ?>
						<p><?php esc_html_e('You do not like anything yet.', 'eventful'); ?></p>
					<?php
					endif;
					wp_reset_postdata();
					?>
				</td>
			</tr>
		</table>
<?php
	}
}
