<?php

// Register and load the widget
function rs_category_widget_load_widget() {
    register_widget( 'RS_Category_List' );
}
add_action( 'widgets_init', 'rs_category_widget_load_widget' );

class RS_Category_List extends WP_Widget {

  /**
   * Sets up a new Categories widget instance.
   *
   * @since 2.8.0
   */
  public function __construct() {
    $widget_ops = array(
      'classname'                   => 'rs_widget_categories',
      'description'                 => __( 'A list or dropdown of categories.' ),
      'customize_selective_refresh' => true,
    );
    parent::__construct( 'rs-categories', __( 'RS Category List' ), $widget_ops );
  }

  /**
   * Outputs the content for the current Categories widget instance.
   *
   * @since 2.8.0
   *
   * @staticvar bool $first_dropdown
   *
   * @param array $args     Display arguments including 'before_title', 'after_title',
   *                        'before_widget', and 'after_widget'.
   * @param array $instance Settings for the current Categories widget instance.
   */
  public function widget( $args, $instance ) {
    static $first_dropdown = true;

    $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Categories' );

    /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
    $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

    $c = ! empty( $instance['count'] ) ? '1' : '0'; 
    $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;  

    echo $args['before_widget'];

    if ( $title ) {
      echo $args['before_title'] . $title . $args['after_title'];
    } 

   echo '<ul class="category-widget-list">';
  
  //$categories = get_categories();
  $categories = get_terms('category', array('parent' => 0, 'number' =>$number));
  foreach ( $categories as $category ) {    
    $count1      = $category->count;
    $post_count  = vloglab_wp_get_postcount($category->term_id);
    $total       = $count1 + $post_count ;
  ?>
    <li class="cat-item cat-item-2"><a href="<?php echo esc_url( get_category_link($category->term_id) ); ?>"><?php echo esc_html($category->name);?></a>
    <?php if($c == 1) : ?><span><?php echo esc_html($total);?></span> <?php endif; ?>
    
    </li>
  <?php
}     
echo '</ul>';

    echo $args['after_widget'];
  }

  /**
   * Handles updating settings for the current Categories widget instance.
   *
   * @since 2.8.0
   *
   * @param array $new_instance New settings for this instance as input by the user via
   *                            WP_Widget::form().
   * @param array $old_instance Old settings for this instance.
   * @return array Updated settings to save.
   */
  public function update( $new_instance, $old_instance ) {
    $instance                 = $old_instance;
    $instance['title']        = sanitize_text_field( $new_instance['title'] );
    $instance['count']        = ! empty( $new_instance['count'] ) ? 1 : 0;  
    $instance['number']       = (int) $new_instance['number'];

    return $instance;
  }

  /**
   * Outputs the settings form for the Categories widget.
   *
   * @since 2.8.0
   *
   * @param array $instance Current settings.
   */
  public function form( $instance ) {
    //Defaults
    $instance     = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $count        = isset( $instance['count'] ) ? (bool) $instance['count'] : false;
    $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
    
    ?>
    <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" /></p>

    <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>"<?php checked( $count ); ?> />
    <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Show post counts' ); ?></label><br />

    <p>
  <label for="<?php echo esc_attr($this->get_field_id( 'number' )); ?>">
    <?php esc_html_e( 'Number of Category:','rsframework' ); ?>
  </label>
  <input class="tiny-text" id="<?php echo esc_attr($this->get_field_id( 'number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'number' )); ?>" type="number" step="1" min="1" value="<?php echo esc_js($number); ?>" size="3" />
</p>
    <?php
  }

}
