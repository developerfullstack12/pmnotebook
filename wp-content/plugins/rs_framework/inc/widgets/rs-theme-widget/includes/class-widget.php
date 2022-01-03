<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Widget class
 *
 * @package Black_Studio_TinyMCE_Widget
 * @since 0.5
 */

if ( ! class_exists( 'WP_Widget_Black_Studio_TinyMCE' ) ) {

	class WP_Widget_Black_Studio_TinyMCE extends WP_Widget {

		/**
		 * Widget Class constructor
		 *
		 * @uses WP_Widget::__construct()
		 * @since 0.5
		 */
		public function __construct() {
			/* translators: title of the widget */
			$widget_title = __( 'About Me', 'black-studio-tinymce-widget' );
			/* translators: description of the widget, shown in available widgets */
			$widget_description = __( 'Arbitrary text or HTML with visual editor', 'black-studio-tinymce-widget' );
			$widget_ops = array( 'classname' => 'widget_rs_about', 'description' => $widget_description );
			$control_ops = array( 'width' => 400, 'height' => 350 );
			parent::__construct( 'black-studio-tinymce', $widget_title, $widget_ops, $control_ops );
		}

		/**
		 * Output widget HTML code
		 *
		 * @uses apply_filters()
		 * @uses WP_Widget::$id_base
		 *
		 * @param string[] $args
		 * @param mixed[] $instance
		 * @return void
		 * @since 0.5
		 */
		public function widget( $args, $instance ) {
			$before_widget = $args['before_widget'];
			$after_widget = $args['after_widget'];
			$before_title = $args['before_title'];
			$after_title = $args['after_title'];
			do_action( 'black_studio_tinymce_before_widget', $args, $instance );
			$before_text = apply_filters( 'black_studio_tinymce_before_text', '<div class="textwidget">', $instance );
			$after_text = apply_filters( 'black_studio_tinymce_after_text', '</div>', $instance );
			$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$facebook = apply_filters( empty( $instance['facebook'] ) ? '' : $instance['facebook'], $instance);
			$pinterest = apply_filters( empty( $instance['pinterest'] ) ? '' : $instance['pinterest'], $instance);
			$linkedin = apply_filters( empty( $instance['linkedin'] ) ? '' : $instance['linkedin'], $instance);
			$instagram = apply_filters( empty( $instance['instagram'] ) ? '' : $instance['instagram'], $instance);
			$youtube = apply_filters( empty( $instance['youtube'] ) ? '' : $instance['youtube'], $instance);
			$twitter = apply_filters( empty( $instance['twitter'] ) ? '' : $instance['twitter'], $instance);

			$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance, $this );
			$hide_empty = apply_filters( 'black_studio_tinymce_hide_empty', false, $instance );
			?>
			<div class="abouts-me">
			<?php
			if ( ! ( $hide_empty && empty( $text ) ) ) {
				$output = $before_widget;
				if ( ! empty( $title ) ) {
					$output .= $before_title . $title . $after_title;
				}
				$output .= $before_text . $text . $after_text;
				$output .= $after_widget;
				echo $output; // xss ok
			}

			do_action( 'black_studio_tinymce_after_widget', $args, $instance );

			?>
				<ul class="social-icon">
				    <?php if(!empty($instance['facebook'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['facebook'])?>" target="_blank"><span><i class="fa fa-facebook"></i></span></a> 
				        </li>
				    <?php } ?>

				    <?php if(!empty($instance['twitter'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['twitter'])?>" target="_blank"><span><i class="fa fa-twitter"></i></span></a> 
				        </li>
				    <?php } ?>

				    <?php if(!empty($instance['pinterest'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['pinterest'])?>" target="_blank"><span><i class="fa fa-pinterest"></i></span></a> 
				        </li>
				    <?php } ?>

				    <?php if(!empty($instance['linkedin'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['linkedin'])?>" target="_blank"><span><i class="fa fa-linkedin"></i></span></a> 
				        </li>
				    <?php } ?>

				    <?php if(!empty($instance['instagram'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['instagram'])?>" target="_blank"><span><i class="fa fa-instagram"></i></span></a> 
				        </li>
				    <?php } ?>

				    <?php if(!empty($instance['youtube'])) { ?>
				        <li> 
				        	<a href="<?php echo esc_url($instance['youtube'])?>" target="_blank"><span><i class="fa fa-youtube"></i></span></a> 
				        </li>
				    <?php } ?>
				</ul>
			</div>
			<?php
		}

		

		/**
		 * Update widget data
		 *
		 * @uses current_user_can()
		 * @uses wp_filter_post_kses()
		 * @uses apply_filters()
		 *
		 * @param mixed[] $new_instance
		 * @param mixed[] $old_instance
		 * @return mixed[]
		 * @since 0.5
		 */
		public function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['facebook'] = strip_tags( $new_instance['facebook'] );
			$instance['pinterest'] = strip_tags( $new_instance['pinterest'] );
			$instance['linkedin'] = strip_tags( $new_instance['linkedin'] );
			$instance['instagram'] = strip_tags( $new_instance['instagram'] );
			$instance['youtube'] = strip_tags( $new_instance['youtube'] );
			$instance['twitter'] = strip_tags( $new_instance['twitter'] );
			if ( current_user_can( 'unfiltered_html' ) ) {
				$instance['text'] = $new_instance['text'];
			}
			else {
				$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) ); // wp_filter_post_kses() expects slashed
			}
			$instance['type'] = strip_tags( $new_instance['type'] );
			$instance['filter'] = strip_tags( $new_instance['filter'] );
			$additional_fields = apply_filters( 'black_studio_tinymce_widget_additional_fields', array() );
			if ( ! empty( $additional_fields ) ) {
				foreach ( $additional_fields as $additional_field ) {
					$instance[ $additional_field ] = $new_instance[ $additional_field ];
				}
			}
			$instance = apply_filters( 'black_studio_tinymce_widget_update', $instance, $this );
			return $instance;
		}

		/**
		 * Output widget form
		 *
		 * @uses wp_parse_args()
		 * @uses apply_filters()
		 * @uses esc_attr()
		 * @uses esc_textarea()
		 * @uses WP_Widget::get_field_id()
		 * @uses WP_Widget::get_field_name()
		 * @uses _e()
		 * @uses do_action()
		 * @uses apply_filters()
		 *
		 * @param mixed[] $instance
		 * @return void
		 * @since 0.5
		 */
		public function form( $instance ) {
			global $wp_customize;
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'text' => '', 'facebook' => '',  'pinterest' => '',  'linkedin' => '',  'instagram' => '',  'youtube' => '',  'twitter' => '', 'type' => 'visual' ) );
			// Force Visual mode in Customizer (to avoid glitches)
			if ( $wp_customize ) {
				$instance['type'] = 'visual';
			}
			// Guess (wpautop) filter value for widgets created with previous version
			if ( ! isset( $instance['filter'] ) ) {
				$instance['filter'] = $instance['type'] == 'visual' && substr( $instance['text'], 0, 3 ) != '<p>' ? 1 : 0;
			}
			$title = strip_tags( $instance['title'] );
			$facebook = strip_tags( $instance['facebook'] );
			$pinterest = strip_tags( $instance['pinterest'] );
			$linkedin = strip_tags( $instance['linkedin'] );
			$instagram = strip_tags( $instance['instagram'] );
			$youtube = strip_tags( $instance['youtube'] );
			$twitter = strip_tags( $instance['twitter'] );
			do_action( 'black_studio_tinymce_before_editor', $instance, $this );
			?>
			<input id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" type="hidden" value="<?php echo esc_attr( $instance['type'] ); ?>" />
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
			<?php
			do_action( 'black_studio_tinymce_editor', $instance['text'], $this->get_field_id( 'text' ), $this->get_field_name( 'text' ), $instance['type'] );
			do_action( 'black_studio_tinymce_after_editor', $instance, $this );
			?>
			<input id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>-hidden" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" type="hidden" value="0" />
			<p><input id="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'filter' ) ); ?>" type="checkbox" value="1" <?php checked( $instance['filter'] ); ?> />&nbsp;<label for="<?php echo esc_attr( $this->get_field_id( 'filter' ) ); ?>"><?php _e( 'Automatically add paragraphs' ); ?></label></p>


			<p><label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php _e( 'Facebook:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'twitter ' ) ); ?>"><?php _e( 'Twitter:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"><?php _e( 'Pinterest:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"><?php _e( 'Linkedin:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php _e( 'Instagram:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" /></p>

			<p><label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php _e( 'Youtube:' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" /></p>

            <?php
		}

	} // END class WP_Widget_Black_Studio_TinyMCE

} // END class_exists check
