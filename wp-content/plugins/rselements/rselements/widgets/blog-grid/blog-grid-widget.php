<?php
/**
 * Elementor blog Widget.
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

class Rsaddon_Elementor_pro_Blog_Grid_Widget extends \Elementor\Widget_Base {

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
		return 'rsblog';
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
		return esc_html__( 'RS Blog Grid', 'rsaddon' );
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
		return 'glyph-icon flaticon-blogging';
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

		$post_categories = get_terms( 'category' );

        $post_options = [];
        foreach ( $post_categories as $category ) {
            $post_options[ $category->slug ] = $category->name;
        }


		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content Settings', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

        $this->add_control(
            'blog_grid_style',
            [
                'label'   => esc_html__( 'Select Style', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',               
                'options' => [
                    'default' => 'Default',
                    'style1' => 'Style 1',
                    'style2' => 'Style 2',           
                    'style3' => 'Style 3',           
                ],                                          
            ]
        );

		$this->add_control(
			'category',
			[
				'label'   => esc_html__( 'Category', 'rsaddon' ),				
				'type'        => Controls_Manager::SELECT,
                'options'     => $post_options,
                'default'     => [],
				'multiple' => true,	
				'separator' => 'before',		
			]

		);
	
		$this->add_responsive_control(
			'blog_columns',
			[
				'label'   => esc_html__( 'Columns', 'rsaddon' ),
				'type'    => Controls_Manager::SELECT,	
                'default' => 4,			
				'options' => [
					'6' => esc_html__( '2 Column', 'rsaddon' ),
					'4' => esc_html__( '3 Column', 'rsaddon' ),
					'3' => esc_html__( '4 Column', 'rsaddon' ),
					'2' => esc_html__( '6 Column', 'rsaddon' ),
					'12' => esc_html__( '1 Column', 'rsaddon' ),					
				],
				'separator' => 'before',							
			]
		);


		$this->add_control(
			'per_page',
			[
				'label' => esc_html__( 'Blog Show Per Page', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '6', 'rsaddon' ),
				'separator' => 'before',
			]
		);

        $this->add_control(
            'post_offset',
            [
                'label' => esc_html__( 'Offset', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,                
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'blog_content_show_hide',
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
            'blog_word_show',
            [
                'label' => esc_html__( 'Show Content Limit', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__( '20', 'rsaddon' ),
                'separator' => 'before',
                'condition' => [
                    'blog_content_show_hide' => 'yes',
                ]
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

        $this->end_controls_section();

        $this->start_controls_section(
            'meta_section',
            [
                'label' => esc_html__( 'Meta Settings', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
		$this->add_control(
            'blog_avatar_show_hide',
            [
                'label' => esc_html__( 'Author Show / Hide', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rsaddon' ),
                    'no' => esc_html__( 'No', 'rsaddon' ),
                ],                
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'blog_cat_show_hide',
            [
                'label' => esc_html__( 'Category Show / Hide', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rsaddon' ),
                    'no' => esc_html__( 'No', 'rsaddon' ),
                ],                
                'separator' => 'before',
            ]
        );

		$this->add_control(
            'blog_meta_show_hide',
            [
                'label' => esc_html__( 'Date Show / Hide', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rsaddon' ),
                    'no' => esc_html__( 'No', 'rsaddon' ),
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
            'blog_readmore_show_hide',
            [
                'label' => esc_html__( 'Read More Show / Hide', 'rsaddon' ),
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
            'blog_pagination_show_hide',
            [
                'label' => esc_html__( 'Pagination Show / Hide', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rsaddon' ),
                    'no' => esc_html__( 'No', 'rsaddon' ),
                ],                
                'separator' => 'before',
            ]
        );


		$this->add_control(
			'blog_btn_text',
			[
                'label'       => esc_html__( 'Blog Button Text', 'rsaddon' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Read More',
                'placeholder' => esc_html__( 'Blog Button Text', 'rsaddon' ),
                'separator'   => 'before',
                'condition'   => [
                    'blog_readmore_show_hide' => 'yes',
                ]
			]
		);


		$this->add_control(
			'blog_btn_icon',
			[
                'label'     => esc_html__( 'Icon', 'rsaddon' ),
                'type'      => Controls_Manager::ICON,
                'options'   => rsaddon_pro_get_icons(),				
                'default'   => 'fa fa-angle-right',
                'separator' => 'before',
                'condition' => [
                    'blog_readmore_show_hide' => 'yes',
                ]			
			]
		);
				
		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_style',
			[
				'label' => esc_html__( 'Blog Item Style', 'rsaddon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
                'selector' => '{{WRAPPER}} .blog-item',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => esc_html__( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient', 'rsaddon' ],
                'selector' => '{{WRAPPER}} .blog-item',
                
            ]
        );

        $this->add_control(
            'blog_border_color',
            [
                'label' => esc_html__( 'Item Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item' => 'border-color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_responsive_control(
            'blog_bottom_spacing',
            [
                'label' => esc_html__( 'Item Bottom Spacing', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_grid_style',
            [
                'label' => esc_html__( 'Blog Meta Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blog_meta_color',
            [
                'label' => esc_html__( 'Meta Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .blog-meta' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control(
            'blog_meta_icon_color',
            [
                'label' => esc_html__( 'Meta Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .blog-meta i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-blog-grid1 .blog-content .btn-btm .post-categories li::before' => 'color: {{VALUE}};',
                ],                
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_category',
            [
                'label' => esc_html__( 'Category Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blog_cat_color',
            [
                'label' => esc_html__( 'Category Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item .blog-content .cat_list ul li a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogs-style4 .rs-articles .blog-heading .cat_list ul li a' => 'color: {{VALUE}};',                    
                    '{{WRAPPER}} .blogs-style3 .rs-articles .blog-heading .cat_list ul li a, .cat_list ul li a' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ]                
            ]
        );

        $this->add_control(
            'blog_cat_hover_color',
            [
                'label' => esc_html__( 'Category Hover Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item .blog-content .cat_list ul li a:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .blogs-style4 .rs-articles .blog-heading .cat_list ul li a:hover' => 'color: {{VALUE}};',                    
                    '{{WRAPPER}} .blogs-style3 .rs-articles .blog-heading .cat_list ul li a:hover, .cat_list ul li a:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ]                
            ]
        );

        $this->add_control(
            'blog_cat_bg_color',
            [
                'label' => esc_html__( 'Category Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item .blog-content .cat_list ul li a' => 'background: {{VALUE}};',

                ], 
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ]               
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typography',
                'label' => esc_html__( 'Category Typography', 'rsaddon' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => 
                    '{{WRAPPER}} .cat_list ul li a',
            ]
        );

        $this->add_responsive_control(
            'category_content_padding',
            [
                'label' => esc_html__( 'Padding', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .cat_list ul li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    
                ],
            ]
        );
        $this->add_responsive_control(
            'cats_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .cat_list ul li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       

        $this->end_controls_section();



        $this->start_controls_section(
            'section_slider_title',
            [
                'label' => esc_html__( 'Title & Description Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .title a' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => esc_html__( 'Title Hover Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .title a:hover' => 'color: {{VALUE}};',
                ],                
            ]
            
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => esc_html__( 'Title Typography', 'rsaddon' ),
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => 
                    '{{WRAPPER}} .blog-item .blog-content .title a',
			]
		);

        $this->add_responsive_control(
            'title_content_padding',
            [
                'label' => esc_html__( 'Margin', 'rsaddon' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid1 .blog-content p.txt ' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'des_typography',
                'label' => esc_html__( 'Description Typography', 'rsaddon' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => 
                    '{{WRAPPER}} .rs-blog-grid1 .blog-content p.txt ',
            ]
        );

        $this->add_responsive_control(
            'des_content_padding',
            [
                'label' => esc_html__( 'Margin', 'rsaddon' ),
                'type'  => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid1 .blog-content p.txt ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


		$this->end_controls_section();


        $this->start_controls_section(
            'section_content_sec',
            [
                'label' => esc_html__( 'Content Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__( 'Content Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content p, {{WRAPPER}} .article-content p, {{WRAPPER}} .blogs-style3 .rs-articles.rs-articles .article-grid .article-content p' => 'color: {{VALUE}};',
                ],                
            ]
        );

        $this->add_responsive_control(
            'blog_contents_padding',
            [
                'label'=> esc_html__( 'Padding', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],  
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );  

        $this->end_controls_section();

		//Read More Style
		$this->start_controls_section(
		    '_section_style_button',
		    [
		        'label' => esc_html__( 'Read More Style', 'rsaddon' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);

		$this->add_responsive_control(
		    'blog_btn_link_padding',
		    [
		        'label' => esc_html__( 'Padding', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', 'em', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Typography::get_type(),
		    [
		        'name' => 'btn_typography',
		        'selector' => '{{WRAPPER}} .blog-item .blog-content .btn-part a',
		        'scheme' => Scheme_Typography::TYPOGRAPHY_4,
		    ]
		);

		$this->add_control(
		    'blog_btn_border_radius',
		    [
		        'label' => esc_html__( 'Border Radius', 'rsaddon' ),
		        'type' => Controls_Manager::DIMENSIONS,
		        'size_units' => [ 'px', '%' ],
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		        ],
		    ]
		);

		$this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    [
		        'name' => 'blog_btn_box_shadow',
		        'selector' => '{{WRAPPER}} .blog-item .blog-content .btn-part a',
		    ]
		);
        $this->add_control(
            'top_border_color',
            [
                'label' => esc_html__( 'Top Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid1 .blog-content .btn-btm' => 'border-color: {{VALUE}};',
                ],  
                'condition' => [
                    'blog_grid_style' => 'default',
                ]              
            ]
        );

		$this->add_control(
		    'hr',
		    [
		        'type' => Controls_Manager::DIVIDER,
		        'style' => 'thick',
		    ]
		);

		$this->start_controls_tabs( '_tabs_button' );

		$this->start_controls_tab(
		    '_blog_btn_normal',
		    [
		        'label' => esc_html__( 'Normal', 'rsaddon' ),
		    ]
		);

		$this->add_control(
		    'link_color',
		    [
		        'label' => esc_html__( 'Text Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a' => 'color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'blog_btn_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'blog_btn_icon_translate',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'rsaddon' ),
		        'type' => Controls_Manager::SLIDER,
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .blog-item .blog-content .btn-part a i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .blog-item .blog-content .btn-part a i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		    ]
		);

		$this->end_controls_tab();


		$this->start_controls_tab(
		    '_blog_btn_button_hover',
		    [
		        'label' => esc_html__( 'Hover', 'rsaddon' ),
		    ]
		);

		$this->add_control(
		    'blog_btn_hover_color',
		    [
		        'label' => esc_html__( 'Text Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content:hover .btn-part a,
                    {{WRAPPER}} .blog-item .btn-part a:hover, 
                    {{WRAPPER}} .blog-item .blog-content:focus .btn-part' => 'color: {{VALUE}}',
                   
		        ],
		    ]
		);

		$this->add_control(
		    'blog_btn_hover_bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .blog-item .blog-content:hover .btn-part a' => 'background-color: {{VALUE}};',
		        ],
		    ]
		);

		$this->add_control(
		    'blog_btn_hover_icon_translate',
		    [
		        'label' => esc_html__( 'Icon Translate X', 'rsaddon' ),
		        'type' => Controls_Manager::SLIDER,
		        'default' => [
		            'size' => 10
		        ],
		        'range' => [
		            'px' => [
		                'min' => -100,
		                'max' => 100,
		            ],
		        ],
		        'selectors' => [
		            '{{WRAPPER}} .blog-item:hover .blog-content .btn-part a i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
		            '{{WRAPPER}} .blog-item:hover .blog-content .btn-part a i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .blog-item:hover .blog-content .btn-part a i' => '-webkit-transform: translateX(calc(-1 * {{SIZE}}{{UNIT}})); transform: translateX(calc(-1 * {{SIZE}}{{UNIT}}));',
                    '{{WRAPPER}} .blog-item:hover .blog-content .btn-part a i' => '-webkit-transform: translateX({{SIZE}}{{UNIT}}); transform: translateX({{SIZE}}{{UNIT}});',
		        ],
		    ]
		);

		$this->end_controls_tab();
		$this->end_controls_section();


		



		// Start Blog Pagination Style
		$this->start_controls_section(
		    '_blog_pagination_style',
		    [
		        'label' => esc_html__( 'Pagination Style', 'rsaddon' ),
		        'tab' => Controls_Manager::TAB_STYLE,
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_color',
		    [
		        'label' => esc_html__( 'Text Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links a' => 'color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_hover_color',
		    [
		        'label' => esc_html__( 'Text Hover Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links a:hover' => 'color: {{VALUE}};',
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links span.current' => 'color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagi_divider_color',
		    [
		        'label' => esc_html__( 'Divider Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'default' => '',
		        'selectors' => [
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links a' => 'border-color: {{VALUE}};',
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links span.current' => 'border-color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_control(
		    'blog_pagiesc_html__bg_color',
		    [
		        'label' => esc_html__( 'Background Color', 'rsaddon' ),
		        'type' => Controls_Manager::COLOR,
		        'selectors' => [
		            '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links' => 'background-color: {{VALUE}};',
		        ],
		        'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
		    ]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'box_pagi_shadow',
				'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
				'selector' => '{{WRAPPER}} .rs-blog-grid .rs-pagination-area .nav-links',
				'condition' => [
                    'blog_pagination_show_hide' => 'yes',
                ]
			]
		);

		$this->end_controls_section();

		// End Blog Pagination Style


		

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
         
		<div class="rs-blog-grid rs-blog-grid2">            
			
            <div class="row blog-gird-item">
                
			 	<?php
			        $cat = $settings['category'];     

			        if(($settings['blog_pagination_show_hide'] == 'yes')){
						global  $paged;
				        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
						if(empty($cat)){
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],										
                                'offset'		 => $settings['post_offset'],
                                'paged'          => $paged		
							));	  
				        }   
				        else{
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' =>  $settings['per_page'],										
                                'offset'         => $settings['post_offset'],
                                'paged'          => $paged,
								'tax_query'      => array(
							        array(
										'taxonomy' => 'category',
										'field'    => 'slug', 
										'terms'    => $cat 
							        ),
							    )
							));	  
				        }
				    }

				    else{
					    if(empty($cat)){
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],	
                                'offset'        => $settings['post_offset']	,		
							));	  
				        }   
				        else{
				        	$best_wp = new wp_Query(array(
			        			'post_type'      => 'post',
								'posts_per_page' => $settings['per_page'],
                                'offset'         => $settings['post_offset'],
								'tax_query'      => array(
							        array(
										'taxonomy' => 'category',
										'field'    => 'slug', 
										'terms'    => $cat 
							        ),
							    )
							));	  
				        }
				    }
			        $x=1;
					while($best_wp->have_posts()): $best_wp->the_post(); 
                     $termsArray = get_the_terms( $best_wp->ID, "category" );  //Get the terms for this particular item
                     $termsString = ""; //initialize the string that will contain the terms
                     foreach ( $termsArray as $term ) { // for each term 
                        $termsString .= 'filter_'.$term->slug.' '; //create a string that has all the slugs 
                     }

					$full_date      = get_the_date();
					$blog_date      = get_the_date('M d y');	
					$post_admin     = get_the_author();

					
					if(!empty($settings['blog_word_show'])){
						$limit = $settings['blog_word_show'];
					}
					else{
						$limit = 20;
					}

                    

					?>
					
					<div class="grid-item col-lg-<?php echo esc_html($settings['blog_columns']);?>  <?php echo esc_attr($termsString);?>">

                        <?php
                        if($settings['blog_grid_style'] == 'default') { ?>
                            <div class="no-gutter blog-item rs-blog-grid1">
                                                           
                                <div class="image-part">
                                    <a href="<?php the_permalink();?>">
                                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                                    </a> 
                                </div>                             
                                
                                <div class="blog-content">                                    
                                       <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
                                        <ul class="blog-meta">
                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                                                <?php if(!empty($full_date)){ ?>
                                                <li><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
                                                <?php if(!empty($post_admin)){ ?>
                                                <li><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></li>
                                                <?php } ?>
                                            <?php } ?>
                                        </ul>
                                        <?php } ?>
                                        
                                        <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                        <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                            <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                        <?php } ?>
                                        <div class="btn-btm d-flex align-items-center justify-content-between">
                                            <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                                <div class="cat_list">
                                                    <?php the_category( ); ?>
                                                </div>
                                            <?php } ?>
                                            <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
                                                <div class="btn-part">
                                                    <a class="readon-arrow" href="<?php the_permalink(); ?>">
                                                        <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        </div>

                                </div>                                
                            
                            </div>
                        <?php } 

                        elseif($settings['blog_grid_style'] == 'style3') { ?>
                            <div class="row align-items-center no-gutter blog-item rs-blog-grid1">                        
                                <div class="col-md-4">                               
                                    <div class="image-part">
                                        <a href="<?php the_permalink();?>">
                                            <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                                        </a> 
                                    </div>                             
                                </div>                             
                                
                                <div class="col-md-8">
                                    <div class="blog-content">                                    
                                           <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
                                            <ul class="blog-meta">
                                                <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                                                    <?php if(!empty($full_date)){ ?>
                                                    <li><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></li>
                                                    <?php } ?>
                                                <?php } ?>
                                                <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
                                                    <?php if(!empty($post_admin)){ ?>
                                                    <li><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                            <?php } ?>
                                            <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                                <div class="cat_list">
                                                    <?php the_category( ); ?>
                                                </div>
                                            <?php } ?>
                                            <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                            <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                                <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                            <?php } ?>
                                            <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
                                                <div class="btn-part">
                                                    <a class="readon-arrow" href="<?php the_permalink(); ?>">
                                                        <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
                                                    </a>
                                                </div>
                                            <?php } ?>
                                    </div>                                
                                </div>                                                            
                            </div>
                        <?php }  

                        elseif($settings['blog_grid_style'] == 'style2') { ?>
	                        <div class="row align-items-center no-gutter blog-item rs-blog-grid1">                    
	                            <?php if($x%2==1){?>    
	                                <div class="col-md-6 1">
	                                    <div class="image-part">
	                                        <a href="<?php the_permalink();?>">
	                                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
	                                        </a> 
	                                    </div>
	                                </div>
	                                <div class="col-md-6">
	                                    <div class="blog-content">
	                                    
	                                       <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
	                                        <ul class="blog-meta">
	                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
	                                                <?php if(!empty($blog_date)){ ?>
	                                                <li><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($blog_date);?></li>
	                                                <?php } ?>
	                                            <?php } ?>
	                                            <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
	                                                <?php if(!empty($post_admin)){ ?>
	                                                <li><i class="fa fa-user-o"></i><?php echo esc_html($post_admin);?></li>
	                                                <?php } ?>
	                                            <?php } ?>
	                                        </ul>
	                                        <?php } ?>
	                                        <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
	                                            <div class="cat_list">
	                                                <?php the_category( ); ?>
	                                            </div>
	                                        <?php } ?>
	                                        <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	                                        <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
	                                            <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
	                                        <?php } ?>
	                                        <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
	                                            <div class="btn-part">
	                                                <a class="readon-arrow" href="<?php the_permalink(); ?>">
	                                                    <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
	                                                </a>
	                                            </div>
	                                        <?php } ?>
	                                    </div>
	                                </div>
	                            <?php } else {?>     
	                                <div class="col-md-6 2">
	                                    <div class="blog-content">
	                                    
	                                       <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
	                                        <ul class="blog-meta">
	                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
	                                                <?php if(!empty($blog_date)){ ?>
	                                                <li> <i class="fa fa-calendar-check-o"></i> <?php echo esc_html($blog_date);?></li>
	                                                <?php } ?>
	                                            <?php } ?>
	                                            <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
	                                                <?php if(!empty($post_admin)){ ?>
	                                                <li> <i class="fa fa-user-o"></i><?php echo esc_html($post_admin);?></li>
	                                                <?php } ?>
	                                            <?php } ?>
	                                        </ul>
	                                        <?php } ?>
	                                        <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
	                                            <div class="cat_list">
	                                                <?php the_category( ); ?>
	                                            </div>
	                                        <?php } ?>
	                                        <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
	                                        <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
	                                            <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
	                                        <?php } ?>
	                                        <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
	                                            <div class="btn-part">
	                                                <a class="readon-arrow" href="<?php the_permalink(); ?>">
	                                                    <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
	                                                </a>
	                                            </div>
	                                        <?php } ?>
	                                    </div>
	                                </div>
	                                <div class="col-md-6">
	                                    <div class="image-part">
	                                        <a href="<?php the_permalink();?>">
	                                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
	                                        </a> 
	                                    </div>
	                                </div>
	                           <?php } ?>

	                        </div>
                        <?php } else { ?>

                        <div class="row align-items-center no-gutter blog-item rs-blog-grid1">

                            <div class="col-md-6">
                                <div class="image-part">
                                    <a href="<?php the_permalink();?>">
                                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                                    </a> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="blog-content">
                                
                                   <?php if( !empty($settings['blog_meta_show_hide']) || !empty($settings['blog_avatar_show_hide'])){?>
                                    <ul class="blog-meta">
                                        <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                                            <?php if(!empty($full_date)){ ?>
                                            <li><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></li>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php if(($settings['blog_avatar_show_hide'] == 'yes') ){ ?>
                                            <?php if(!empty($post_admin)){ ?>
                                            <li><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                    <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                        <div class="cat_list">
                                            <?php the_category( ); ?>
                                        </div>
                                    <?php } ?>
                                    <h3 class="title dd"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                    <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                        <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                    <?php } ?>
                                    <?php if($settings['blog_readmore_show_hide'] == 'yes') { ?>
                                        <div class="btn-part">
                                            <a class="readon-arrow" href="<?php the_permalink(); ?>">
                                                <?php echo esc_html($settings['blog_btn_text']);?> <i class="fa <?php echo esc_html( $settings['blog_btn_icon'] );?>"></i>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <?php } ?>                            
                    </div>
					<?php
                    $x++;
					endwhile;
                    
					wp_reset_query();  ?>                 
                         
                </div>   
                               
            	    
                <?php 

                    $blog_item_data = array(
                    'per_page'  => $settings['per_page']
                );
            wp_localize_script( 'vloglab-main', 'blog_load_data', $blog_item_data );

			$paginate = paginate_links( array(
			    'total' => $best_wp->max_num_pages
			));

			if(!empty($paginate ) && ($settings['blog_pagination_show_hide'] == 'yes')){ ?>
				<div class="rs-pagination-area"><div class="nav-links"><?php echo wp_kses_post($paginate); ?></div></div>
			<?php } ?>              
		</div>
	   <?php

	}
}?>