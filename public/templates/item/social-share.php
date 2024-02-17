<?php
/**
 * Social share
 *
 * This template can be overridden by copying it to yourtheme/eventful/templates/item/social-share.php
 *
 * @package    Eventful
 * @subpackage Eventful/public
 */

?>
<div class="eventful__item__socail-share">
<?php
do_action( 'efp_add_first_socials' );
foreach ( $social_share_media as $style_key => $style_value ) {
	switch ( $style_value ) {
		case 'facebook':
			?>
			<a title="<?php echo esc_attr('Facebook', 'eventful') ?>"  href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink( $post ); ?>" class="efp-social-icon efp-facebook <?php echo esc_attr( $social_icon_shape ); ?>" onClick="window.open('https://www.facebook.com/sharer.php?u=<?php echo get_the_permalink( $post ); ?>','Facebook','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" ><i class="fab fa-facebook-f"></i></a>
			<?php
			break;
		case 'twitter':
			?>
			<a title="<?php echo esc_attr('Twitter', 'eventful') ?>" onClick="window.open('https://twitter.com/share?url=<?php echo get_the_permalink( $post ); ?>&amp;text=<?php echo get_the_title( $post ); ?>','Twitter share','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="https://twitter.com/share?url=<?php echo get_the_permalink( $post ); ?>&amp;text=<?php echo get_the_title( $post ); ?>" class="efp-social-icon efp-twitter <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-twitter"></i></a>
			<?php
			break;
		case 'linkedIn':
			?>
			<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink( $post ); ?>" title="<?php echo esc_attr('linkedIn', 'eventful') ?>" class="efp-social-icon efp-linkedin <?php echo esc_attr( $social_icon_shape ); ?>" onClick="window.open('https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink( $post ); ?>','Linkedin','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo get_the_permalink( $post ); ?>"> <i class="fab fa-linkedin-in"></i></a>
			<?php
			break;
		case 'pinterest':
			?>
			<a href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;https://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());' class="efp-social-icon efp-pinterest <?php echo esc_attr( $social_icon_shape ); ?>" title="<?php echo esc_attr('Pinterest', 'eventful') ?>"> <i class="fab fa-pinterest"></i></a>
			<?php
			break;
		case 'email':
			?>
			<a href="mailto:?Subject=<?php echo get_the_title( $post ); ?>&amp;Body=<?php echo get_the_permalink( $post ); ?>" title="<?php echo esc_attr('Email', 'eventful') ?>" class="efp-social-icon efp-envelope <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="far fa-envelope"></i></a>
			<?php
			break;
		case 'instagram':
			?>
				<a title="<?php echo esc_attr('Instagram', 'eventful') ?>" onClick="window.open('https://instagram.com/?url=<?php echo get_the_permalink( $post ); ?>&amp;text=<?php echo get_the_title( $post ); ?>','Twitter share','width=450,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="https://instagram.com/?url=<?php echo get_the_permalink( $post ); ?>&amp;text=<?php echo get_the_title( $post ); ?>" class="efp-social-icon efp-instagram <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-instagram" aria-hidden="true"></i></a>
				<?php
			break;
		case 'whatsapp':
			?>
			<a href="https://api.whatsapp.com/send?text=<?php echo get_the_title( $post ); ?>%20<?php echo get_the_permalink( $post ); ?>" onClick="window.open('https://api.whatsapp.com/send?text=<?php echo get_the_title( $post ); ?>%20<?php echo get_the_permalink( $post ); ?>','whatsapp','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_attr('WhatsApp', 'eventful') ?>" class="efp-social-icon efp-whatsapp <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-whatsapp"></i></a>
			<?php
			break;
		case 'reddit':
			?>
			<a href="https://reddit.com/submit?url=<?php echo get_the_permalink( $post ); ?>&amp;title=<?php echo get_the_title( $post ); ?>" onClick="window.open('https://reddit.com/submit?url=<?php echo get_the_permalink( $post ); ?>&amp;title=<?php echo get_the_title( $post ); ?>','reddit','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_attr('Reddit', 'eventful') ?>"  class="efp-social-icon efp-reddit <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-reddit"></i></a>
			<?php
			break;
		case 'tumblr':
			?>
			<a href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo get_the_permalink( $post ); ?>&amp;title=<?php echo get_the_title( $post ); ?>" title="<?php echo esc_attr('tumblr', 'eventful') ?>" onClick="window.open('https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo get_the_permalink( $post ); ?>&amp;title=<?php echo get_the_title( $post ); ?>','tumblr','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" class="efp-social-icon efp-tumblr <?php echo esc_attr( $social_icon_shape ); ?>"><i class="fab fa-tumblr"></i></a>
			<?php
			break;
		case 'digg':
			?>
			<a href="https://digg.com/submit?url=<?php echo get_the_permalink( $post ); ?>%&amp;title=<?php echo get_the_title( $post ); ?>" onClick="window.open('https://digg.com/submit?url=<?php echo get_the_permalink( $post ); ?>%&amp;title=<?php echo get_the_title( $post ); ?>','Digg','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" title="<?php echo esc_html('digg', 'eventful') ?>" class="efp-social-icon efp-digg <?php echo esc_attr( $social_icon_shape ); ?>"><i class="fab fa-digg"></i></a>
			<?php
			break;
		case 'vk':
			?>
			<a href="https://vk.com/share.php?url=<?php echo get_the_permalink( $post ); ?>&amp;title=<?php echo get_the_title( $post ); ?>&amp;comment="  title="<?php echo esc_attr('VK', 'eventful') ?>" onClick="window.open('https://vk.com/share.php','VK','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;" class="efp-social-icon efp-vk <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-vk"></i></a>
			<?php
			break;
		case 'xing':
			?>
			<a href="https://www.xing.com/spi/shares/new?url=<?php echo get_the_permalink( $post ); ?>" onClick="window.open('https://www.xing.com/spi/shares/new?url=<?php echo get_the_permalink( $post ); ?>','xing','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;"  title="<?php echo esc_attr('Xing', 'eventful') ?>" class="efp-social-icon efp-xing <?php echo esc_attr( $social_icon_shape ); ?>"><i class="fab fa-xing"></i></a>
			<?php
			break;
		case 'pocket':
			?>
			<a href="https://getpocket.com/edit?url=<?php echo get_the_permalink( $post ); ?>" onClick="window.open('https://getpocket.com/edit?url=<?php echo get_the_permalink( $post ); ?>','ocket','width=450,height=300,left='+(screen.availWidth/2-431)+',top='+(screen.availHeight/2-250)+''); return false;"  title="<?php echo esc_attr('Pocket', 'eventful') ?>" class="efp-social-icon efp-pocket <?php echo esc_attr( $social_icon_shape ); ?>"> <i class="fab fa-get-pocket"></i></a>
			<?php
			break;
	}
}
do_action( 'efp_add_last_socials' );
?>
</div>
<?php
