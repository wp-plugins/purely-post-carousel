<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*
Plugin Name: post Carousel
Plugin URI: http://purelythemes.com/post-carousel
Description: WooCommerce post Carousel with options 
Version: 1.0
Author: PurelyThemes
Author URI: http://www.purelythemes.com
License: GNU GPLv2
*/

class purely_post_carousel extends WP_Widget {

	// constructor
	function purely_post_carousel() {
		parent::WP_Widget(false, $name = __('post Carousel', 'purely_post_carousel') );
		add_image_size( 'post-carousel-thumb', 350, 220, true );
	}


	// widget form creation
	function form($instance) {

	// Check values
	if( $instance) {
		$title = esc_attr($instance['title']);
		$post_num = esc_attr($instance['post_num']);
		$toggle_featured = esc_attr($instance['toggle_featured']);
		$column_num = esc_attr($instance['column_num']);
		$column_scroll = esc_attr($instance['column_scroll']);
		$list_orderby = esc_attr($instance['list_orderby']);
		$list_types = esc_attr($instance['list_types']);
		$list_order = esc_attr($instance['list_order']);
		$list_description = esc_attr($instance['list_description']);

	} else {
		$title = '';
		$post_num = '';
		$toggle_featured = '';
		$column_num = '';
		$column_scroll = '';
		$list_types = '';
		$list_orderby = '';
		$list_order = '';
		$list_description = '';

	}
	?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'purely_post_carousel'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('post_num'); ?>"><?php _e('Number of posts:', 'purely_post_carousel'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('post_num'); ?>" name="<?php echo $this->get_field_name('post_num'); ?>" type="text" value="<?php echo $post_num; ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('column_num'); ?>"><?php _e('Column count:', 'purely_post_carousel'); ?></label>
			<select name="<?php echo $this->get_field_name('column_num'); ?>" id="<?php echo $this->get_field_id('column_num'); ?>" class="widefat">
				<?php
					$options = array('3', '4', '5', '6');
					foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $column_num == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('column_scroll'); ?>"><?php _e('Items to scroll:', 'purely_post_carousel'); ?></label>
			<select name="<?php echo $this->get_field_name('column_scroll'); ?>" id="<?php echo $this->get_field_id('column_scroll'); ?>" class="widefat">
				<?php
					$options = array('1', '2', '3', '4', '5', '6');
					foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $column_scroll == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('list_types'); ?>"><?php _e('post Types:', 'purely_post_carousel'); ?></label>
			<select name="<?php echo $this->get_field_name('list_types'); ?>" id="<?php echo $this->get_field_id('list_types'); ?>" class="widefat">
				<?php
					$options = array('all', 'featured', 'onsale');
					foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $list_types == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
				?>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('list_orderby'); ?>"><?php _e('List Order By', 'purely_post_carousel'); ?></label>
			<select name="<?php echo $this->get_field_name('list_orderby'); ?>" id="<?php echo $this->get_field_id('list_orderby'); ?>" class="widefat">
				<?php
					$options = array('date','price', 'random', 'sales');
					foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $list_orderby == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
				?>
			</select>
		</p>
	
		<p>
			<label for="<?php echo $this->get_field_id('list_order'); ?>"><?php _e('List Order', 'purely_post_carousel'); ?></label>
			<select name="<?php echo $this->get_field_name('list_order'); ?>" id="<?php echo $this->get_field_id('list_order'); ?>" class="widefat">
				<?php
					$options = array('asc','desc');
					foreach ($options as $option) {
					echo '<option value="' . $option . '" id="' . $option . '"', $list_order == $option ? ' selected="selected"' : '', '>', $option, '</option>';
					}
				?>
			</select>
		</p>
		
		<p>
			<input id="<?php echo $this->get_field_id('list_description'); ?>" name="<?php echo $this->get_field_name('list_description'); ?>" type="checkbox" value="1" <?php checked( '1', $list_description ); ?> />
			<label for="<?php echo $this->get_field_id('list_description'); ?>"><?php _e('Show Description?', 'purely_post_carousel'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('toggle_featured'); ?>" name="<?php echo $this->get_field_name('toggle_featured'); ?>" type="checkbox" value="1" <?php checked( '1', $toggle_featured ); ?> />
			<label for="<?php echo $this->get_field_id('toggle_featured'); ?>"><?php _e('Hide posts without thumbnails?', 'purely_post_carousel'); ?></label>
		</p>
		
		
	<?php
	}

	// update widget
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
    // Fields
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_num'] = strip_tags($new_instance['post_num']);
		$instance['toggle_featured'] = strip_tags($new_instance['toggle_featured']);
		$instance['column_num'] = strip_tags($new_instance['column_num']);
		$instance['column_scroll'] = strip_tags($new_instance['column_scroll']);
		$instance['list_types'] = strip_tags($new_instance['list_types']);
		$instance['list_orderby'] = strip_tags($new_instance['list_orderby']);
		$instance['list_order'] = strip_tags($new_instance['list_order']);
		$instance['list_description'] = strip_tags($new_instance['list_description']);
	return $instance;
	}


