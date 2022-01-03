<?php
/**
 * Elementor rsgallery Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */

use Elementor\Group_Control_Css_Filter;
use Elementor\Repeater;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Rsaddon_Elementor_Pro_Notice_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve rsgallery widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'rs-notice';
	}		

	/**
	 * Get widget title.
	 *
	 * Retrieve rsgallery widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'RS Latest Notice', 'educavo' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve rsgallery widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'glyph-icon flaticon-network';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the rsgallery widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
        return [ 'rsaddon_category' ];
    }

	/**
	 * Register rsgallery widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		

		

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'educavo' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'notice_heading',
			[
				'label'     => esc_html__( 'Heading Text', 'educavo' ),
				'type'      => Controls_Manager::TEXT,				
				'separator' => 'before',				
			]
		);	

	    $this->add_control(
            'notice_word_show',
            [
                'label' => esc_html__( 'Show Content Limit', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '10', 'rsaddon' ),
                'separator' => 'before',
            ]
        );
		$this->add_control(
			'cat',
			[
				'label'   => esc_html__( 'Category', 'educavo' ),
				'type'    => Controls_Manager::SELECT2,					
				'options'   => $this->getCategories(), 
				'multiple' => true,	
				'separator' => 'before',					
			]

		);		

		$this->add_control(
			'notice_per',
			[
				'label' => esc_html__( 'Notice Per Page', 'educavo' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'educavo' ),
				'separator' => 'before',				
			]
		);
	

        $this->end_controls_section();  

        $this->start_controls_section(
			'section_notice_style',
			[
				'label' => esc_html__( 'Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Top Title Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-notice .rs_top_title' => 'color: {{VALUE}};',                    

                ],                
            ]
        );

        $this->add_control(
            'title_bg_color',
            [
                'label' => esc_html__( 'Top Title Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-notice .rs_top_title' => 'background: {{VALUE}};',                   

                ],                
            ]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'top_title_typography',
				'label' => esc_html__( 'Top Title Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selectors' => [
                    '{{WRAPPER}} .rs-notice .rs_top_title',                             

                ],                  
			]
		);

        $this->add_control(
            'date_color',
            [
                'label' => esc_html__( 'Date Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-notice ul li .date, {{WRAPPER}} .rs-notice ul li .date span' => 'color: {{VALUE}};', 
                ],              
            ]
            
        );

        $this->add_control(
            'title_link_color',
            [
                'label' => esc_html__( 'Title Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                   
                    '{{WRAPPER}} .rs-notice .notices-title' => 'color: {{VALUE}};', 
                ],                
            ]
        );

        $this->add_control(
            'link_hover_color',
            [
                'label' => esc_html__( 'Title Hover Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                 
                    '{{WRAPPER}} .rs-notice .notices-title:hover' => 'color: {{VALUE}};',                   

                ],                
            ]
        );


        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'link_typography',
				'label' => esc_html__( 'Title Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selectors' => [                            
                    '{{WRAPPER}} .rs-notice .notices-title',                             

                ],                  
			]
		);


        $this->add_control(
            'border_color',
            [
                'label' => esc_html__( 'Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-notice ul li .date' => 'border-color: {{VALUE}};',                   
                ],                
            ]
            
        );  

        $this->add_control(
            'area_bg_color',
            [
                'label' => esc_html__( 'background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-notice ul li' => 'background: {{VALUE}};',                  
                ],                
            ]
            
        );  

        $this->add_responsive_control(
		    'padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-notice ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		


        $this->end_controls_section();     

	}

	/**
	 * Render rsgallery widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display(); 	
		$enorll_now =  !empty($settings['applynow']) ? $settings['applynow'] : 'Enroll Now';

	        $cat = $settings['cat'];
	       	 if(empty($cat)){  
	        	$best_wp = new wp_Query(array(
						'post_type'           => 'Notices',
						'posts_per_page'      => $settings['notice_per'],
						'ignore_sticky_posts' => 1,
				));	  
	        }   
	        else{
	        	$best_wp = new wp_Query(array(
					'post_type'           => 'notices',
					'posts_per_page'      => $settings['notice_per'],
					'ignore_sticky_posts' => 1,
					'tax_query' => array(
				        array(
							'taxonomy' => 'notice-category',
							'field'    => 'slug', //can be set to ID
							'terms'    =>  $cat//if field is ID you can reference by cat/term number
				        ),
				    )
				));	  
	        }

	        ?>
 
			<div id="rs-notice" class="rs-notice">	
				<?php if(!empty($settings['notice_heading'])){?>
				<h3 class="rs_top_title"><?php echo esc_html($settings['notice_heading']);?></h3>
				<?php } ?>

				<ul class="notice-list">
					<?php 	
					while($best_wp->have_posts()): $best_wp->the_post();

						if(!empty($settings['notice_word_show'])){
                            $limit = $settings['notice_word_show'];
                        }
                        else{
                            $limit = 10;
                        }
                    	
					?>	

					<li>
                        <div class="date"><span><?php echo get_the_date('d'); ?> </span><?php echo get_the_date('M'); ?></div>
                        <a class="notices-title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
					
					<?php 	endwhile; 
					wp_reset_query();?>	
				</ul>
			</div>
		<?php 	

	}
	public function getCategories(){
	         $cat_list = [];
	         if ( post_type_exists( 'notices' ) ) { 
	          $terms = get_terms( array(
	             'taxonomy'    => 'notice-category',
	             'hide_empty'  => true            
	         ) );          
	         
	        
	         foreach($terms as $post) {

	          $cat_list[$post->slug]  = [$post->name];

	         }
	      }  
	        return $cat_list;
	    } 
}?>