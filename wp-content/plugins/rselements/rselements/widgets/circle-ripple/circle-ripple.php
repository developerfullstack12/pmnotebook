<?php
/**
 * Circle Ripple Widget
 *
 */
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || die();

class Rsaddon_Pro_CircleRipple_Widget extends \Elementor\Widget_Base {

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
        return 'rs-circle-ripple';
    }   


    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__( 'RS Circle Ripple', 'rsaddon' );
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'glyph-icon flaticon-ballot-box';
    }


    public function get_categories() {
        return [ 'rsaddon_category' ];
    }

    protected function _register_controls() {


        
        $this->start_controls_section(
            'circle_style',
            [
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
          
        $this->add_control(
            'bg_color',
            [
                'label' => esc_html__( 'Background Color', 'rsaddon' ),
                'type' => Controls_Manager::COLOR,            
                'selectors' => [
                    '{{WRAPPER}}' => '{{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'animation_style',
            [
                'label' => esc_html__( 'Animation', 'rsaddon' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [
                        'min' => 0.2,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .rs-circle-ripple' => 'animation:circleripple {{SIZE}}s linear infinite;',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width',
            [
                'label' => esc_html__( 'Circle Width', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-circle-ripple' => 'width: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control(
            'border_height',
            [
                'label' => esc_html__( 'Circle Height', 'rsaddon' ),
                'type' => Controls_Manager::TEXT,
                'size_units' => [ 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-circle-ripple' => 'height: {{SIZE}}px;',
                ],
            ]
        );
        $this->add_responsive_control(
            'border_radius',
            [
                'label' => esc_html__( 'Circle Border Radius', 'rsaddon' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .rs-circle-ripple' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

  
        


        $this->end_controls_section();
    }
  
    protected function render() {
        $settings = $this->get_settings_for_display(); 
        ?> 
        <div class="rs-ripple-inner">
            <div class="rs-circle-ripple"></div>
        </div>
        
        <style>
         <?php
            $hex = "#21a7d0";
            if($settings['bg_color']){
                $hex = $settings['bg_color'];
            }
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
         ?>       

            .rs-circle-ripple {
              background-color: <?php echo esc_attr($settings['bg_color']); ?>;
              -webkit-animation: circleripple 0.7s linear infinite;
                      animation: circleripple 0.7s linear infinite;
            }

            @-webkit-keyframes circleripple {
              0% {
                box-shadow: 0 0 0 0 rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 1em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 3em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 5em rgba(<?php echo "$r, $g, $b"; ?>, 0.3);
              }
              100% {
                box-shadow: 0 0 0 1em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 3em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 5em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 8em rgba(<?php echo "$r, $g, $b"; ?>, 0);
              }
            }

            @keyframes circleripple {
              0% {
                box-shadow: 0 0 0 0 rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 1em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 3em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 5em rgba(<?php echo "$r, $g, $b"; ?>, 0.3);
              }
              100% {
                box-shadow: 0 0 0 1em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 3em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 5em rgba(<?php echo "$r, $g, $b"; ?>, 0.3), 0 0 0 8em rgba(<?php echo "$r, $g, $b"; ?>, 0);
              }
            }
        </style>
    <?php }
}
