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
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Background;
use Elementor\Utils;

defined( 'ABSPATH' ) || die();

class Rsaddon_Pro_Testimonial_Slider_Widget extends \Elementor\Widget_Base {

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
        return 'rs-testimonial-slider';
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
        return esc_html__( 'RS Testimonial Slider', 'rsaddon' );
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
        return 'glyph-icon flaticon-slider-2';
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
                'label' => esc_html__( 'Content', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        ); 

        $this->add_control(
            'testimonial_slider_style',
            [
                'label'   => esc_html__( 'Select Style', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '1',               
                'options' => [
                    'default' => 'Default',
                    '1' => 'Style 1',
                    '2' => 'Style 2',           
                    '3' => 'Style 3',           
                    '4' => 'Style 4',           
                    '5' => 'Style 5',           
                ],                                          
            ]
        );               

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__( 'Testimonial Show Per Page', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__( '5', 'rsaddon' ),
                'separator' => 'before',
            ]
        );   
        
        $this->add_control(
            'testimonial_category',
            [
                'label'   => esc_html__( 'Category', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT2,
                
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
            'align',
            [
                'label' => esc_html__( 'Alignment', 'rsaddon' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
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
                   
                ],
                'toggle' => false,
                'default' => 'left',
                'prefix_class' => 'rs-testimonial--',
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial' => 'text-align: {{VALUE}}'
                ]
               
            ]
        );

        $this->add_control(
            '_design',
            [
                'label' => esc_html__( 'Design', 'rsaddon' ),
                'type'  => Controls_Manager::SELECT,
                'label_block' => false,
                'options' => [
                    'basic'  => esc_html__( 'Default', 'rsaddon' ),
                    'bubble' => esc_html__( 'Bubble', 'rsaddon' ),
                ],
                'default' => 'bubble',
                
            ]
        );


        $this->add_responsive_control(
            'bubble_position',
            [
                'label' => esc_html__( 'Bubble Position', 'rsaddon' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial .testimonial-item .item-content.bubble:after' => 'left: {{SIZE}}%;',                    
                    '{{WRAPPER}} .rs-testimonial--center .item-content.bubble:after'           => 'left: {{SIZE}}%;',                    
                    '{{WRAPPER}} .rs-testimonial--right .item-content.bubble:after'            => 'left: {{SIZE}}%;',                    
                ],

                'condition' => [
                    '_design' => 'bubble'
                ]
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
            '_section_ratings',
            [
                'label' => esc_html__( 'Ratings', 'rsaddon' ),
                'condition' => [
                    'testimonial_slider_style' => '2',
                ],
            ]
        );

        $this->add_control(
            'show_ratings',
            [
                'label'        => esc_html__( 'Show', 'rsaddon' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'rsaddon' ),
                'label_off'    => esc_html__( 'Hide', 'rsaddon' ),
                'return_value' => 'yes',
                'default'      => 'no',
            ]
        );

        $this->add_responsive_control(
            'rating_bottom_position',
            [
                'label'      => esc_html__( 'Bottom Gap', 'rsaddon' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                
                'selectors' => [
                    '{{WRAPPER}} .ratings' => 'padding-bottom: {{SIZE}}{{UNIT}};',                    
                ],

                'condition' => [
                    'show_ratings' => 'yes'
                ]
            ]
        );     
       

        $this->end_controls_section();

         $this->start_controls_section(
            'content_slider',
            [
                'label' => esc_html__( 'Slider Settings', 'rsaddon' ),
                'tab'   => Controls_Manager::TAB_CONTENT,               
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

        $this->add_responsive_control(
            'slider_nav_position',
            [
                'label'   => esc_html__( 'Navigation Nav', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 5,
                    ], 
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],                  
                ],                

                'default' => [
                    'size' => -74
                ],
                'condition' => [
                    'slider_nav' =>'true',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial .slick-slider .slick-arrow' => 'top: {{SIZE}}{{UNIT}};',
                   
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

        $this->add_control(
            'item_gap_custom',
            [
                'label' => esc_html__( 'Item Middle Gap', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],          

                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .testimonial-item' => 'margin-left:{{SIZE}}{{UNIT}};',     
                    '{{WRAPPER}} .rs-addon-slider .testimonial-item' => 'margin-right:{{SIZE}}{{UNIT}};',                    
                ],
            ]
        ); 

         $this->add_control(
            'item_gap_custom_bottom',
            [
                'label' => esc_html__( 'Item Bottom Gap', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 15,
                ],          

                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .testimonial-item' => 'margin-bottom:{{SIZE}}{{UNIT}};',                    
                ],
            ]
        ); 
                
        $this->end_controls_section();
        
       

        $this->start_controls_section(
           'quote_setting',
            [
               'label' => esc_html__( 'Quote Icon Settings', 'rsaddon' ),
               'tab'   => Controls_Manager::TAB_CONTENT, 
            ]
        );

        $this->add_control(
            'icon_type',
            [
                'label'   => esc_html__( 'Select Icon Type', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'icon',            
                'options' => [                  
                    'icon' => esc_html__( 'Icon', 'rsaddon'),
                    'image' => esc_html__( 'Image', 'rsaddon'),
                                
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'icons',
            [
                'label' => esc_html__( 'Quote Icon', 'rsaddon' ),
                'type' => Controls_Manager::ICON,
                'default' => '',   
                'condition' => [
                    'icon_type' => 'icon',
                ],             
            ]
        );

        $this->add_control(
            'icons_image',
            [
                'label' => esc_html__( 'Choose Image', 'rsaddon' ),
                'type'  => Controls_Manager::MEDIA,             
                
                'condition' => [
                    'icon_type' => 'image',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'icon_images_width',
            [
                'label' => esc_html__( 'Image Width', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .item-content img.quote-positions' => 'width: {{SIZE}}px;',
                ],
                'condition' => [
                    'icon_type' => 'image',
                ],
            ]
        );

        $this->add_responsive_control(
            'icons_dd_padding',
            [
                'label' => esc_html__( 'Padding', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .item-content span i' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .item-content img.quote-positions' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'icon_position',
            [
                'label' => esc_html__( 'Icon Top ( Top/Bottom Position )', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:before' => 'top: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                    '{{WRAPPER}} .item-content span i'                                       => 'top: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                    '{{WRAPPER}} .item-content span i'                                       => 'top: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                    '{{WRAPPER}} .item-content img.quote-positions'                          => 'top: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                ],
                
            ]
        );

        $this->add_responsive_control(
            'icon_position_left',
            [
                'label' => esc_html__( 'Icon Top ( Left/Right Position )', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:before' => 'left: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                    '{{WRAPPER}} .item-content span i'                                       => 'left: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                    '{{WRAPPER}} .item-content img.quote-positions'                          => 'left: {{SIZE}}{{UNIT}}; position:absolute; z-index: 1',
                ],
                
            ]
        );

        $this->end_controls_section();
        

        $this->start_controls_section(
            'section_slider_style',
            [
                'label' => esc_html__( 'Title/Designation/Description', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

         

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__( 'Title Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                '{{WRAPPER}} .rs-testimonil_style5 .content-innner h4' => 'color: {{VALUE}};',                 
                '{{WRAPPER}} .testi-item .content-part .name' => 'color: {{VALUE}};',                 
                '{{WRAPPER}} .testi-item .desc .name' => 'color: {{VALUE}};', 
                '{{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .name' => 'color: {{VALUE}};', 
                '{{WRAPPER}} .testimonial-item .testimonial-content .testimonial-name' => 'color: {{VALUE}};',     
                '{{WRAPPER}} .rs-testimonial-default .testimonial-item .testimonial-information .testimonial-name' => 'color: {{VALUE}};',     
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
                       '{{WRAPPER}} .rs-testimonil_style5 .content-innner h4, {{WRAPPER}} .rs-testimonial-slider2 .testi-item .desc .name, {{WRAPPER}} .testi-item .content-part .name, .testi-item .desc .name, {{WRAPPER}} .testimonial-item .name, .testimonial-item .testimonial-content .testimonial-name, {{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part .name, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .name, {{WRAPPER}} .rs-testimonial-default .testimonial-item .testimonial-information .testimonial-name',
                    
            ]
        );

      
     

        $this->add_control(
            'designation_color',
            [
                'label' => esc_html__( 'Designation Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [                  
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .testi-item .designatin' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .testi-item .designation' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .testimonial-item .designation' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .testimonial-item .testimonial-title' => 'color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'designation_typography',
                'label' => esc_html__( 'Designation Typography', 'rsaddon' ),
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => 
                       '{{WRAPPER}} .rs-testimonil_style5 .content-innner span, {{WRAPPER}} .testi-item .desc .designation, .testi-item .designatin, {{WRAPPER}} .testi-item .designation,  {{WRAPPER}} .testimonial-item .designation, {{WRAPPER}} .testimonial-item .testimonial-title',                 
            ]
        );
        $this->add_control(
            'des_color',
            [
                'label' => esc_html__( 'Description Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [  
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner p' => 'color: {{VALUE}};',      
                    '{{WRAPPER}} .testimonial-item .item-content p' => 'color: {{VALUE}};',      
                    '{{WRAPPER}} .testi-item p' => 'color: {{VALUE}};',                  
                    '{{WRAPPER}} .rs-testimonial-slider2 .testi-item .desc' => 'color: {{VALUE}};', 
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
                       '{{WRAPPER}} .rs-testimonil_style5 .content-innner p, {{WRAPPER}} .testimonial-item .item-content p, .rs-testimonial-slider1 .testi-item .content-part p, {{WRAPPER}} .testi-item p, .rs-testimonial-slider2 .testi-item .desc',                   
            ]
        );
        $this->add_control(
            'title_position',
            [
                'label'   => esc_html__( 'Title/Ratings/Image ', 'rsaddon' ),
                'type'    => Controls_Manager::SELECT,  
                'default' => 'bottom',            
                'options' => [
                    'top' => esc_html__( 'Above Content', 'rsaddon' ),
                    'bottom' => esc_html__( 'Below Content', 'rsaddon' ),                                  
                ],
                'separator' => 'before',                            
            ]
        ); 

        $this->end_controls_section();
        
        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__( 'Testimonial Content', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'img_border_radius',
            [
                'label' => esc_html__( 'Image Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [ 
                    '{{WRAPPER}} .rs-testimonial-slider2 .testi-item .user-info > img, 
                     {{WRAPPER}} .rs-testimonial-slider4 .user-info img, 
                     {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .author-info .user-info > img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'testi_images_width',
            [
                'label' => esc_html__( 'Image Width', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider3 .testi-item > img, {{WRAPPER}} .rs-testimonial-slider2 .testi-item .user-info > img, {{WRAPPER}} .rs-testimonial-slider4 .user-info img' => 'width: {{SIZE}}px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_padding',
            [
                'label' => esc_html__( 'Content Padding', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner p, {{WRAPPER}} .testimonial-item p' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
       
        $this->add_control(
            'testimonial_bg_color',
            [
                'label' => esc_html__( 'Content Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner, {{WRAPPER}} .rs-testimonial-slider1 .testi-item, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .desc, {{WRAPPER}} .rs-testimonial .testimonial-item p' => 'background-color:{{VALUE}};',
                        '{{WRAPPER}} .rs-testimonial .testimonial-item .item-content.bubble:after' => 'border-top-color:{{VALUE}};',
                ],
            ]
        ); 
       
        $this->add_control(
            'testimonial_show_bg_color',
            [
                'label' => esc_html__( 'Content Show Background  Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'testimonial_slider_style' =>'4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .desc:before' => 'background-color:{{VALUE}};',
                ],
            ]
        );      

        $this->add_responsive_control(
            'testimonial_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item, {{WRAPPER}} .rs-testimonial .testimonial-item p, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .desc' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_box_shadow',
                'selector' => '{{WRAPPER}} .rs-testimonial .testimonial-item p',
            ]
        );

        $this->add_responsive_control(
            'name_spacing',
            [
                'label' => esc_html__( 'Content Bottom Spacing', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-item p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            '_section_style_image',
            [
                'label' => esc_html__( 'Image', 'rsaddon' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

         $this->add_control(
            'show_images',
            [
                'label' => esc_html__( 'Show', 'rsaddon' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'rsaddon' ),
                'label_off' => esc_html__( 'Hide', 'rsaddon' ),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_images_onlys',
            [
                'label' => esc_html__( 'Show Top (Only Image)', 'rsaddon' ),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__( 'Show', 'rsaddon' ),
                'label_off' => esc_html__( 'Hide', 'rsaddon' ),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );


        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__( 'Width', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 65,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-wrap img' => 'width: {{SIZE}}{{UNIT}};',                    
                ],

                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__( 'Height', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-wrap img' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .image-wrap > img',
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]

        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .image-wrap > img, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item .author-info .user-info > img, {{WRAPPER}} .rs-testimonial-slider1 .testi-item .img-part img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '.image-wrap > img',
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );


        $this->add_responsive_control(
            'title_top_position',
            [
                'label' => esc_html__( 'Top/Bottom Position', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 300,
                    ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'title_left_position',
            [
                'label' => esc_html__( 'Left/Right Position', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_images' => 'yes'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_quote_style',
            [
                'label' => esc_html__( 'Quote Icon Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:before' => 'color: {{VALUE}};', 
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .item-content span i' => 'color: {{VALUE}};',             

                ],                
            ]
        );


        $this->add_responsive_control(
            'icon_font_size',
            [
                'label' => esc_html__( 'Icon Font Size', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:before' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:after' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .item-content span i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                
            ]
        );

        $this->add_responsive_control(
            'icon_position_right',
            [
                'label' => esc_html__( 'Icon Bottom ( Top/Bottom Position )', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    'testimonial_slider_style' =>[ '1' ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:after' => 'top: {{SIZE}}{{UNIT}}; position:absolute',
                    '{{WRAPPER}} .item-content span i' => 'top: {{SIZE}}{{UNIT}}; position:absolute',
                    '{{WRAPPER}} .item-content span i' => 'top: {{SIZE}}{{UNIT}}; position:absolute',
                ],
                
            ]
        );

        $this->add_responsive_control(
            'icon_position_left_right',
            [
                'label' => esc_html__( 'Icon Bottom ( Left/Right Position )', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ '%' ],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                   
                ],
                'condition' => [
                    'testimonial_slider_style' =>[ '1' ],
                ],
               
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider1 .testi-item .content-part p:after' => 'left: {{SIZE}}%; position:absolute',
                    '{{WRAPPER}} .item-content span i' => 'left: {{SIZE}}%; position:absolute',
                ],
                
            ]
        );

        $this->end_controls_section();



        $this->start_controls_section(
            'section_boxes_style',
            [
                'label' => esc_html__( 'Testimonial Box Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


         $this->add_responsive_control(
            'box_padding',
            [
                'label' => esc_html__( 'Padding', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonil_style5 .content-innner, {{WRAPPER}} .rs-testimonial-slider4 .testimonial-item, {{WRAPPER}} .rs-testimonial .testimonial-item, {{WRAPPER}} .rs-testimonial-slider2 .testi-item, {{WRAPPER}} .rs-testimonial-slider3 .testi-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'box_margin',
            [
                'label' => esc_html__( 'Margin', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider4 .testimonial-item, {{WRAPPER}} .rs-testimonial .testimonial-item, {{WRAPPER}} .rs-testimonial-slider2 .testi-item, {{WRAPPER}} .rs-testimonial-slider3 .testi-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

 
        $this->add_control(
            'box_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial-slider4 .testimonial-item, {{WRAPPER}} .rs-testimonial .testimonial-item, {{WRAPPER}} .rs-testimonial-slider2 .testi-item, {{WRAPPER}} .rs-testimonial-slider3 .testi-item' => 'background-color: {{VALUE}};',                    
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_box_shadow_items',
                'selector' => '{{WRAPPER}} .rs-testimonial .testimonial-item',
            ]
        );  

        $this->add_control(
            'icon_image',
            [
                'label' => esc_html__( 'Choose Background Image', 'rsaddon' ),
                'type'  => Controls_Manager::MEDIA,  
                'condition' => [
                    'testimonial_slider_style' =>[ '2', '3' ],
                ],
                'separator' => 'before',
            ]
        );  

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'box_border',
                'condition' => [
                    'testimonial_slider_style' =>[ '1', '2' ],
                ],
                'selector' => '{{WRAPPER}} .rs-testimonial .testimonial-item, .rs-testimonial-slider2 .testi-item',
            ]
        );    

        $this->add_responsive_control(
            'box_border_radius',
            [
                'label' => esc_html__( 'Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'condition' => [
                    'testimonial_slider_style' =>[ '1', '3' ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-testimonial .testimonial-item, {{WRAPPER}} .rs-testimonial-slider2 .testi-item, {{WRAPPER}} .rs-testimonial-slider3 .testi-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

   
        $this->end_controls_section();

        $this->start_controls_section(
            'slider_styled',
            [
                'label' => esc_html__( 'Slider Arrow & Dots Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'd_navigation_arrow_color',
            [
                'label' => esc_html__( 'Arrow Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-slider .slick-arrow::before' => 'background-color: {{VALUE}};',

                ],                
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'd_navigation_shadow_arrow_color',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .slick-slider .slick-arrow::before'
            ]
        );

        $this->add_control(
            'navigation_arrow_icon_colord',
            [
                'label' => esc_html__( 'Navigation Arrow Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-next::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-prev::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .slick-slider .slick-prev:after' => 'background-color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_dot_border_colord',
            [
                'label' => esc_html__( 'Navigation Dot Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slick-slider .slick-dots li button' => 'background-color: {{VALUE}};',

                ],                
            ]
        );

        $this->add_responsive_control(
            'slider_dots_postions',
            [
                'label' => esc_html__( 'Dots Position Vertical', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'bottom: {{SIZE}}px;',                   
                ],
                'condition' => [
                    'slider_dots' => 'true'
                ],
                
            ]
        );

        $this->add_responsive_control(
            'slider_dots_postiond',
            [
                'label' => esc_html__( 'Dots Position Horizontal', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                    ],
                ],
                'condition' => [
                    'slider_dots' => 'true'
                ],
                'selectors' => [
                    '{{WRAPPER}} .slick-dots' => 'left: {{SIZE}}px;',                   
                ],
            ]
        );


        $this->add_control(
            'navigation_dot_icon_backgroundd',
            [
                'label' => esc_html__( 'Navigation Dot Active Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li button:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li.slick-active button' => 'background: {{VALUE}};',

                ],                
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_slider_style_arrow',
            [
                'label' => esc_html__( 'Slider Style', 'rsaddon' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'testimonial_style' => 'slider'
                ],

            ]
        );     
       
      
        $this->add_control(
            'arrow_options',
            [
                'label' => esc_html__( 'Arrow Style', 'rsaddon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'navigation_arrow_background',
            [
                'label' => esc_html__( 'Background', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-next, .rs-addon-slider .slick-prev' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-next, .rs-addon-slider .slick-next' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'navigation_arrow_icon_color',
            [
                'label' => esc_html__( 'Icon Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-next::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-prev::before' => 'color: {{VALUE}};',

                ],                
            ]
        );

         $this->add_control(
            'bullet_options',
            [
                'label' => esc_html__( 'Bullet Style', 'rsaddon' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'navigation_dot_border_color',
            [
                'label' => esc_html__( 'Border Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li button' => 'border-color: {{VALUE}};',

                ],                
            ]
        );



        $this->add_control(
            'navigation_dot_icon_background',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li button:hover' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .rs-addon-slider .slick-dots li.slick-active button' => 'background: {{VALUE}};',

                ],                
            ]
        );

        $this->add_control(
            'bullet_spacing_custom',
            [
                'label' => esc_html__( 'Top Gap', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'show_label' => true,               
                'range' => [
                    'px' => [
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 25,
                ],          

                'selectors' => [
                    '{{WRAPPER}} .rs-addon-slider .slick-dots' => 'margin-bottom:-{{SIZE}}{{UNIT}};',                    
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
        
        $unique = rand(2012,35120);

        $slider_conf = compact('slidesToShow', 'autoplaySpeed', 'interval', 'slidesToScroll', 'slider_autoplay','pauseOnHover', 'sliderDots', 'sliderNav', 'infinite', 'centerMode', 'col_lg', 'col_md', 'col_sm', 'col_xs');   

        ?>           

            <?php if('1' == $settings['testimonial_slider_style']){ ?>
            <div class="rsaddon-unique-slider rs-testimonial-slider1">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php
                        $url = plugin_dir_url( __FILE__ );
                        $cat = $settings['testimonial_category'];
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                         if(empty($cat)){
                        
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],                              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                               
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],              
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'testimonial-category',
                                        'field'    => 'slug', //can be set to ID
                                        'terms'    => $cat //if field is ID you can reference by cat/term number
                                    ),
                                )
                            ));   
                        }

                        while($best_wp->have_posts()): $best_wp->the_post();
                            $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';
                            $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';
                        ?>  
                        <div class="testimonial-item <?php echo esc_attr( $settings['align'] );?>">
                            <div class="testi-item">
                                <?php if(has_post_thumbnail()): ?>

                                    <div class="img-part">                  
                                        <?php the_post_thumbnail(); ?>                              
                                    </div>

                                <?php endif;?> 
                                <div class="content-part">
                                    <?php the_content(); ?>
                                    <?php if(get_the_title()):?>  
                                        <h3 class="name"><?php the_title();?></h3>          
                                        <?php endif;?>
                                    <?php if( $designation ):?>
                                        <span class="designatin"><?php echo esc_html( $designation );?></span>
                                    <?php endif; ?>
                                </div>
                            </div>                  
                        </div>
                        <?php   
                        endwhile;
                        wp_reset_query();  
                     ?>  
                    
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <?php } ?>

            <?php if('2' == $settings['testimonial_slider_style']){ ?>
            <div class="rsaddon-unique-slider rs-testimonial-slider2">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php
                        $url = plugin_dir_url( __FILE__ );

                        $cat = $settings['testimonial_category'];
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                         if(empty($cat)){  
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],                              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],              
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'testimonial-category',
                                        'field'    => 'slug', //can be set to ID
                                        'terms'    => $cat //if field is ID you can reference by cat/term number
                                    ),
                                )
                            ));   
                        }

                        
                        while($best_wp->have_posts()): $best_wp->the_post();
                            $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';

                            $url = plugin_dir_url( __FILE__ );
                            $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';


                             $testi_img = " ";

                            if(!empty($settings['icon_image']['url'])){
                                $testi_img         = ($settings['icon_image']['url']) ? 'style = "background-image: url('.$settings['icon_image']['url'].')"': '';
                            }

                        ?> 
                        <div class="testimonial-innner">
                        <div class="testi-item" <?php echo $testi_img; ?>>
                            <div class="row y-middle no-gutter">
                                <div class="col-lg-4 col-md-3">

                                    <?php if(has_post_thumbnail()): ?>
                                        <div class="user-info">
                                            <?php the_post_thumbnail( 'educavo_testimonial_image', '' ); ?> 
                                        </div>
                                    <?php endif;?> 
                                    
                                </div>
                                <div class="col-lg-8 col-md-9">
                                    <div class="desc">                                        
                                        <i class="fa <?php echo esc_html($settings['icons']);?>"></i> <?php the_content(); ?>
                                        <?php if(get_the_title()):?>  
                                            <h4 class="name"><?php the_title();?></h4>          
                                        <?php endif;?>
                                        <?php if( $designation ):?>
                                            <span class="designation"> <?php echo esc_html( $designation );?></span>
                                        <?php endif; ?>

                                        <?php if(($settings['show_ratings'] == 'yes') ){ ?>
                                            <ul class="ratings">
                                            <li>
                                                    
                                            <?php if($ratings==1 ||$ratings==1.5||$ratings==2||$ratings==2.5||$ratings==3||$ratings==3.5||$ratings==4 || $ratings==4.5 || $ratings==5){ ?>


                                            <img src="<?php echo $url; ?>/img/<?php echo $ratings; ?>.png" alt="Ratings">
                                        <?php } else{ ?>
                                            <img src="<?php echo $url; ?>/img/5.png" alt="Ratings">
                                        <?php } ?>
 

                                                </li>
                                            </ul>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <?php   
                        endwhile;
                        wp_reset_query();  
                     ?>  
                    
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <?php } ?>

            <?php if('3' == $settings['testimonial_slider_style']){ ?>
            <div class="rsaddon-unique-slider rs-testimonial-slider3">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php
                        $url = plugin_dir_url( __FILE__ );

                        $cat = $settings['testimonial_category'];
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                         if(empty($cat)){  
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],                              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],              
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'testimonial-category',
                                        'field'    => 'slug', //can be set to ID
                                        'terms'    => $cat //if field is ID you can reference by cat/term number
                                    ),
                                )
                            ));   
                        }

                        
                        while($best_wp->have_posts()): $best_wp->the_post();
                            $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';

                            $url = plugin_dir_url( __FILE__ );
                            $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';

                        ?> 
                        <div class="testimonial-innner">
                            <div class="testi-item">
                                <?php the_post_thumbnail(); ?> 
                            </div>
                        </div>
                        <?php   
                        endwhile;
                        wp_reset_query();  
                     ?>  
                    
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <?php } ?>

            <?php if('4' == $settings['testimonial_slider_style']){ ?>
            <div class="rsaddon-unique-slider rs-testimonial-slider4">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php
                        $url = plugin_dir_url( __FILE__ );
                        $cat = $settings['testimonial_category'];
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                         if(empty($cat)){  
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],                              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],              
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'testimonial-category',
                                        'field'    => 'slug', //can be set to ID
                                        'terms'    => $cat //if field is ID you can reference by cat/term number
                                    ),
                                )
                            ));   
                        }

                        
                        while($best_wp->have_posts()): $best_wp->the_post();
                            $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';

                            $url = plugin_dir_url( __FILE__ );
                            $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';


                             $testi_img = " ";

                            if(!empty($settings['icon_image']['url'])){
                                $testi_img         = ($settings['icon_image']['url']) ? 'style = "background-image: url('.$settings['icon_image']['url'].')"': '';
                            }

                        ?> 
                        <div class="testimonial-innner  text-<?php echo esc_attr( $settings['align'] );?>">
                            <div class="testimonial-item" <?php echo $testi_img; ?>>
                                <div class="desc">
                                    
                                    <?php if(!empty($settings['icons'])){ ?>
                                        <i class="<?php echo esc_html($settings['icons']);?>"></i> 
                                    <?php }?>
                                    <?php the_content(); ?>
                                </div>
                                <div class="author-info">    
                                    <div class="user-info">
                                        <?php the_post_thumbnail(); ?> 
                                    </div>
                                    <?php if(get_the_title()):?>  
                                        <h4 class="name"><?php the_title();?></h4>          
                                    <?php endif;?>
                                    <?php if( $designation ):?>
                                        <span class="designation"> <?php echo esc_html( $designation );?></span>
                                    <?php endif; ?>

                                    <?php if(($settings['show_ratings'] == 'yes') ){ ?>
                                        <ul class="ratings">
                                        <li>
                                                
                                        <?php if($ratings==1 ||$ratings==1.5||$ratings==2||$ratings==2.5||$ratings==3||$ratings==3.5||$ratings==4 || $ratings==4.5 || $ratings==5){ ?>


                                        <img src="<?php echo $url; ?>/img/<?php echo $ratings; ?>.png" alt="Ratings">
                                    <?php } else{ ?>
                                        <img src="<?php echo $url; ?>/img/5.png" alt="Ratings">
                                    <?php } ?>


                                            </li>
                                        </ul>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <?php   
                        endwhile;
                        wp_reset_query();  
                     ?>  
                    
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <?php } ?>

            <?php if('5' == $settings['testimonial_slider_style']):?>  
                <div class="rs-testimonil_style5">
                    <div class="row align-items-end">
                        <div div class="col-lg-5 p-0">
                            <div class="slider-nav">
                                <?php
                                    $url = plugin_dir_url( __FILE__ );
                                    $cat = $settings['testimonial_category'];
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                     if(empty($cat)){  
                                        $best_wp = new wp_Query(array(
                                            'post_type'      => 'testimonials',
                                            'posts_per_page' => $settings['per_page'],                              
                                        ));   
                                    }   
                                    else{
                                        $best_wp = new wp_Query(array(
                                            'post_type'      => 'testimonials',
                                            'posts_per_page' => $settings['per_page'],              
                                            'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'testimonial-category',
                                                    'field'    => 'slug', //can be set to ID
                                                    'terms'    => $cat //if field is ID you can reference by cat/term number
                                                ),
                                            )
                                        ));   
                                    }

                                    while($best_wp->have_posts()): $best_wp->the_post(); ?> 
                                        <?php if(has_post_thumbnail()): ?>
                                            <div class="user-info">
                                                <?php the_post_thumbnail( 'educavo_testimonial_small', '' ); ?> 
                                            </div>
                                        <?php endif;?> 
                                    <?php   
                                        endwhile;
                                        wp_reset_query(); 

                                    ?> 
                            </div>
                        </div>
                        <div div class="col-lg-7 p-0">
                            <div class="slider-part">
                                <?php
                                    $url = plugin_dir_url( __FILE__ );
                                    $cat = $settings['testimonial_category'];
                                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                                     if(empty($cat)){  
                                        $best_wp = new wp_Query(array(
                                            'post_type'      => 'testimonials',
                                            'posts_per_page' => $settings['per_page'],                              
                                        ));   
                                    }   
                                    else{
                                        $best_wp = new wp_Query(array(
                                            'post_type'      => 'testimonials',
                                            'posts_per_page' => $settings['per_page'],              
                                            'tax_query'      => array(
                                                array(
                                                    'taxonomy' => 'testimonial-category',
                                                    'field'    => 'slug', //can be set to ID
                                                    'terms'    => $cat //if field is ID you can reference by cat/term number
                                                ),
                                            )
                                        ));   
                                    }
                                    while($best_wp->have_posts()): $best_wp->the_post();
                                        $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';

                                        $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';
                                        
                                    ?>  

                                    <div class="item-content <?php echo esc_attr($settings['_design']);?>"> 
                                        <div div class="col-lg-12 p-0">
                                            <div class="row align-items-center">
                                                <div div class="col-lg-6">
                                                    <div class="image-wrap">                                    
                                                        <?php the_post_thumbnail( 'educavo_testimonial_large', '' ); ?>                               
                                                    </div>
                                                </div>
                                                <div div class="col-lg-6">
                                                    <div class="content-innner">
                                                        <?php if(!empty($settings['icons_image'])) {?>
                                                            <img class="quote-positions" src="<?php echo esc_url( $settings['icons_image']['url'] );?>" alt="image"/>
                                                        <?php } ?>
                                                        <?php if(!empty($settings['icons'])){
                                                            ?>
                                                            <span><i class="<?php echo esc_attr( $settings['icons'] ); ?>"></i></span>
                                                            <?php
                                                        }
                                                        the_content();
                                                        if(get_the_title()):?>  
                                                            <h4 class="name"><?php the_title();?></h4>          
                                                        <?php endif;?>
                                                        <?php if( $designation ):?>
                                                            <span class="designation"> <?php echo esc_html( $designation );?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>                           
                                        </div>                           
                                    </div>                           
                                      
                                    <?php   
                                    endwhile;
                                    wp_reset_query(); 

                                 ?>  
                            </div>
                        </div>

                    </div>
                </div>

            <?php endif; ?>


            <?php if('default' == $settings['testimonial_slider_style']){ ?>
            <div class="rsaddon-unique-slider rs-testimonial-grid rs-testimonial rs-testimonial-default">
                <div id="rsaddon-slick-slider-<?php echo esc_attr($unique); ?>" class="rs-addon-slider" >
                    <?php
                        $cat = $settings['testimonial_category'];                        
                        if(empty($cat)){                        
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],                              
                            ));   
                        }   
                        else{
                            $best_wp = new wp_Query(array(
                                'post_type'      => 'testimonials',
                                'posts_per_page' => $settings['per_page'],              
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'testimonial-category',
                                        'field'    => 'slug', //can be set to ID
                                        'terms'    => $cat //if field is ID you can reference by cat/term number
                                    ),
                                )
                            ));   
                        }

                        while($best_wp->have_posts()): $best_wp->the_post();
                            $designation  = !empty(get_post_meta( get_the_ID(), 'designation', true )) ? get_post_meta( get_the_ID(), 'designation', true ):'';

                            $ratings  = !empty(get_post_meta( get_the_ID(), 'ratings', true )) ? get_post_meta( get_the_ID(), 'ratings', true ):'';
                            
                        ?> 

                        <div class="testimonial-item <?php echo esc_attr( $settings['align'] );?>"> 

                                                               
                            <?php if(has_post_thumbnail() && $settings['show_images_onlys'] == 'yes' ): ?>
                                <div class="testimonial-contents">
                                    <div class="image-wrap">                                    
                                        <?php the_post_thumbnail($settings['thumbnail_size']); ?>                                         
                                    </div>
                                </div>
                            <?php endif;?>                               

                            <?php if('top' == $settings['title_position']) {?>                               
                                <div class="testimonial-content">                                   
                                    <?php if(has_post_thumbnail() && $settings['show_images'] == 'yes' ): ?>
                                        <div class="image-wrap">                                    
                                            <?php the_post_thumbnail($settings['thumbnail_size']); ?>                                         
                                        </div>
                                    <?php endif;?>  
                                    
                                    <div class="testimonial-information">
                                        <?php if($settings['show_ratings'] == 'yes' && $ratings != ''): ?>
                                            <div class="ratings"><img src="<?php echo esc_url($url); ?>/img/<?php echo esc_html($ratings); ?>.png" /></div>
                                        <?php endif;?> 
                                        <?php if(get_the_title()):?>                         
                                            <div class="testimonial-name"><?php the_title();?></div>
                                        <?php endif;?>
                                        <?php if( $designation ):?>
                                            <span class="testimonial-title"><?php echo esc_html( $designation );?></span>
                                        <?php endif; ?>
                                    </div>
                                   
                                </div>
                            <?php } ?>   

                            <div class="item-content <?php echo esc_attr($settings['_design']);?>"> 
                                <?php if(!empty($settings['icons_image'])) {?>
                                    <img class="quote-positions" src="<?php echo esc_url( $settings['icons_image']['url'] );?>" alt="image"/>
                                <?php } ?>
                                <?php if(!empty($settings['icons'])){
                                    ?>
                                    <span><i class="<?php echo esc_attr( $settings['icons'] ); ?>"></i></span>
                                    <?php
                                }
                                 the_content();
                                ?>  
                            </div>  

                            <?php if('bottom' == $settings['title_position']) {?>                               
                                <div class="testimonial-content">
                                    <?php if(has_post_thumbnail() && $settings['show_images_onlys'] != 'yes' ): ?>                                   
                                        <?php if(has_post_thumbnail() && $settings['show_images'] == 'yes' ): ?>
                                            <div class="image-wrap">                                    
                                                <?php the_post_thumbnail($settings['thumbnail_size']); ?>                                                   
                                            </div>
                                        <?php endif;?>  
                                    <?php endif;?>  
                                    
                                    <div class="testimonial-information">
                                        <?php if($settings['show_ratings'] == 'yes' && $ratings != ''): ?>
                                            <div class="ratings"><img src="<?php echo esc_url($url); ?>/img/<?php echo esc_html($ratings); ?>.png" /></div>
                                        <?php endif;?> 
                                        <?php if(get_the_title()):?>                         
                                            <div class="testimonial-name"><?php the_title();?></div>
                                        <?php endif;?>
                                        <?php if( $designation ):?>
                                            <span class="testimonial-title"><?php echo esc_html( $designation );?></span>
                                        <?php endif; ?>
                                    </div>
                                   
                                </div>
                            <?php }?>                       
                        </div>
                            
                        <?php   
                        endwhile;
                        wp_reset_query();  
                     ?>  
                    
                </div>
                <div class="rsaddon-slider-conf wpsisac-hide" data-conf="<?php echo htmlspecialchars(json_encode($slider_conf)); ?>"></div>
            </div>
            <?php } ?>

        
            <script type="text/javascript">


                <?php if('5' == $settings['testimonial_slider_style']){?>
                    jQuery(document).ready(function(){ 
                    var sliderfor = jQuery('.slider-part');
                        if(sliderfor.length){

                        jQuery('.slider-part').slick({
                            slidesToShow: 1,
                            slidesToScroll: 1,
                            arrows: false,
                            fade: true,
                            asNavFor: '.slider-nav'
                        });
                    }
                    var slidernav = jQuery('.slider-nav');
                        if(slidernav.length){
                        jQuery('.slider-nav').slick({
                            slidesToShow: 3,
                            asNavFor: '.slider-part',
                            dots: false,
                            focusOnSelect: true,
                            centerMode:false,
                            vertical: false,
                            responsive: [
                                {
                                  breakpoint: 768,
                                  settings: {
                                    slidesToShow: 2
                                  }
                                },
                                {
                                  breakpoint: 591,
                                  settings: {
                                    slidesToShow: 2
                                  }
                                }
                              ] 
                        });
                    }
                 });
                <?php } else { ?> 
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
                                arrows          : (slider_conf.sliderNav) == "true" ? true : false,
                            }
                        }, 
                        {
                            breakpoint: 992,
                            settings: {
                                slidesToShow: parseInt(slider_conf.col_sm),
                                arrows          : (slider_conf.sliderNav) == "true" ? true : false,
                            }
                        }, 
                        {
                            breakpoint: 768,
                            settings: {
                                arrows          : (slider_conf.sliderNav) == "true" ? true : false,
                                slidesToShow: parseInt(slider_conf.col_xs),
                            }
                        }, ]
                        });
                    }
           
                 });
                });
            <?php } ?>   
                
            </script>

            

               
        <?php        
        
    }

      public function getCategories(){
         $cat_list = [];
         if ( post_type_exists( 'testimonials' ) ) { 
          $terms = get_terms( array(
             'taxonomy'    => 'testimonial-category',
             'hide_empty'  => true            
         ) );
       
         foreach($terms as $post) {

          $cat_list[$post->slug]  = [$post->name];

         }
      }  
        return $cat_list;
     }
}?>