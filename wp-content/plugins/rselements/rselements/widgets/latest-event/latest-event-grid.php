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

class Rsaddon_Elementor_Pro_Event_Grid_Widget extends \Elementor\Widget_Base {

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
		return 'rs-event-grid';
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
		return __( 'RS Latest Event', 'afaddon' );
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
				'label' => esc_html__( 'Content Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'event_grid_style',
			[
				'label'   => esc_html__( 'Select Style', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Style 1',
					'2' => 'Style 2',			
				],											
			]
		);	

		$this->add_control(
			'cat',
			[
				'label'   => esc_html__( 'Category', 'afaddon' ),
				'type'    => Controls_Manager::SELECT2,	
				'default' => 0,			
				'options'   => $this->getCategories(),
				'multiple' => true,	
				'separator' => 'before',					
			]
		);		

		$this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'large',
                'separator' => 'before',
                'exclude' => [
                    'custom'
                ],                
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'course_per',
			[
				'label' => esc_html__( 'Event Per Page', 'afaddon' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'example 3', 'afaddon' ),
				'separator' => 'before',				
			]
		);
	
		$this->add_control(
			'event_col',
			[
				'label'   => esc_html__( 'Columns', 'afaddon' ),
				'type'    => Controls_Manager::SELECT,	
				'default' => 12,			
				'options' => [
					'6' => esc_html__( '2 Column', 'afaddon' ),
					'4' => esc_html__( '3 Column', 'afaddon' ),
					'3' => esc_html__( '4 Column', 'afaddon' ),
					'2' => esc_html__( '6 Column', 'afaddon' ),
					'12' => esc_html__( '1 Column', 'afaddon' ),					
				],
				'separator' => 'before',				
							
			]
		);

		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Course offset', 'afaddon' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'You can write how many course offset. ex(2)', 'afaddon' ),
				'separator' => 'before',				
			]
		); 

		$this->add_control(
		    'event_content_show_hide',
		    [
		        'label' => esc_html__( 'Description Show / Hide', 'rsaddon' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'yes',
		        'options' => [
		            'yes' => esc_html__( 'Yes', 'rsaddon' ),
		            'no' => esc_html__( 'No', 'rsaddon' ),
		        ],                
		        'separator' => 'before',
		    ]
		);

		$this->add_control(
		    'show_catess',
		    [
		        'label'        => esc_html__( 'Show Category', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'no',
		        'default'      => 'no',		        
		    ]		    
		);

		$this->add_control(
		    'add_event',
		    [
		        'label'        => esc_html__( 'Show Address', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
		    'times_event',
		    [
		        'label'        => esc_html__( 'Show Time', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
		    'event_des',
		    [
		        'label' => esc_html__( 'Show Excerpt Limit', 'rsaddon' ),
		        'type' => Controls_Manager::TEXT,
		        'placeholder' => esc_html__( '20', 'rsaddon' ),
		        'separator' => 'before',
		        'condition' => [
		            'event_content_show_hide' => 'yes',
		        ]
		    ]
		);

		$this->add_control(
		    'items_position',
		    [
		        'label' => esc_html__( 'Events Item Vertical Align', 'rsaddon' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'centers',
		        'options' => [
		            'tops' => esc_html__( 'Top', 'rsaddon' ),
		            'centers' => esc_html__( 'Center', 'rsaddon' ),
		        ],                
		        'separator' => 'before',
		    ]
		);

		$this->add_responsive_control(
		    'area_spacing',
		    [
		        'label' => esc_html__( 'Events Item Bottom Gap', 'rsaddon' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .events-short' => 'margin-bottom: {{SIZE}}{{UNIT}};',
		        ],
		    ]
		);	
		
        $this->end_controls_section();  

		$this->start_controls_section(
			'metas_section',
			[
				'label' => esc_html__( 'Meta Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'event_multi_color',
			[
				'label'   => esc_html__( 'Select Color', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',				
				'options' => [
					'1' => 'Custom Color',
					'2' => 'Multi Color',			
				],											
			]
		);

		$this->add_control(
            'custom_date_color_1',
            [
                'label' => esc_html__( 'Date Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part .date' => 'color: {{VALUE}};',                   
                ], 
                'condition' => [
                    'event_multi_color' => '1',
                ],            
            ]
            
        ); 

        $this->add_control(
            'custom_month_color',
            [
                'label' => esc_html__( 'Month Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'event_multi_color' => '1',
                ],
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part .month' => 'color: {{VALUE}};',                   
                ],                
            ]
            
        );
     
        $this->add_control(
            'custom_date_color_bg',
            [
                'label' => esc_html__( 'Date Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'event_multi_color' => '1',
                ],
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part' => 'background: {{VALUE}};',                   
                ],                
            ]
        ); 	
		$this->end_controls_section();


        $this->start_controls_section(
			'section_items_style',
			[
				'label' => esc_html__( 'Events Item Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
            'date_color_bg',
            [
                'label' => esc_html__( 'Events Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short' => 'background: {{VALUE}};',                   
                ],                
            ]  
        ); 
        $this->add_control(
            'border_color_bg',
            [
                'label' => esc_html__( 'Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short, #rs-event .events-short' => 'border-color: {{VALUE}};',                   
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
		            '{{WRAPPER}} .events-short' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
		
		$this->end_controls_section();


        $this->start_controls_section(
			'section_event_cate_style',
			[
				'label' => esc_html__( 'Category Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'category_color',
		    [
		        'label' => esc_html__( 'Category Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .events-short .content-part .categorie a' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);

		$this->add_control(
		    'category_color_hover',
		    [
		        'label' => esc_html__( 'Category Hover Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .events-short .content-part .categorie a:hover' => 'color: {{VALUE}};',                    
		        ],                
		    ]		    
		);  

		$this->end_controls_section();  


        $this->start_controls_section(
			'section_event_style',
			[
				'label' => esc_html__( 'Title Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .content-part .title a' => 'color: {{VALUE}};',                   

                ],                
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .content-part .title a:hover' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .events-short .content-part .title',                    
			]
		);

        $this->add_responsive_control(
		    'title_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->end_controls_section();  


        $this->start_controls_section(
			'section_meta_style',
			[
				'label' => esc_html__( 'Meta Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'metacolors_s',
		    [
		        'label' => esc_html__( 'Meta Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-events-style1.rs-events-style22 .events-short .categorie .time' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .time' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-events-style1 .content-part .categorie .address' => 'color: {{VALUE}};',
		        ],                
		    ]
		);

		$this->add_control(
		    'metacolor_color',
		    [
		        'label' => esc_html__( 'Meta Icon Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-events-style1.rs-events-style22 .events-short .categorie .time i' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .time i' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-events-style1 .content-part .categorie .address i' => 'color: {{VALUE}};',
		        ],                
		    ]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'time_typography',
				'label' => esc_html__( 'Time & Location Typography', 'rsaddon' ),
				'selectors' => '{{WRAPPER}} .rs-events-style1.rs-events-style22 .events-short .categorie .time, {{WRAPPER}} .rs-events-style1 .time, {{WRAPPER}} .rs-events-style1 .content-part .categorie .address',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'month_typography',
				'label' => esc_html__( 'Month Typography', 'rsaddon' ),
				'selector' => '{{WRAPPER}} .events-short .date-part .month',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'date_typography',
				'label' => esc_html__( 'Date Typography', 'rsaddon' ),
				'selector' => '{{WRAPPER}} .events-short .date-part .date',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);  

        $this->add_responsive_control(
            'cats_border_radius',
            [
                'label' => esc_html__( 'Events Date Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();  


        $this->start_controls_section(
			'section_event_content_style',
			[
				'label' => esc_html__( 'Excerpt Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'excerpt_color',
		    [
		        'label' => esc_html__( 'Excerpt Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .content-part .txt' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);
        $this->add_responsive_control(
		    'excerpt_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
						'post_type'           => 'events',
						'posts_per_page'      => $settings['course_per'],
						'ignore_sticky_posts' => 1,
						'offset'              => $settings['offset']
				));	  
	        }   
	        else{
	        	$best_wp = new wp_Query(array(
					'post_type'           => 'events',
					'posts_per_page'      => $settings['course_per'],
					'ignore_sticky_posts' => 1,
					'offset'              => $settings['offset'],
					'tax_query' => array(
				        array(
							'taxonomy' => 'event-category',
							'field'    => 'slug', //can be set to ID
							'terms'    =>  $cat//if field is ID you can reference by cat/term number
				        ),
				    )
				));	  
	        }

	        ?>



	    <?php     
	        //Style One		
		if('1' == $settings['event_grid_style']){  ?>  
			<div id="rs-event" class="rs-events-grid rs-events-style1">	
				<div class="inner-column">
					<div class="blocks-outer">
						<div class="row">
							<?php 	
							while($best_wp->have_posts()): $best_wp->the_post();							
							$start_date       = get_post_meta( get_the_ID(), 'ev_start_date', true);
							$ev_start_time    = get_post_meta( get_the_ID(), 'ev_start_time', true);
							$ev_end_time   = get_post_meta( get_the_ID(), 'ev_end_time', true);
							$ev_start_time    = ($ev_start_time) ? $ev_start_time : '';
							$ev_end_time   = ($ev_end_time) ? $ev_end_time : '';
							$ev_location       = get_post_meta( get_the_ID(), 'ev_location', true);
							$ev_location      = ($ev_location) ? $ev_location : '';
							$event_color      = get_post_meta(get_the_ID(), 'event_color', true);
							$event_color_main = ($event_color) ? 'style = "color: '.$event_color.'"': '';
							$event_bg         = ($event_color) ? 'style = "background: '.$event_color.'"': '';	
							 
		 					if(!empty($settings['event_des'])){
		                             $limit = $settings['event_des'];
		                         }
		                         else{
		                             $limit = 20;
		                         }
							?>	

							<div class="event-block col-lg-<?php echo $settings['event_col']; ?>">								
								<!-- Event Block -->

								<div class="events-short <?php echo wp_kses_post($settings['items_position']);?>">
                                    <div class="date-part" <?php if('2' == $settings['event_multi_color']){ echo $event_bg; } ?>>
                                        <span class="month"><?php echo $newDate = date("M", strtotime($start_date)); ?></span>
                                        <div class="date">
                                        	<?php echo $newDate = date("d", strtotime($start_date)); ?> 
                                        </div>
                                    </div>
                                    <div class="content-part"> 
                                    	<?php if(!empty($settings['show_catess']) || !empty($settings['times_event']) || !empty($settings['add_event']) ) { ?>                               	
                                        <div class="categorie">
                                        	<?php if(!empty($settings['show_catess'])) { ?>
                                            	<?php echo get_the_term_list( $best_wp->ID, 'event-category', '', '  |  ' ); ?>	
                                            <?php } ?>
                                        	<?php if(!empty($settings['times_event'])) { ?>
	                                        	<div class="time">
	                                        	<i class="far fa-clock"></i> <?php echo wp_kses_post($ev_start_time); ?> - <?php echo wp_kses_post($ev_end_time); ?>
	                                        	</div>
                                        	<?php } ?>
                                        	<?php if(!empty($settings['add_event'])) { ?>
                                        		<div class="address"><i class="fa fa-map-o"></i> <?php echo wp_kses_post($ev_location); ?></div>
                                        	<?php } ?>
                                        </div>	
                                        <?php } ?>                                    

                                        <h4 class="title mb-0"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                                        <?php if(($settings['event_content_show_hide'] == 'yes') ){ ?>
	                                        <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
	                                    <?php } ?>
                                    </div>
                                </div>


				
							</div>
							
						<?php 	endwhile; 
						wp_reset_query();?>	
					</div>
			   		</div>  
				</div>	
			</div>
		<?php } ?> 



		<?php     
	        //Style Two		
		if('2' == $settings['event_grid_style']){  ?>  
			<div id="rs-event" class="rs-events-grid rs-events-style1 rs-events-style22">	
				<div class="inner-column">
					<div class="blocks-outer">
						<div class="row">
							<?php 	
							while($best_wp->have_posts()): $best_wp->the_post();							
							$start_date       = get_post_meta( get_the_ID(), 'ev_start_date', true);
							$ev_start_time    = get_post_meta( get_the_ID(), 'ev_start_time', true);
							$ev_end_time   = get_post_meta( get_the_ID(), 'ev_end_time', true);
							$event_color      = get_post_meta(get_the_ID(), 'event_color', true);
							$event_color_main = ($event_color) ? 'style = "color: '.$event_color.'"': '';
							$event_bg         = ($event_color) ? 'style = "background: '.$event_color.'"': '';	
							$ev_start_time    = ($ev_start_time) ? $ev_start_time : '';
							$ev_end_time   = ($ev_end_time) ? $ev_end_time : '';
		 					if(!empty($settings['event_des'])){
		                            $limit = $settings['event_des'];
		                        }
		                        else{
		                            $limit = 20;
		                        }
							?>	

							<div class="event-block col-lg-<?php echo $settings['event_col']; ?>">								
								<!-- Event Block -->

								<div class="events-short <?php echo wp_kses_post($settings['items_position']);?>">
	                                <div class="date-part">
	                                    <a href="<?php the_permalink();?>"> <?php the_post_thumbnail($settings['thumbnail_size']);?></a>
	                                </div>
	                                <div class="content-part">
	                                	
	                                    <div class="categorie">
	                                    	<?php if(!empty($settings['show_catess'])) { ?>
	                                        	<?php echo get_the_term_list( $best_wp->ID, 'event-category', '', '  |  ' ); ?>
	                                    	<?php } ?>
	                                        <div class="time"><i class="far fa-clock"></i> <?php echo wp_kses_post($ev_start_time); ?> - <?php echo wp_kses_post($ev_end_time); ?></div>	
	                                    </div> 


	                                    <h4 class="title mb-0"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
	                                    <?php if(($settings['event_content_show_hide'] == 'yes') ){ ?>
	                                        <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
	                                    <?php } ?>
	                                </div>
	                            </div>				
							</div>							
						<?php 	endwhile; 
						wp_reset_query();?>	
						</div>
			   		</div>  
				</div>	
			</div>		
		<?php } ?>   

		<?php 	

	}

	public function getCategories(){
         $cat_list = [];
         if ( post_type_exists( 'events' ) ) { 
          $terms = get_terms( array(
             'taxonomy'    => 'event-category',
             'hide_empty'  => true            
         ) );
            
    
         foreach($terms as $post) {

          $cat_list[$post->slug]  = [$post->name];

         }
      }  
        return $cat_list;
     }
}?>