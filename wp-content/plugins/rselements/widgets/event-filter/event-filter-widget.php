<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

defined( 'ABSPATH' ) || die();

class Rsaddon_Elementor_Events_Filter_Pro_Widget extends \Elementor\Widget_Base {

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
		return 'rsevent-filter';
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
		return esc_html__( 'RS Events Filter', 'rsaddon' );
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
		return 'glyph-icon flaticon-slider-1';
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
				'default' => 'style1',				
				'options' => [
					'style1' => 'Default',
					'style2' => 'Transparent',
					'style3' => 'Style 3',
					'style4' => 'Style 4',
				],											
			]
		);

		$this->add_control(
			'cat',
			[
				'label'   => esc_html__( 'Category', 'afaddon' ),
				'type'    => Controls_Manager::SELECT2,	
				'options'   => $this->getCategories(),
				'multiple' => true,	
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
			'show_filter',
			[
				'label'   => esc_html__( 'Show Filter', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'filter_show',				
				'options' => [
					'filter_show' => 'Show',
					'filter_hide' => 'Hide',				
				],											
			]
		);

		$this->add_control(
			'filter_title',
			[
				'label' => esc_html__( 'Filter Default Title', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'All',
				'condition' => [
                	'show_filter' => 'filter_show',
                ],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
            'align_filter',
            [
                'label' => esc_html__( 'Alignment Filter Menu', 'rsaddon' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__( 'Left', 'rsaddon' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'rsaddon' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__( 'Right', 'rsaddon' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__( 'Justify', 'rsaddon' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filter' => 'text-align: {{VALUE}}'
                ],
				'separator' => 'before',
				'condition' => [
                	'show_filter' => 'filter_show',
                ],
            ]
        );

		$this->add_control(
			'event_col',
			[
				'label'   => esc_html__( 'Columns', 'afaddon' ),
				'type'    => Controls_Manager::SELECT,	
				'default' => 4,			
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
		    'event_des',
		    [
		        'label' => esc_html__( 'Show Excerpt Limit', 'rsaddon' ),
		        'type' => Controls_Manager::TEXT,
		        'placeholder' => esc_html__( '16', 'rsaddon' ),
		        'separator' => 'before',
		        'condition' => [
		            'event_content_show_hide' => 'yes',
		        ]
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
			'menu_style',
			[
				'label' => esc_html__( 'Menu Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
                	'show_filter' => 'filter_show',
                ],
			]
		);
		$this->add_control(
            'menu_color',
            [
                'label' => esc_html__( 'Menu Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filter button' => 'color: {{VALUE}};',                   
                ],                
            ]
        );
		$this->add_control(
            'menu_active_color',
            [
                'label' => esc_html__( 'Menu Active Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                	'{{WRAPPER}} .portfolio-filter button:hover' => 'color: {{VALUE}};', 
                    '{{WRAPPER}} .portfolio-filter button.active' => 'color: {{VALUE}};',                   
                ],                
            ]
        );
        $this->add_control(
            'menu_bg_color',
            [
                'label' => esc_html__( 'Menu Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .portfolio-filter button' => 'background: {{VALUE}} !important;',                   
                ],                
            ]
        );
        $this->add_control(
            'menu_active_bg_color',
            [
                'label' => esc_html__( 'Menu Active Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                	'{{WRAPPER}} .portfolio-filter button:hover' => 'background: {{VALUE}} !important;',  
                    '{{WRAPPER}} .portfolio-filter button.active' => 'background: {{VALUE}} !important;',                   
                ],                
            ]
        );
        $this->add_responsive_control(
		    'menu_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-filter button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);
        $this->add_control(
		    'menu_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .portfolio-filter button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
		        ],
		    ]
		);
        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'menu_typography',
				'label' => esc_html__( 'Title Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .portfolio-filter button',                    
			]
		);
		$this->end_controls_section();


		$this->start_controls_section(
			'images_section',
			[
				'label' => esc_html__( 'Image Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'show_thum',
		    [
		        'label'        => esc_html__( 'Show Image', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
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
                'condition' => [
                    'show_thum' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

		$this->add_responsive_control(
		    'img_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .events-short .featured-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'show_thum' => 'yes',
		        ],
		        'separator' => 'before',
		    ]
		);

		$this->add_responsive_control(
		    'img_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .events-short .featured-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .events-short .featured-img:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'show_thum' => 'yes',
		        ],
		    ]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'cate_section',
			[
				'label' => esc_html__( 'Category Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
		    'show_cates',
		    [
		        'label'        => esc_html__( 'Show Category', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
		    'cate_position',
		    [
		        'label' => esc_html__( 'Category Position', 'rsaddon' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'tops',
		        'options' => [
		            'tops' => esc_html__( 'Top', 'rsaddon' ),
		            'bottoms' => esc_html__( 'Bottom', 'rsaddon' ),
		        ],  
		        'condition' => [
		            'show_cates' => 'yes',
		        ],              
		        'separator' => 'before',
		    ]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'lock_section',
			[
				'label' => esc_html__( 'Address Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
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

		$this->end_controls_section();


		$this->start_controls_section(
			'time_section',
			[
				'label' => esc_html__( 'Time Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'event_grid_style' => 'style2',
				],
			]
		);

		$this->add_control(
		    'tim_event',
		    [
		        'label'        => esc_html__( 'Time Show / Hide', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		        'condition' => [
		            'event_grid_style' => ['style2', 'style1'],
		        ],
		    ]
		);

		$this->end_controls_section();



		$this->start_controls_section(
			'times_section',
			[
				'label' => esc_html__( 'Time Settings', 'afaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
				'condition' => [
				    'event_grid_style' =>['style3', 'style4'],
				],
			]
		);

		$this->add_control(
		    'tims_event',
		    [
		        'label'        => esc_html__( 'Time Show / Hide', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		        'condition' => [
		            'event_grid_style' =>['style3', 'style4'],
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
		    'show_meta',
		    [
		        'label'        => esc_html__( 'Show Meta', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
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
		    'meta_position',
		    [
		        'label' => esc_html__( 'Date Position', 'rsaddon' ),
		        'type' => Controls_Manager::SELECT,
		        'default' => 'tops',
		        'options' => [
		            'tops' => esc_html__( 'Top', 'rsaddon' ),
		            'bottoms' => esc_html__( 'Bottom', 'rsaddon' ),
		        ],  
		        'condition' => [
		            'show_meta' => 'yes',
		        ], 
		        'condition' => [
		            'event_grid_style' => 'style3',
		        ],             
		        'separator' => 'before',
		    ]
		);
     	
		$this->end_controls_section();

        $this->start_controls_section(
            'button_section',
            [
                'label' => esc_html__( 'Button Settings', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
		    'show_btn',
		    [
		        'label'        => esc_html__( 'Show Event Button', 'rsaddon' ),
		        'type'         => Controls_Manager::SWITCHER,
		        'label_on'     => esc_html__( 'Show', 'rsaddon' ),
		        'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
		        'return_value' => 'yes',
		        'default'      => 'yes',
		    ]
		);

		$this->add_control(
			'event_btn_text',
			[
                'label'       => esc_html__( 'Button Text', 'rsaddon' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Join Event',
                'placeholder' => esc_html__( 'Event Button Text', 'rsaddon' ),
                'separator'   => 'before',
                'condition'   => [
                    'show_btn' => 'yes',
                ]
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

		$this->add_responsive_control(
		    'align',
		    [
		        'label' => esc_html__( 'Text Alignment', 'rsaddon' ),
		        'type' => Controls_Manager::CHOOSE,
		        'options' => [
		            'left' => [
		                'title' => esc_html__( 'Left', 'rsaddon' ),
		                'icon' => 'fa fa-align-left',
		            ],
		            'center' => [
		                'title' => esc_html__( 'Center', 'rsaddon' ),
		                'icon' => 'fa fa-align-center',
		            ],
		            'right' => [
		                'title' => esc_html__( 'Right', 'rsaddon' ),
		                'icon' => 'fa fa-align-right',
		            ],
		            'justify' => [
		                'title' => esc_html__( 'Justify', 'rsaddon' ),
		                'icon' => 'fa fa-align-justify',
		            ],
		        ],
		        'toggle' => true,
		        'selectors' => [
		            '{{WRAPPER}} .events-short' => 'text-align: {{VALUE}}',
		        ],
		        'default'   => 'left',
		        'separator' => 'before',
		    ]
		);

        $this->add_control(
            'date_color_bg',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short' => 'background: {{VALUE}};',                   
                ], 
                'condition' => [
                    'event_grid_style' => 'style1',
                ],               
            ]  
        ); 

        $this->add_control(
            'date_color_bgs',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short' => 'background: {{VALUE}};',                   
                ], 
                'condition' => [
                    'event_grid_style' => 'style3',
                ],               
            ]  
        );

        $this->add_control(
            'border_color_bg',
            [
                'label' => esc_html__( 'Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .event-btm' => 'border-color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short' => 'border-color: {{VALUE}};',                   
                ],
                'condition' => [
                    'event_grid_style' => ['style1', 'style4'],
                ],                
            ]    
        ); 

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadows',
                'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
                'selector' => '{{WRAPPER}} .rs-event-slider .event-item .events-short',
                'condition' => [
                    'event_grid_style' => 'style1',
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
		            '{{WRAPPER}} .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .rs-event-slider.event-slider-style2 .event-item .events-short .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'],
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'padding_areas',
		    [
		        'label' => esc_html__( 'Content Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .content-part' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style4'],
		        ],
		    ]
		);

        $this->add_responsive_control(
		    'padding_items_areas',
		    [
		        'label' => esc_html__( 'Item Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style4'],
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
		    'category_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a' => 'background-color: {{VALUE}};',                   
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a' => 'background-color: {{VALUE}};',                   
		        ],                
		    ]
		);

		$this->add_control(
		    'category_color',
		    [
		        'label' => esc_html__( 'Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a' => 'color: {{VALUE}};',                   
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);


		$this->add_control(
		    'category_color_hover',
		    [
		        'label' => esc_html__( 'Hover Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .categorie a:hover' => 'color: {{VALUE}};',                    
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a:hover' => 'color: {{VALUE}};',                    
		        ],                
		    ]		    
		);  

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'cates_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'selector' => '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a, {{WRAPPER}} .events-short .categorie a',
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);

        $this->add_responsive_control(
		    'cate_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .content-part .categorie' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

        $this->add_responsive_control(
            'catebg_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .categorie a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'cate_position' => 'tops',
                ]
            ]
        );

		$this->end_controls_section(); 



        $this->start_controls_section(
			'add_event_style',
			[
				'label' => esc_html__( 'Address Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'add_color',
            [
                'label' => esc_html__( 'Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .address' => 'color: {{VALUE}};',                  
                ],                
            ]
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'add_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .events-short .address',                                    
			]
		);
		$this->end_controls_section();  

        $this->start_controls_section(
			'time_event_style',
			[
				'label' => esc_html__( 'Time Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);		

        $this->add_control(
            'time_color',
            [
                'label' => esc_html__( 'Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-event-slider .event-item .events-short .time' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-slider .event-item .events-short .time i:before' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-slider.event-slider-style3 .event-item .time-sec .timesec i:before' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-slider.event-slider-style3 .event-item .time-sec .timesec' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .timesec' => 'color: {{VALUE}};',                   
                ],                
            ]
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'time_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rs-event-slider .event-item .events-short .time, {{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .timesec, {{WRAPPER}} .rs-event-slider.event-slider-style3 .event-item .time-sec .timesec',                                    
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
                'label' => esc_html__( 'Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .content-part .title a' => 'color: {{VALUE}};',
                ],             
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Hover Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short:hover .content-part .title a' => 'color: {{VALUE}};',                    
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .events-short .content-part .title, {{WRAPPER}} .rs-event-slider .event-item .events-short .content-part .title a',                   
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
            'bg_date_colors',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .dates' => 'background-color: {{VALUE}};',                                     
                    '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .date-sec' => 'background-color: {{VALUE}};',                                     
                ],                 
                'condition' => [
                    'event_grid_style' => ['style3', 'style4'],
                ],           
            ]  
        ); 

        $this->add_control(
            'meta_icons_color',
            [
                'label' => esc_html__( 'Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-event-grid .event-item .time-secs .time i::before' => 'color: {{VALUE}} !important;',
                ],             
            ]
        );

		$this->add_control(
            'custom_date_color_1',
            [
                'label' => esc_html__( 'Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .events-short .date-part .date' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .dates' => 'color: {{VALUE}};',                   
                    '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .date-sec' => 'color: {{VALUE}};',                   
                ],                 
                'condition' => [
                    'show_meta' => 'yes',
                ],           
            ]  
        ); 

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'month_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'selector' => '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm .date-part, {{WRAPPER}} .date-part .date, {{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .date-sec, {{WRAPPER}} .rs-event-slider .event-item .events-short .featured-img .dates',				
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
			]
		);  

        $this->add_responsive_control(
		    'date_space_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => 'style2',
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
		        'label' => esc_html__( 'Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .content-part .txt' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'exc_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .events-short .content-part .txt, {{WRAPPER}} .rs-event-slider .event-item .events-short .content-part .txt',               
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
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .content-part .txt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->end_controls_section();  


        $this->start_controls_section(
			'event_btn_style',
			[
				'label' => esc_html__( 'Button Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
		    'btn_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm .join-btn' => 'background-color: {{VALUE}};',                   

		        ], 
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'], 
		        ],	              
		    ]
		);

		$this->add_control(
		    'btn_color',
		    [
		        'label' => esc_html__( 'Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm .join-btn' => 'color: {{VALUE}};',                   

		        ],                
		    ]
		);

		$this->add_control(
		    'd_btn_color_hovers',
		    [
		        'label' => esc_html__( 'Hover Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .btn-part a.join-btn:hover' => 'color: {{VALUE}};',                   
		        ],   
		        'condition' => [
		            'event_grid_style' => ['style4'], 
		        ],             
		    ]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'btn_typography',
				'label' => esc_html__( 'Typography', 'rsaddon' ),
				'scheme' => Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm .join-btn',                                     
			]
		);

        $this->add_responsive_control(
		    'btn_padding_area',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-slider .event-item .events-short .event-btm .join-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => ['style1', 'style2', 'style3'], 
		        ],		        
		    ]
		);

		$this->add_responsive_control(
		    'd_btn_area_spacing',
		    [
		        'label' => esc_html__( 'Button Top Gap', 'rsaddon' ),
		        'type' => Controls_Manager::SLIDER,
		        'size_units' => ['px'],
		        'selectors' => [
		            '{{WRAPPER}} .rs-event-grid.event-slider-style4 .event-item .events-short .event-btm' => 'margin-top: {{SIZE}}{{UNIT}};',
		        ],
		        'condition' => [
		            'event_grid_style' => 'style4',
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
	?>	 


		<div class="rsaddon-unique-sliders rs-events-filter rs-event-slider rs-event-grid event-slider-<?php echo esc_attr($settings['event_grid_style']); ?>">

			<?php if('filter_show' == $settings['show_filter']){?>
				<div class="portfolio-filter">
				    <button class="active" data-filter="*"><?php echo esc_html($settings['filter_title']);?></button>

				    <?php $taxonomy = "event-category";
					    $select_cat = $settings['cat'];
	                    foreach ($select_cat as $catid) {
	                    
	                    $term = get_term_by('slug', $catid, $taxonomy);
	                    $term_name  =  $term->name;
	                    $term_slug  =  $term->slug;
                    ?>
		            	<button data-filter=".filter_<?php echo esc_html($term_slug);?>"><?php echo esc_html($term_name);?></button>
		            <?php  } ?>

				</div>
			<?php } ?>


			<div id="rsaddon-grid" class="rs-addon-sliders row grid">
				<?php 
					if('style1' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style1.php");
					}
					if('style2' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style2.php");
					}
					if('style3' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style3.php");
					}
					if('style4' == $settings['event_grid_style']){
						include(plugin_dir_path(__FILE__)."/style4.php");
					}
				?>
			</div>
		</div>
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