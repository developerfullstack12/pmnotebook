<?php
/**
 * Widget RS Recent Posts
 *
 * @package rsframework
 * @author Rs Theme
 * @link http://rstheme.com
 */

// Register and load the widget
function wpbs_load_widget() {
    register_widget( 'rsframework_slider_widget' );
}
add_action( 'widgets_init', 'wpbs_load_widget' );
 
// Creating the widget 
class rsframework_slider_widget extends WP_Widget {
 
function __construct() {
parent::__construct(
 
// Base ID of your widget
'wpslider_widget', 
 
// Widget name will appear in UI
__('RS Post Slider Widget', 'rsframework'), 
 
// Widget description
array( 'description' => __( 'Recent post widget with different options', 'rsframework' ), ) 
);
}
 
// Creating widget front-end
 
public function widget( $args, $instance ) {
if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( '','rsframework' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number )
			$number = 5;	
		$show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
        $show_admin = isset( $instance['show_admin'] ) ? $instance['show_admin'] : false;
        $show_overlay = isset( $instance['show_overlay'] ) ? $instance['show_overlay'] : false;
        $show_cate = isset( $instance['show_cate'] ) ? $instance['show_cate'] : false;
        $show_img_size = isset( $instance['show_img_size'] ) ? $instance['show_img_size'] : false;

		$category = !empty($instance['category']) ? $instance['category'] : 0;

		/**
		 * Filters the arguments for the Recent Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */


		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $number,
			'no_found_rows'       => true,
            'category__in'        => $category,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,                               
		) ) );
     
    ?>

    <div class="recent-video-widget main-sidebar widget"> 
		<?php
        if ($r->have_posts()) :
        ?>      
        <?php if ( $title )
        {
          echo wp_kses_post($args['before_title'] . $title . $args['after_title']);
        } ?>                    

                    
        <div class="post-slider-widget clearfix">
            <div id="top-slider" class="owl-carousel">
                <?php                
                while ( $r->have_posts() ) : $r->the_post();?>              
                    <div class="post-item blog-item clearfix overlay<?php echo esc_attr($show_overlay); ?>">
                        <div class="post-img"> 

                        <?php 
                        if ($show_img_size) {
                            the_post_thumbnail('vloglab_gird_widget');
                        } else {
                            the_post_thumbnail();
                        }
                         
                        ?>
                        </div>
                        <div class="post-desc">

                            <?php if ( $show_cate ) : ?>
                                <div class="cat_list">
                                   <?php the_category( ); ?>
                               </div>
                           <?php endif ?>

                            <h3>
                                <a href="<?php the_permalink(); ?>">
                                    <?php get_the_title() ? the_title() : the_ID(); ?>
                                </a>
                            </h3> 
                             
                            <?php if ( $show_date ) : ?>
                                <span class="date-post">
                                    <i class="fa fa-calendar"></i><?php $post_date = get_the_date();echo esc_attr($post_date); ?>
                                </span>  
                            <?php endif ?>

                            <?php if ( $show_admin ) : ?>
                                <span class="post-user">                          
                                    <i class="fa fa-user-o"></i><?php the_author();?>
                                </span>
                            <?php endif ?>
                        </div>
                    </div>                
                <?php            
                    endwhile;  
                ?>
            </div>
        </div>
    </div>
    <?php
        // Reset the global $the_post as this query will have stomped on it
        wp_reset_postdata();
        
        endif;
        ?>
    <?php  
    }

// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];	
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;	
        $instance['show_admin'] = isset( $new_instance['show_admin'] ) ? (bool) $new_instance['show_admin'] : false;   
        $instance['show_overlay'] = isset( $new_instance['show_overlay'] ) ? (bool) $new_instance['show_overlay'] : false;   
        $instance['show_cate'] = isset( $new_instance['show_cate'] ) ? (bool) $new_instance['show_cate'] : false;   
        $instance['show_img_size'] = isset( $new_instance['show_img_size'] ) ? (bool) $new_instance['show_img_size'] : false;   
		$instance['category'] = $new_instance['category'];			
		return $instance;
}
         
