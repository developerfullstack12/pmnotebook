<?php
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) die(); // Exit if accessed directly

class Rsaddon_Elementor_Image_Comparison_Pro_Widget extends \Elementor\Widget_Base {

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
		return 'rs-image-comparision';
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
		return esc_html__( 'Image Comparision', 'rsaddon' );
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
			'image',
			[
				'label' => __( 'Image', 'rsaddon' )
			]
		);

	
		
		$this->add_control('before_image',
			[
				'label' => __( 'Before Image', 'rsaddon' ),
				'type' => Controls_Manager::MEDIA,
                
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'show_label' => true,
			]
		);

	

		$this->add_control(
			'image_head',
			[
				'label'     => __('', 'rsaddon'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control('after_image',
			[
				'label' => __( 'After Image', 'rsaddon' ),
				'type' => Controls_Manager::MEDIA,                
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				
				'show_label' => true,
			]
		);

		
		$this->add_control(
			'separator_text',
			[
				'label'     => __('', 'rsaddon'),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'text_before',
			[
				'label' => __( 'Before Text', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __( 'Enter text', 'rsaddon' ),
				'default' => __( 'BEFORE', 'rsaddon' ),
			]
		);

		$this->add_control(
			'text_after',
			[
				'label' => __( 'After Text', 'rsaddon' ),
				'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
				'placeholder' => __( 'Enter text', 'rsaddon' ),
				'default' => __( 'AFTER', 'rsaddon' ),
			]
		);

		$this->add_responsive_control(
			'comparision_boxes_height',
			[
				'label' => __( 'Image Comparision Height', 'rsaddon' ),
				'type' => Controls_Manager::SLIDER,
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 500,
				],

				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rs-image-comparision' => 'height: {{SIZE}}px !important;',
					
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'General', 'rsaddon' ),
				'tab'   => Controls_Manager::TAB_STYLE
			]
		);		

		
		$this->add_control(
			'slider_bg_color',
			[
				'label'     => __('Slider Control Color', 'rsaddon'),
				'type'      => Controls_Manager::COLOR,
				'type'  => Scheme_Color::get_type(),
				'selectors'    => [
					'{{WRAPPER}} div.drag div.draghandle' => 'background-color: {{VALUE}} !important'
				]
			]
		);

		$this->add_control(
			'slider_bg_width',
			[
				'label' => __( 'Slider Control Width', 'rsaddon' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 20,
				'min' => 0,
				'max' => 50,
				'step' => 1,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} div.drag div.draghandle' => 'width: {{SIZE}}px;',
					
				],
			]
		);

		$this->add_control(
			'separator_color',
			[
				'label'     => __('Separator Color', 'rsaddon'),
				'type'      => Controls_Manager::COLOR,
				'type'  => Scheme_Color::get_type(),
				'selectors'    => [
					'{{WRAPPER}} div.drag' => 'background-color: {{VALUE}}'
				]
			]
		);	

		$this->add_control(
			'slider_separator_width',
			[
				'label' => __( 'Separator Width', 'rsaddon' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 1,
				'min' => 0,
				'max' => 10,
				'step' => 1,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} div.drag' => 'width: {{SIZE}}px;',
					
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
		        'label_style',
			[
				'label'    =>  __('Label', 'rsaddon'),
				'tab'      => Controls_Manager::TAB_STYLE
			]
        );

		$this->add_control(
			'label_position',
			[
				'label' => __( 'Position', 'rsaddon' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'top' => __( 'Top', 'rsaddon' ),
					'bottom' => __( 'Bottom', 'rsaddon' ),
				],
				
				'default' => 'bottom',				
			]
		);

		$this->add_control(
			'label_width',
			[
				'label' => __( 'Width', 'rsaddon' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 90,
				'min' => 90,
				'max' => 200,
				'step' => 5,
				'render_type' => 'template',
				'selectors' => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'width: {{SIZE}}px;',
					
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'label_text_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rs-image-comparision span.caption',
			]
		);

		$this->add_control(
			'label_color',
			[
				'label'     => __('Color', 'rsaddon'),
				'type'      => Controls_Manager::COLOR,
				'scheme'    => Scheme_Typography::TYPOGRAPHY_1,
				'selectors'    => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'color: {{VALUE}}',					
				]
			]
		);
		$this->add_control(
			'label_background_color',
			[
				'label'     => __('Background Color', 'rsaddon'),
				'type'      => Controls_Manager::COLOR,				
				'selectors'    => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'background-color: {{VALUE}}',					
				]
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'label_border',
				'label' => __( 'Box Border', 'rsaddon' ),
				'selector' =>
				        '{{WRAPPER}} .rs-image-comparision span.caption',
			]
		);



		$this->add_control(
			'label_border_radius',
			[
				'label' => __( 'Border Radius', 'rsaddon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px','%' ],
				'selectors' => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',					
				],
			]
		);

		$this->add_control(
			'label_padding',
			[
				'label' => __( 'Padding', 'rsaddon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px'],
				'selectors' => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'padding: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',
					
				],
			]
		);
		$this->add_control(
			'label_margin',
			[
				'label' => __( 'Margin', 'rsaddon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .rs-image-comparision span.caption' => 'margin: {{TOP}}px {{RIGHT}}px {{BOTTOM}}px {{LEFT}}px;',					
				],
			]
		);

		$this->end_controls_section();

	}


	protected function render() {
		$settings = $this->get_settings_for_display();        
		$unique = rand(12,35120);
		?>
        <div id="rscomprision-<?php echo $unique;?>" class="beforeandafter rs-image-comparision label-<?php echo $settings['label_position'];?>" style="width: 100%;">

			<div class="before1">
				<?php echo wp_get_attachment_image( $settings['before_image']['id'], 'before_image_size' ); ?>
				<?php if(!empty($settings['text_before'])):?><span class="caption"><?php echo $settings['text_before'];?></span><?php endif;?>
			</div>

			<div class="after1">
				<?php echo wp_get_attachment_image( $settings['after_image']['id'], 'after_image_size' ); ?>
				<?php if(!empty($settings['text_after'])):?><span class="caption"><?php echo $settings['text_after'];?></span><?php endif;?>
			</div>

		</div>
		<script>

			jQuery(function(){ // after DOM has loaded
				bafinstance = new ddbeforeandafter({
						wrapperid: 'rscomprision-<?php echo $unique;?>'
				})
			})
		</script>

        <?php
    }

  
} ?>