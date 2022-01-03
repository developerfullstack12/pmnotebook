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
use Elementor\Group_Control_Border;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Rsaddon_Elementor_Pro_Blog_Slider_Widget extends \Elementor\Widget_Base {

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
        return 'rsblog-slider';
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
        return esc_html__( 'RS Blog Slider', 'rsaddon' );
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

        $post_categories = get_terms( 'category' );
        $post_options = [];
        foreach ( $post_categories as $category ) {
            $post_options[ $category->slug ] = $category->name;
        }


        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__( 'Content', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'category',
            [
                'label'   => esc_html__( 'Category', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT2, 
                'options'     => $post_options,
                'default'     => [],
                'label_block' => true,
                'multiple' => true, 
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
            'blog_content_postion_style',
            [
                'label' => esc_html__( 'Content Style', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__( 'Default', 'rsaddon' ),
                    'transparent' => esc_html__( 'transparent', 'rsaddon' ),                   
                ],                
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'blog_avatar_show_hide',
            [
                'label' => esc_html__( 'Author Image Show / Hide', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'no',
                'options' => [
                    'yes' => esc_html__( 'Yes', 'rsaddon' ),
                    'no' => esc_html__( 'No', 'rsaddon' ),
                ],  
                'condition' => [
                    'blog_meta_style' => ['style1, style2'],
                ],              
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'blog_cat_show_hide',
            [
                'label' => esc_html__( 'Category Show/Hide', 'rsaddon' ),
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
            'admin_show_hide',
            [
                'label' => esc_html__( 'Author Show/Hide', 'rsaddon' ),
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
            'd_cates_position',
            [
                'label' => esc_html__( 'Category Position', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'bottoms',
                'options' => [
                    'tops' => esc_html__( 'Top', 'rsaddon' ),
                    'bottoms' => esc_html__( 'Bottom', 'rsaddon' ),
                ],  
                'condition' => [
                    'blog_cat_show_hide' => 'yes',
                ],              
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'blog_meta_show_hide',
            [
                'label' => esc_html__( 'Date Meta Show/Hide', 'rsaddon' ),
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
            'blog_content_show_hide',
            [
                'label' => esc_html__( 'Description Show/Hide', 'rsaddon' ),
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

        $this->end_controls_section();


        $this->start_controls_section(
            'content_section_button',
            [
                'label' => esc_html__( 'Button Settings', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'blog_readmore_show_hide',
            [
                'label' => esc_html__( 'ReadMore Show/Hide', 'rsaddon' ),
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
            'blog_btn_text',
            [
                'label' => esc_html__( 'Blog Button Text', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => '',
                'placeholder' => esc_html__( 'Blog Button Text', 'rsaddon' ),
                'separator' => 'before',
                'condition' => [
                    'blog_readmore_show_hide' => 'yes',
                ]
            ]
        );
                
        $this->end_controls_section();

        //start slider settings
        $this->start_controls_section(
            'section_slider_settings',
            [
                'label' => esc_html__( 'Slider Settings', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'col_lg',
            [
                'label'   => esc_html__( 'Desktops > 1199px', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,
                'options' => [
                    '1' => esc_html__( '1 Column', 'rsaddon' ), 
                    '2' => esc_html__( '2 Column', 'rsaddon' ),
                    '3' => esc_html__( '3 Column', 'rsaddon' ),
                    '4' => esc_html__( '4 Column', 'rsaddon' ),
                    '6' => esc_html__( '6 Column', 'rsaddon' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_md',
            [
                'label'   => esc_html__( 'Desktops > 991px', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rsaddon' ), 
                    '2' => esc_html__( '2 Column', 'rsaddon' ),
                    '3' => esc_html__( '3 Column', 'rsaddon' ),
                    '4' => esc_html__( '4 Column', 'rsaddon' ),
                    '6' => esc_html__( '6 Column', 'rsaddon' ),                     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_sm',
            [
                'label'   => esc_html__( 'Tablets > 767px', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rsaddon' ), 
                    '2' => esc_html__( '2 Column', 'rsaddon' ),
                    '3' => esc_html__( '3 Column', 'rsaddon' ),
                    '4' => esc_html__( '4 Column', 'rsaddon' ),
                    '6' => esc_html__( '6 Column', 'rsaddon' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'col_xs',
            [
                'label'   => esc_html__( 'Tablets < 768px', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 1,         
                'options' => [
                    '1' => esc_html__( '1 Column', 'rsaddon' ), 
                    '2' => esc_html__( '2 Column', 'rsaddon' ),
                    '3' => esc_html__( '3 Column', 'rsaddon' ),
                    '4' => esc_html__( '4 Column', 'rsaddon' ),
                    '6' => esc_html__( '6 Column', 'rsaddon' ),                 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slides_ToScroll',
            [
                'label'   => esc_html__( 'Slide To Scroll', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 2,         
                'options' => [
                    '1' => esc_html__( '1 Item', 'rsaddon' ),
                    '2' => esc_html__( '2 Item', 'rsaddon' ),
                    '3' => esc_html__( '3 Item', 'rsaddon' ),
                    '4' => esc_html__( '4 Item', 'rsaddon' ),                   
                ],
                'separator' => 'before',
                            
            ]
            
        );

        

        $this->add_control(
            'slider_dots',
            [
                'label'   => esc_html__( 'Navigation Dots', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_nav',
            [
                'label'   => esc_html__( 'Navigation Nav', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_autoplay',
            [
                'label'   => esc_html__( 'Autoplay', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'false',           
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_autoplay_speed',
            [
                'label'   => esc_html__( 'Autoplay Slide Speed', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '1000' => esc_html__( '1 Seconds', 'rsaddon' ),
                    '2000' => esc_html__( '2 Seconds', 'rsaddon' ), 
                    '3000' => esc_html__( '3 Seconds', 'rsaddon' ), 
                    '4000' => esc_html__( '4 Seconds', 'rsaddon' ), 
                    '5000' => esc_html__( '5 Seconds', 'rsaddon' ), 
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_stop_on_hover',
            [
                'label'   => esc_html__( 'Stop on Hover', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',               
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),              
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_interval',
            [
                'label'   => esc_html__( 'Autoplay Interval', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 3000,          
                'options' => [
                    '5000' => esc_html__( '5 Seconds', 'rsaddon' ), 
                    '4000' => esc_html__( '4 Seconds', 'rsaddon' ), 
                    '3000' => esc_html__( '3 Seconds', 'rsaddon' ), 
                    '2000' => esc_html__( '2 Seconds', 'rsaddon' ), 
                    '1000' => esc_html__( '1 Seconds', 'rsaddon' ),     
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_loop',
            [
                'label'   => esc_html__( 'Loop', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->add_control(
            'slider_centerMode',
            [
                'label'   => esc_html__( 'Center Mode', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'false',
                'options' => [
                    'true' => esc_html__( 'Enable', 'rsaddon' ),
                    'false' => esc_html__( 'Disable', 'rsaddon' ),
                ],
                'separator' => 'before',
                            
            ]
            
        );

        $this->end_controls_section(); //end slider settings


        $this->start_controls_section(
            'section_slider_style',
            [
                'label' => esc_html__( 'Blog Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'blog_meta_style',
            [
                'label' => esc_html__( 'Blog Meta Style', 'rsaddon' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'style1',
                'options' => [
                    'style1' => esc_html__( 'Style 1', 'rsaddon' ),
                    'style2' => esc_html__( 'Style 2', 'rsaddon' ),
                    'style3' => esc_html__( 'Style 3', 'rsaddon' ),
                ],                
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'blog_avatar_position',
            [
                'label' => esc_html__( 'Blog Author Image Position', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .blog-item .image-wrap .author-avatar' => 'left: {{SIZE}}%;',                   
                ],
                'condition' => [
                    'blog_avatar_show_hide' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'blog_meta_color',
            [
                'label' => esc_html__( 'Meta Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .blog-item .blog-content .blog-meta span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-blog-grid .blog-item .image-wrap .blog-meta' => 'color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'blog_meta_icons_color',
            [
                'label' => esc_html__( 'Meta Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .blog-meta i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm .post-categories::before' => 'color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'blog_meta_bg_color',
            [
                'label' => esc_html__( 'Meta Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item .image-wrap .blog-meta' => 'background: {{VALUE}};',

                ], 
                'condition' => [
                    'blog_meta_style' => 'style2',
                ]               
            ]
        );

        $this->add_responsive_control(
            'blog_bottom_spacing',
            [
                'label' => esc_html__( 'Bottom Spacing', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'blog_content_width',
            [
                'label' => esc_html__( 'Blog Content Width', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-grid .blog-item.transparent .blog-inner-wrap .blog-content' => 'max-width: {{SIZE}}%;',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'box_shadow',
                'label' => esc_html__( 'Box Shadow', 'plugin-domain' ),
                'selector' => '{{WRAPPER}} .blog-content',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => esc_html__( 'Background', 'plugin-domain' ),
                'types' => [ 'classic', 'gradient', 'video' ],
                'selector' => '{{WRAPPER}} .blog-content, {{WRAPPER}} .rs-blog-grid .blog-item.transparent .blog-inner-wrap .blog-content',
                
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
            'blog_multi_color',
            [
                'label'   => esc_html__( 'Select Color', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'custom_style',                
                'options' => [
                    'custom_style' => 'Custom Color',
                    'multi_style' => 'Multi Color',         
                ],
                                                        
            ]
        );

           $this->add_control(
               'blog_cat_color',
               [
                   'label' => esc_html__( 'Category Color', 'rsaddon' ),
                   'type' => Controls_Manager::COLOR,
                   'selectors' => [
                       '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm .post-categories li a, {{WRAPPER}} .rsaddon-unique-slider .blog-content .post-categories li a' => 'color: {{VALUE}};',
                   ],
                   'condition' => [
                       'blog_multi_color' => 'custom_style',
                   ]                
               ]
            );

           $this->add_control(
               'blog_cat_hover_color',
               [
                   'label' => esc_html__( 'Category Hover Color', 'rsaddon' ),
                   'type' => Controls_Manager::COLOR,
                   'selectors' => [
                       '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm .post-categories li a:hover,
                       {{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm .post-categories:hover:before' => 'color: {{VALUE}};',
                   ],
                   'condition' => [
                       'blog_multi_color' => 'custom_style',
                   ]                
               ]
            );


           $this->add_responsive_control(
               'blog_category_padding',
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
                       '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm .post-categories li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   ],
               ]
           );

          $this->end_controls_section(); 

        $this->start_controls_section(
               'section_slider_title',
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
                       '{{WRAPPER}} .blog-content h3.blog-name a, 
                       {{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content h3.blog-name a' => 'color: {{VALUE}};',

                   ],                
               ]
           );

           $this->add_control(
               'title_color_hover',
               [
                   'label' => esc_html__( 'Title Hover Color', 'rsaddon' ),
                   'type' => Controls_Manager::COLOR,
                   'selectors' => [
                       '{{WRAPPER}} .blog-item .blog-content h3.blog-name a:hover,
                       {{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content h3.blog-name a:hover' => 'color: {{VALUE}};',
                   ],                
               ]
               
           );

            $this->add_control(
               
               'title_padding',
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
                       '{{WRAPPER}} .blog-item .blog-content h3.blog-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                       '{{WRAPPER}} .blog-item .blog-content h3.blog-name a',
               ]
           );

           $this->end_controls_section();

           $this->start_controls_section(
               'section_slider_content',
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
                       '{{WRAPPER}} .blog-item .blog-content p' => 'color: {{VALUE}};',

                   ],                
               ]
           );

           $this->add_group_control(
               Group_Control_Typography::get_type(),
               [
                   'name' => 'content_typography',
                   'label' => esc_html__( 'Content Typography', 'rsaddon' ),
                   'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                   'selector' => 
                   '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content p.txt',
               ]
           );

            $this->add_responsive_control(
               'blog_content_padding',
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
                       '{{WRAPPER}} .blog-content, {{WRAPPER}} .rs-blog-grid .blog-item.transparent .blog-inner-wrap .blog-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   ],
               ]
           );

            $this->add_responsive_control(
               'blog_content_margin',
               [
                   'label' => esc_html__( 'Margin', 'rsaddon' ),
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
                       '{{WRAPPER}} .blog-content, {{WRAPPER}} .rs-blog-grid .blog-item.transparent .blog-inner-wrap .blog-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                   ],
               ]
           ); 


         $this->end_controls_section();


          $this->start_controls_section(
            'section_navigation_style',
            [
                'label' => esc_html__( 'Navigation Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'navigation_arrow_background',
            [
                'label' => esc_html__( 'Navigation Arrow Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .rs-blog-slider .rs-addon-slider .slick-prev' => 'background: {{VALUE}};',
                    '{{WRAPPER}}  .rs-blog-slider .rs-addon-slider .slick-next' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_border',
            [
                'label' => esc_html__( 'Navigation Arrow Border', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-next, {{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-prev' => 'border: 1px solid {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_icon_color',
            [
                'label' => esc_html__( 'Navigation Arrow Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-next:before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-prev:before' => 'color: {{VALUE}};',

                ],                
            ]
        );


         $this->add_control(
            'navigation_arrow_hover_background',
            [
                'label' => esc_html__( 'Navigation Arrow Hover Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}  .rs-blog-slider .rs-addon-slider .slick-prev:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}}  .rs-blog-slider .rs-addon-slider .slick-next:hover' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_hover_border',
            [
                'label' => esc_html__( 'Navigation Arrow Border', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-next:hover,
                    {{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-prev:hover' => 'border: 1px solid {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_hover_icon_color',
            [
                'label' => esc_html__( 'Navigation Arrow Hover Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-next:hover::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-blog-slider .rs-addon-slider .slick-prev:hover::before' => 'color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_dot_border_color',
            [
                'label' => esc_html__( 'Navigation Dot Icon Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li button' => 'border-color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_dot_icon_background',
            [
                'label' => esc_html__( 'Navigation Dot Icon Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li button:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li.slick-active button' => 'background: {{VALUE}};',

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
                    '{{WRAPPER}} .btn-btm .rs-view-btn .rs-btns' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'btn_typography',
                'selector' => '{{WRAPPER}} .btn-btm .rs-view-btn .rs-btns',
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
                    '{{WRAPPER}} .btn-btm .rs-view-btn .rs-btns' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
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
                    '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm a.rs-btns' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm a.rs-btns:hover,
                    {{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm:hover a.rs-btns:after,
                    {{WRAPPER}} .rsaddon-unique-slider .blog-item .blog-content .btn-btm a.rs-btns:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
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

        $slidesToShow    = !empty($settings['col_lg']) ? $settings['col_lg'] : 3;
        $autoplaySpeed   = $settings['slider_autoplay_speed'];
        $interval        = $settings['slider_interval'];
        $slidesToScroll  = $settings['slides_ToScroll'];
        $slider_autoplay = $settings['slider_autoplay'] === 'true' ? 'true' : 'false';
        $pauseOnHover    = $settings['slider_stop_on_hover'] === 'true' ? 'true' : 'false';
        $sliderDots      = $settings['slider_dots'] == 'true' ? 'true' : 'false';
        $sliderNav       = $settings['slider_nav'] == 'true' ? 'true' : 'false';        
        $infinite        = $settings['slider_loop'] === 'true' ? 'true' : 'false';
        $centerMode      = $settings['slider_centerMode'] === 'true' ? 'true' : 'false';
        $col_lg          = $settings['col_lg'];
        $col_md          = $settings['col_md'];
        $col_sm          = $settings['col_sm'];
        $col_xs          = $settings['col_xs'];
       
        $unique = rand(100,31120);

        $slider_conf = compact('slidesToShow', 'autoplaySpeed', 'interval', 'slidesToScroll', 'slider_autoplay','pauseOnHover', 'sliderDots', 'sliderNav', 'infinite', 'centerMode', 'col_lg', 'col_md', 'col_sm', 'col_xs');

        if($centerMode == 'true'){
            $center = 'centermode';
        }else{
            $center = '';
        }
        ?>
            <div class="rsaddon-unique-slider rs-blog-grid rs-blog-slider blog-grid <?php echo esc_attr($center);?>">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php 
                        $cat = $settings['category'];     
                        $i = 1;

                        if(empty($cat)){
                            $best_wp = new wp_Query(array(
                                    'post_type'      => 'post',
                                    'posts_per_page' => $settings['per_page'],              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                                    'post_type'      => 'post',
                                    'posts_per_page' => $settings['per_page'],
                                    'tax_query'      => array(
                                        array(
                                            'taxonomy' => 'category',
                                            'field'    => 'slug', 
                                            'terms'    => $cat 
                                        ),
                                    )
                            ));   
                        }
                      
                        
                        while($best_wp->have_posts()): $best_wp->the_post(); 

                        $full_date      = get_the_date();
                        $blog_date      = get_the_date('d M y');    
                        $post_admin     = get_the_author();

                        
                        if(!empty($settings['blog_word_show'])){
                            $limit = $settings['blog_word_show'];
                        }
                        else{
                            $limit = 20;
                        }
                        ?>                       
                        
                            <div class="blog-item <?php echo esc_html($settings['blog_content_postion_style']);?> blog_meta_<?php echo esc_html($settings['blog_meta_style']);?>">
                                <?php if(($settings['blog_meta_style'] == 'style3') ){ ?>
                                    <div class="container">
                                        <div class="blog-inner-wrap rs-blog-slider3 row equal-spc">
                                        <?php $custom_featured = get_post_meta(get_the_ID(), 'custom_featured_image', true); ?>
                                        
                                        <div class="blog-content col-sm-6">  
                                            <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                                    <div class="cat_list">
                                                    <ul class="post-categories">
                                                    <?php $categories          = get_the_category();

                                                     foreach ($categories as $cat ) { 

                                                     $term_color = get_term_meta($cat->cat_ID, 'cat_color', true );
                                                     $term_style = !empty( $term_color ) ? 'style = "color:'.$term_color.'"': ''; ?>
                                                    <li>
                                                        <?php if($settings['blog_multi_color'] == 'multi_style') : ?>
                                                        <a <?php echo $term_style; ?> href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a>
                                                        <?php else: ?>   <a  href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a> <?php endif; ?>
                                                    </li> 
                                                    <?php   } ?>
                                                  </ul>
                                                </div>
                                                <?php } ?>                                      

                                            <h3 class="blog-name 1"><a class="pointer-events" href="<?php the_permalink();?>"><?php the_title();?></a></h3>

                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>                                        
                                                <div class="blog-meta">                                                    
                                                    <?php if(!empty($post_admin)){ ?>
                                                    <span class="admin"><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></span>
                                                    <?php } ?>

                                                    <?php if(!empty($full_date)){ ?>
                                                    <span class="date"><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></span>
                                                    <?php } ?>                                                   
                                                </div>
                                            <?php } ?>

                                            <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                                <p><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                            <?php } ?>

                                            <?php if(($settings['blog_readmore_show_hide'] == 'yes') ){ ?>
                                                <?php if(!empty($settings['blog_btn_text'])){ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">     
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                              <?php  }
                                            } ?>
                                        </div>

                                        <div class="image-wrap col-sm-6">
                                            <?php if($custom_featured !=''){ ?>
                                            <a class="pointer-events" href="<?php the_permalink();?>">
                                                <img src="<?php echo esc_url($custom_featured); ?>" alt="">
                                            </a>
                                            
                                            <?php } else { ?>
                                                <a class="pointer-events" href="<?php the_permalink();?>">
                                                    <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                                                </a> 
                                            <?php } ?>                                            
                                        </div> 
                                        <span class="counts"><?php echo esc_attr($i); ?></span>
                                            
                                        <?php $i++ ?>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="blog-inner-wrap">
                                        <div class="image-wrap">
                                            <a class="pointer-events" href="<?php the_permalink();?>">
                                                <?php the_post_thumbnail($settings['thumbnail_size']); ?>
                                            </a>
                                            <?php if( "tops" == $settings['d_cates_position'] ){ ?>
                                             <div class="cat_list">
                                                <ul class="post-categories">
                                                <?php $categories          = get_the_category();

                                                 foreach ($categories as $cat ) { 

                                                 $term_color = get_term_meta($cat->cat_ID, 'cat_color', true );
                                                 $term_style = !empty( $term_color ) ? 'style = "color:'.$term_color.'"': '';?>
                                                <li>
                                                    <?php if($settings['blog_multi_color'] == 'multi_style') : ?>
                                                    <a <?php echo $term_style; ?> href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a>
                                                    <?php else: ?>   <a  href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a> <?php endif; ?>
                                                </li> 
                                                <?php   } ?>
                                              </ul>
                                            </div>
                                            <?php } ?>
                                        </div> 

                                        <?php if(($settings['blog_meta_style'] == 'style2') ){ ?> 
                                        <div class="blog-content">

                                            <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                                <div class="cat_list">
                                                    <ul class="post-categories">
                                                    <?php $categories          = get_the_category();

                                                    foreach ($categories as $cat ) {

                                                    $term_color = get_term_meta($cat->cat_ID, 'cat_color', true );
                                                    $term_style = !empty( $term_color ) ? 'style = "color:'.$term_color.'"': ''; ?>
                                                    <li>
                                                        <?php if($settings['blog_multi_color'] == 'multi_style') : ?>
                                                        <a <?php echo $term_style; ?> href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a>
                                                        <?php else: ?>  <a  href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a> <?php endif; ?>
                                                    </li> 
                                                    <?php   } ?>
                                                  </ul>
                                                </div>
                                            <?php } ?>

                                            <h3 class="blog-name">
                                                <a class="pointer-events" href="<?php the_permalink();?>"><?php the_title();?>
                                                </a>
                                            </h3>

                                            <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                                <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                            <?php } ?>

                                            <div class="btn-btm">
                                            
                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>
                                                
                                                <div class="blog-meta">

                                                    <?php foreach ($categories as $cat ) { 

                                                    $term_color = get_term_meta($cat->cat_ID, 'cat_color', true );
                                                    $term_style = !empty( $term_color ) ? 'style = "color:'.$term_color.'"': '';
                                                    ?>

                                                    <?php if($settings['blog_multi_color'] == 'multi_style') { ?>
                                                        <?php if(!empty($post_admin)){ ?>
                                                        <span class="admin"><i <?php echo $term_style; ?> class="far fa-user"></i> <?php echo esc_html($post_admin);?></span>
                                                        <?php } ?>

                                                        <?php if(!empty($full_date)){ ?>
                                                        <span class="date"><i <?php echo $term_style; ?> class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></span>
                                                        <?php } ?>  
                                                    <?php } else { if(!empty($post_admin)){ ?>
                                                        <span class="admin"><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></span>
                                                        <?php } ?>

                                                        <?php if(!empty($full_date)){ ?>
                                                        <span class="date"><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></span>
                                                        <?php } } ?>  
                                                    <?php } ?>                                                 
                                                </div>
                                            <?php } ?>

                                            <?php if(($settings['blog_readmore_show_hide'] == 'yes') ){ ?>
                                                <?php if(!empty($settings['blog_btn_text'])){ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                              <?php  }
                                            } ?>
                                            </div>
                                        </div>
                                        <?php } ?>

                                        <?php if(($settings['blog_meta_style'] == 'style1') ){ ?> 
                                        <div class="blog-content">
                                            <?php if(($settings['blog_meta_show_hide'] == 'yes') ){ ?>                                                
                                                <div class="blog-meta">
                                                    <?php if(!empty($full_date)){ ?>
                                                    <span class="date"><i class="fa fa-calendar-check-o"></i> <?php echo esc_html($full_date);?></span>
                                                    <?php } ?> 
                                                    <?php if(($settings['admin_show_hide'] == 'yes') ){ ?>  
                                                    <?php if(!empty($post_admin)){ ?>
                                                    <span class="admin"><i class="far fa-user"></i> <?php echo esc_html($post_admin);?></span>
                                                    <?php } ?>                                                                                                
                                                    <?php } ?>                                                                                                
                                                </div>
                                            <?php } ?>
                                            

                                            <h3 class="blog-name">
                                                <a class="pointer-events" href="<?php the_permalink();?>"><?php the_title();?>
                                                </a>
                                            </h3>

                                            <?php if(($settings['blog_content_show_hide'] == 'yes') ){ ?>
                                                <p class="txt"><?php echo wp_trim_words( get_the_content(), $limit, '...' ); ?></p>
                                            <?php } ?>

                                            <div class="btn-btm">                                            
                                            <?php if(($settings['blog_cat_show_hide'] == 'yes') ){ ?>
                                                <?php if( "tops" != $settings['d_cates_position'] ){ ?>
                                                 <div class="cat_list">
                                                    <ul class="post-categories">
                                                    <?php $categories          = get_the_category();

                                                     foreach ($categories as $cat ) { 

                                                     $term_color = get_term_meta($cat->cat_ID, 'cat_color', true );
                                                     $term_style = !empty( $term_color ) ? 'style = "color:'.$term_color.'"': '';
?>
                                                    <li>
                                                        <?php if($settings['blog_multi_color'] == 'multi_style') : ?>
                                                        <a <?php echo $term_style; ?> href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a>
                                                        <?php else: ?>   <a  href="<?php echo get_category_link($cat->cat_ID);?>"><?php echo $cat->cat_name;?></a> <?php endif; ?>
                                                    </li> 
                                                    <?php   } ?>
                                                  </ul>
                                                </div>
                                            <?php } ?>
                                            <?php } ?>

                                            <?php if(($settings['blog_readmore_show_hide'] == 'yes') ){ ?>
                                                <?php if(!empty($settings['blog_btn_text'])){ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                                <?php }else{ ?>
                                                    <div class="rs-view-btn">
                                                        <a class="rs-btns" href="<?php the_permalink(); ?>">
                                                            <?php echo esc_html($settings['blog_btn_text']);?>
                                                        </a>
                                                    </div>
                                              <?php  }
                                            } ?>
                                            </div>
                                        </div>
                                        <?php } ?>



                                    </div>
                                <?php } ?>
                            </div>
                    
                        <?php
                        endwhile;
                        wp_reset_query();  ?>
                
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <script type="text/javascript"> 
            jQuery(document).ready(function(){
            jQuery( '.rs-addon-slider' ).each(function( index ) {        
            var slider_id       = jQuery(this).attr('id'); 
            var slider_conf     = jQuery.parseJSON( jQuery(this).closest('.rsaddon-unique-slider').find('.rsaddon-slider-conf').attr('data-conf'));
           
            if( typeof(slider_id) != 'undefined' && slider_id != '' ) {
            jQuery('#'+slider_id).not('.slick-initialized').slick({
            slidesToShow    : parseInt(slider_conf.col_lg),
            centerMode      : (slider_conf.centerMode)  == "true" ? true : false,
            dots            : (slider_conf.sliderDots)  == "true" ? true : false,
            arrows          : (slider_conf.sliderNav) == "true" ? true : false,
            autoplay        : (slider_conf.slider_autoplay) == "true" ? true : false,
            slidesToScroll  : parseInt(slider_conf.slidesToScroll),
            centerPadding   : '15px',
            autoplaySpeed   : parseInt(slider_conf.autoplaySpeed),
            pauseOnHover    : (slider_conf.pauseOnHover) == "true" ? true : false,
            loop : false,
            responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: parseInt(slider_conf.col_md),
                }
            }, 
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: parseInt(slider_conf.col_sm),
                }
            }, 
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: parseInt(slider_conf.col_xs),
                }
            }, ]
            });
        }
       
        });
    });
    </script>
        <?php

    }
}?>