	// display widget
	function widget($args, $instance) {
	
		extract( $args );
	// these are the widget options
		if (!empty($instance['title'])) { $title = apply_filters('widget_title', $instance['title']); }
		if (!empty($instance['post_num'])) { $post_num = $instance['post_num']; }
		if (!empty($instance['list_types'])) { $list_types = $instance['list_types']; }
		if (!empty($instance['toggle_featured'])) {	$toggle_featured = $instance['toggle_featured']; }
		if (!empty($instance['column_num'])) { $column_num = $instance['column_num']; }
		if (!empty($instance['column_scroll'])) { $column_scroll = $instance['column_scroll']; }
		if (!empty($instance['list_orderby'])) { $list_orderby = $instance['list_orderby']; }
		if (!empty($instance['list_order'])) { $list_order = $instance['list_order']; }
		if (!empty($instance['list_description'])) { $list_description = $instance['list_description']; }
		
		echo $before_widget;
	// Display the widget
		echo '<div class="widget-text purely_post_carousel_box post-carousel-'.$column_num.'-columns">';
	// Check if title is set
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
	// Check if textarea is set
		?>
		
	<!-- Dynamic Argument Setup -->	
		
		<?php 
		$args = array(
						'post_type' => 'post',
						'post_status'    => 'publish',
						'posts_per_page' => $post_num,
						'order' => $list_order,
						'meta_query'     => array()
					);
		
		if ( ! empty( $instance['toggle_featured'] ) ) {
			$args['meta_query'][] = array(
				'key'     => '_thumbnail_id',
			);
		}
		
		switch ( $list_types ) {
		
			case 'featured' :
				$args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
				break;
			case 'sticky' :
				$post_ids_on_sale    = wc_get_post_ids_on_sale();
				$post_ids_on_sale[]  = 0;
				$args['post__in'] = $post_ids_on_sale;
				break;
		}
		

		
		switch ( $list_orderby ) {
			case 'random' :
				$args['orderby']  = 'rand';
				break;
			case 'sales' :
				$args['meta_key'] = 'total_sales';
				$args['orderby']  = 'meta_value_num';
				break;
			case 'date' :
				$args['orderby']  = 'date';
				break;
		}

		?>
		
	<!-- Query with the dynamic arguments -->	
		<div class="purely-carousel-wrapper" data-slick='{"slidesToShow": <?php echo $column_num; ?>, "slidesToScroll": <?php echo $column_scroll; ?>}'>
			<?php
			
				$loop = new WP_Query( $args );
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) : $loop->the_post();
						global $post;
			?>
		<div class="purely-post-carousel-item">
			<div class="purely-post-carousel-item-wrap">
			<div class="purely-post-header">
				<?php the_title( sprintf( '<h2 class="purely-post-title"><span><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></span></h2>' ); ?>
			</div>

			<?php if ( has_post_thumbnail() ) { ?>
				<div class="post-thumb">
					<a href="<?php the_permalink(); ?>" rel="bookmark">
						<?php the_post_thumbnail('post-carousel-thumb'); ?>
					</a>	
				</div>
			<?php } ?>
			<div class="purely-post-content">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->
			</div>
		</div>	
			<?php
				endwhile;
					} else {
					echo __( 'No posts found' );
					}
					wp_reset_postdata();
			?>
			<?php
				echo '</div>';
				echo $after_widget;
	}

}


// register widget
add_action('widgets_init', create_function('', 'return register_widget("purely_post_carousel");'));
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );
function post_carousel_css() {
		wp_register_style('post_carousel_css', plugins_url('purely-post-carousel.css', __FILE__));
		wp_enqueue_style('post_carousel_css');
		wp_register_script('product_carousel_slick', plugins_url('slick.js', __FILE__), array('jquery'));
		wp_enqueue_script('product_carousel_slick');
		wp_register_script('post_carousel_script', plugins_url('purely-post-carousel.js', __FILE__), array('jquery'));
		wp_enqueue_script('post_carousel_script');

	}
add_action( 'wp_enqueue_scripts', 'post_carousel_css' );  	
	