// Widget Backend 
public function form( $instance ) {
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;		
        $show_admin = isset( $instance['show_admin'] ) ? (bool) $instance['show_admin'] : false;       
        $show_overlay = isset( $instance['show_overlay'] ) ? (bool) $instance['show_overlay'] : false;       
        $show_cate = isset( $instance['show_cate'] ) ? (bool) $instance['show_cate'] : false;       
        $show_img_size = isset( $instance['show_img_size'] ) ? (bool) $instance['show_img_size'] : false;       
		$category    = isset( $instance['category'] ) ?  $instance['category']  : '';		
?>
<p>
  <label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">
    <?php esc_html_e( 'Title:','rsframework' ); ?>
  </label>
  <input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_js($title); ?>" />
</p>
<p>
  <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>">
    <?php esc_html_e( 'Number of posts to show:','rsframework' ); ?>
  </label>
  <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_js($number); ?>" size="3" />
</p>


	<?php  $taxonomies = get_terms( array(
	    'taxonomy' => 'category',
	    'hide_empty' => false
	) );

	$cat_options[] = '<option value="BLANK">Select one...</option>';
        foreach($taxonomies as $cat) {

            $selected = ($category == $cat->term_id) ? ' selected="selected"' : '';
            $cat_options[] .= '<option value="' . $cat->term_id . '"' . $selected . '>' . $cat->name . '</option>';
    }	 
	?>
	
<p>
    <label for="<?php
        echo $this->get_field_id('category'); ?>">
        <?php  _e('Choose category'); ?>
    </label>
    <select id="<?php
        echo $this->get_field_id('category'); ?>" class="widefat" name="<?php
        echo $this->get_field_name('category'); ?>">
                    <?php
        echo implode('', $cat_options); ?>
    </select>
</p>


<p>
  <input class="checkbox" type="checkbox"<?php checked( $show_img_size ); ?> id="<?php echo esc_attr ($this->get_field_id( 'show_img_size' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_img_size' )); ?>" />
  <label for="<?php echo esc_attr($this->get_field_id( 'show_img_size' )); ?>">
    <?php esc_html_e( 'Display Image Size?','rsframework' ); ?>
  </label>
</p>

<p>
  <input class="checkbox" type="checkbox"<?php checked( $show_cate ); ?> id="<?php echo esc_attr ($this->get_field_id( 'show_cate' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_cate' )); ?>" />
  <label for="<?php echo esc_attr($this->get_field_id( 'show_cate' )); ?>">
    <?php esc_html_e( 'Display post Category?','rsframework' ); ?>
  </label>
</p>

<p>
  <input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo esc_attr ($this->get_field_id( 'show_date' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_date' )); ?>" />
  <label for="<?php echo esc_attr($this->get_field_id( 'show_date' )); ?>">
    <?php esc_html_e( 'Display post date?','rsframework' ); ?>
  </label>
</p>

<p>
  <input class="checkbox" type="checkbox"<?php checked( $show_admin ); ?> id="<?php echo esc_attr ($this->get_field_id( 'show_admin' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_admin' )); ?>" />
  <label for="<?php echo esc_attr($this->get_field_id( 'show_admin' )); ?>">
    <?php esc_html_e( 'Display Post Author?','rsframework' ); ?>
  </label>
</p>

<p>
  <input class="checkbox" type="checkbox"<?php checked( $show_overlay ); ?> id="<?php echo esc_attr ($this->get_field_id( 'show_overlay' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_overlay' )); ?>" />
  <label for="<?php echo esc_attr($this->get_field_id( 'show_overlay' )); ?>">
    <?php esc_html_e( 'Display Image Overlay?','rsframework' ); ?>
  </label>
</p>

<?php
	}
} // Class wpslider_widget ends here
