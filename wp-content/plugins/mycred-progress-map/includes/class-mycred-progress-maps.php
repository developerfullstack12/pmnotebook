<?php
add_filter('mycred_load_modules', 'mycred_progress_map_extend_badge_module', 10, 2);

function mycred_progress_map_extend_badge_module($modules, $point_types) {

    class myCred_Progess_Maps_Module extends myCRED_Badge_Module {

        public function init() {
            add_action('wp_head', array($this, 'customize_timeline_color'), 99999);
            add_action('mycred_admin_enqueue', array($this, 'enqueue_admin_scripts'));
            add_action('mycred_front_enqueue', array($this, 'load_progress_map_scripts'), $this->menu_pos);
            add_action('mycred_after_core_prefs', array($this, 'after_general_settings'));
            add_filter('mycred_save_core_prefs', array($this, 'sanitize_extra_settings'), 90, 3);
            add_filter('mycred_badge_display_requirements', array($this, 'display_level'), 10, 2);
            add_filter('override_badge_template', array($this, 'override_badge_template'));
        }

        /**
         * Enqueue frontend scripts
         */
        public function load_progress_map_scripts() {
            $settings = $this->badges;
            wp_enqueue_script('script_mycred_timeline', plugin_dir_url(__DIR__) . 'assets/js/timeline.js', array('jquery'));
            wp_enqueue_style('style_mycred_timeline', plugin_dir_url(__DIR__) . 'assets/css/timeline.css');
            $progress_map_direction = (isset($settings['progress_map_direction']) ? $settings['progress_map_direction'] : 'vertical');
            $progress_map_alignment = (isset($settings['progress_map_alignment']) ? $settings['progress_map_alignment'] : 'center');
            $visible_items = (isset($settings['visible_items']) ? $settings['visible_items'] : '3');
            $timeline_data = array(
                'progress_map_direction' => $progress_map_direction,
                'visible_items' => $visible_items,
                'align_item' => $progress_map_alignment
            );
            wp_localize_script('script_mycred_timeline', 'mycred_timeline', $timeline_data);
        }

        /**
         * Enqueue scripts in admin
         */
        public function enqueue_admin_scripts() {
            wp_enqueue_script('script_admin_progressmap', plugin_dir_url(__DIR__) . 'assets/js/admin-timeline.js', array('jquery'));
        }

        public function customize_timeline_color() {
            $settings = $this->badges;
            $timeline_color = (!empty($settings['timeline_color']) ? $settings['timeline_color'] : '#dddddd');
            $progress_color = (!empty($settings['progress_color']) ? $settings['progress_color'] : '#c5bf0e');
            $progress_text_color = (!empty($settings['progress_text_color']) ? $settings['progress_text_color'] : '#c5bf0e');
            $timeline_text_color = (!empty($settings['timeline_text_color']) ? $settings['timeline_text_color'] : '#dddddd');
            $css = ".timeline__item:after { border: 4px solid $timeline_color ; }";
            $css .= ".timeline:not(.timeline--horizontal):before {background-color: $timeline_color;}";
            $css .= ".timeline--horizontal .timeline-divider {background-color: $timeline_color;}";
            $css .= ".timeline-nav-button {border: 2px solid $timeline_color;}";
            $css .= ".timeline__items .custom-class:before { background: $progress_color;}";
            $css .= ".timeline__items .custom-class:after {border-color: $progress_color;}";
            $css .= ".timeline-nav-button{background-color: $timeline_color}";
            $css .= "button.timeline-nav-button.timeline-nav-button--next:hover,button.timeline-nav-button.timeline-nav-button--prev:hover{background-color:$progress_color;}";
            $css .= ".custom-class .timeline__content{color:$progress_text_color}";
            $css .= ".timeline__item:not(.custom-class) .timeline__content{color:$timeline_text_color}";
            echo "<style type=\"text/css\">\n";
            echo $css;
            echo "\n</style>\n";
        }

        /**
         * Load Progress Map settings in mycred general settings
         * @param object $mycred
         */
        public function after_general_settings($mycred = NULL) {

            $settings = $this->badges;
            $progress_map_direction = (isset($settings['progress_map_direction']) ? $settings['progress_map_direction'] : 'vertical');
            $progress_map_alignment = (isset($settings['progress_map_alignment']) ? $settings['progress_map_alignment'] : 'center');
            $visible_items = (isset($settings['visible_items']) ? $settings['visible_items'] : '3');
            $progress_color = (isset($settings['progress_color']) ? $settings['progress_color'] : '#c5bf0e');
            $timeline_color = (isset($settings['timeline_color']) ? $settings['timeline_color'] : '#dddddd');
            $progress_text_color = (isset($settings['progress_text_color']) ? $settings['progress_text_color'] : '#c5bf0e');
            $timeline_text_color = (isset($settings['timeline_text_color']) ? $settings['timeline_text_color'] : '#dddddd');
            ?>
            <h4><span class="dashicons dashicons-admin-plugins static"></span><?php _e('Progress Map', 'mycred-progress-map'); ?></h4>
            <div class="body" style="display:none;">
                <h3><?php _e(' Progress Map Settings', 'mycred-progress-map'); ?></h3>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="<?php echo $this->field_id('timeline_color'); ?>"><?php _e('Progress Bar Color', 'mycred-progress-map'); ?></label>
                            <input type="color" name="<?php echo $this->field_name('timeline_color'); ?>" id="<?php echo $this->field_id('timeline_color'); ?>" value="<?php echo esc_attr($timeline_color); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="<?php echo $this->field_id('progress_color'); ?>"><?php _e('Completed Levels Color', 'mycred-progress-map'); ?></label>
                            <input type="color" name="<?php echo $this->field_name('progress_color'); ?>" id="<?php echo $this->field_id('progress_color'); ?>" value="<?php echo esc_attr($progress_color); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="<?php echo $this->field_id('timeline_text_color'); ?>"><?php _e('Uncompleted  Levels text Color', 'mycred-progress-map'); ?></label>
                            <input type="color" name="<?php echo $this->field_name('timeline_text_color'); ?>" id="<?php echo $this->field_id('timeline_text_color'); ?>" value="<?php echo esc_attr($timeline_text_color); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="<?php echo $this->field_id('progress_text_color'); ?>"><?php _e('Completed Levels Text Color', 'mycred-progress-map'); ?></label>
                            <input type="color" name="<?php echo $this->field_name('progress_text_color'); ?>" id="<?php echo $this->field_id('progress_text_color'); ?>" value="<?php echo esc_attr($progress_text_color); ?>" />
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label for="<?php echo $this->field_id('progress_map_direction'); ?>"><?php _e('Progress Map Direction', 'mycred-progress-map'); ?></label>
                            <input type="radio" name="<?php echo $this->field_name('progress_map_direction'); ?>"   id="<?php echo $this->field_id('progress_map_direction'); ?>" value="vertical" <?php checked($progress_map_direction, 'vertical'); ?> /> <?php _e('Vertical', 'mycred-progress-map'); ?> <br>                    
                            <input type="radio" name="<?php echo $this->field_name('progress_map_direction'); ?>"  id="<?php echo $this->field_id('progress_map_direction'); ?>" value="horizontal"  <?php checked($progress_map_direction, 'horizontal'); ?> /> <?php _e('Horizontal', 'mycred-progress-map'); ?>  <br>                     
                        </div>
                        <div class="form-group vertical_visible_items_count" >
                            <label for="<?php echo $this->field_id('visible_items'); ?>"><?php _e('Visible Items', 'mycred-progress-map'); ?></label>
                            <input type="number"  min=1 value="<?php echo esc_attr($visible_items); ?>"name="<?php echo $this->field_name('visible_items'); ?>"   id="<?php echo $this->field_id('visible_items'); ?>"  />  <br>                    

                        </div>
                        <div class="form-group vertical-alignment">
                            <label for="<?php echo $this->field_id('progress_map_alignment'); ?>"><?php _e('Vertical Alignment', 'mycred-progress-map'); ?></label>
                            <input type="radio" name="<?php echo $this->field_name('progress_map_alignment'); ?>"   id="<?php echo $this->field_id('progress_map_alignment'); ?>" value="left" <?php checked($progress_map_alignment, 'left'); ?> /> <?php _e('Left', 'mycred-progress-map'); ?> <br>                    
                            <input type="radio" name="<?php echo $this->field_name('progress_map_alignment'); ?>"  id="<?php echo $this->field_id('progress_map_alignment'); ?>" value="center"  <?php checked($progress_map_alignment, 'center'); ?> /> <?php _e('Center', 'mycred-progress-map'); ?>  <br>                     
                            <input type="radio" name="<?php echo $this->field_name('progress_map_alignment'); ?>"  id="<?php echo $this->field_id('progress_map_alignment'); ?>" value="right"  <?php checked($progress_map_alignment, 'right'); ?> /> <?php _e('Right', 'mycred-progress-map'); ?>  <br>                                               
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }

        /**
         * Save  Settings
         * @param array $new_data
         * @param array $data
         * @param object $core
         * @return array
         */
        public function sanitize_extra_settings($new_data, $data, $core) {
            $new_data['badges']['timeline_color'] = ( isset($data['badges']['timeline_color']) ) ? $data['badges']['timeline_color'] : '';
            $new_data['badges']['progress_color'] = ( isset($data['badges']['progress_color']) ) ? $data['badges']['progress_color'] : '';
            $new_data['badges']['visible_items'] = ( isset($data['badges']['visible_items']) ) ? $data['badges']['visible_items'] : '';
            $new_data['badges']['progress_map_direction'] = ( isset($data['badges']['progress_map_direction']) ) ? $data['badges']['progress_map_direction'] : '';
            $new_data['badges']['progress_map_alignment'] = ( isset($data['badges']['progress_map_alignment']) ) ? $data['badges']['progress_map_alignment'] : '';
            $new_data['badges']['timeline_text_color'] = ( isset($data['badges']['timeline_text_color']) ) ? $data['badges']['timeline_text_color'] : '';
            $new_data['badges']['progress_text_color'] = ( isset($data['badges']['progress_text_color']) ) ? $data['badges']['progress_text_color'] : '';

            return $new_data;
        }

        /**
         *  Display Levels as progress bar
         * @param type $row
         * @param type $badge_id
         * @return type
         */
        public function display_level($row, $badge_id) {
            ob_start();
            $settings = $this->badges;
            $badge_level_reached = '';
            $user_id = get_current_user_id();
            $badge_level_reached = mycred_badge_level_reached($user_id, $badge_id);
            $levels = mycred_get_badge_levels($badge_id);
            if (empty($levels)) {

                $reply = '-';
            } else {

                $point_types = mycred_get_types(true);
                $references = mycred_get_all_references();
                $req_count = count($levels[0]['requires']);

                // Get the requirements for the first level
                $base_requirements = array();
                foreach ($levels[0]['requires'] as $requirement_row => $requirement) {

                    if ($requirement['type'] == '')
                        $requirement['type'] = MYCRED_DEFAULT_TYPE_KEY;

                    if (!array_key_exists($requirement['type'], $point_types))
                        continue;

                    if (!array_key_exists($requirement['reference'], $references))
                        $reference = '-';
                    else
                        $reference = $references[$requirement['reference']];

                    $base_requirements[$requirement_row] = array(
                        'type' => $requirement['type'],
                        'ref' => $reference,
                        'amount' => $requirement['amount'],
                        'by' => $requirement['by']
                    );
                }
            }

            // Loop through each level
            $output = array();
            ?>
            <div class="timeline">
                <div class="timeline__wrap">
                    <div class="timeline__items "> 
                        <?php foreach ($levels as $level => $setup): ?>
                            <div class="timeline__item <?php echo ($badge_level_reached !== false && $badge_level_reached >= $level ? 'custom-class' : ''); ?>">
                                <div class="timeline__content">
                                    <?php
                                    $level_label = '<strong>' . sprintf(__('Level %s', 'mycred'), ( $level + 1)) . ':</strong>';
                                    if ($levels[$level]['label'] != '')
                                        $level_label = '<strong>' . $levels[$level]['label'] . ':</strong>';

                                    // Construct requirements to be used in an unorganized list.
                                    $level_req = array();
                                    foreach ($setup['requires'] as $requirement_row => $requirement) :
                                        $level_value = $requirement['amount'];
                                        $requirement = $base_requirements[$requirement_row];
                                        $mycred = mycred($requirement['type']);

                                        if ($level > 0)
                                            $requirement['amount'] = $level_value;

                                        if ($requirement['by'] == 'count')
                                            $rendered_row = sprintf(_x('%s for "%s" x %d', '"Points" for "reference" x times', 'mycred'), $mycred->plural(), $requirement['ref'], $requirement['amount']);
                                        else
                                            $rendered_row = sprintf(_x('%s %s for "%s"', '"Gained/Lost" "x points" for "reference"', 'mycred'), ( ( $requirement['amount'] < 0 ) ? __('Lost', 'mycred') : __('Gained', 'mycred')), $mycred->format_creds($requirement['amount']), $requirement['ref']);

                                        $compare = _x('OR', 'Comparison of badge requirements. A OR B', 'mycred');
                                        if ($setup['compare'] === 'AND')
                                            $compare = _x('AND', 'Comparison of badge requirements. A AND B', 'mycred');

                                        if ($req_count > 1 && $requirement_row + 1 < $req_count)
                                            $rendered_row .= ' <span><strong>' . $compare . '</strong></span>';

                                        $level_req[] = $rendered_row;
                                    endforeach;
                                    if (empty($level_req))
                                        continue;


                                    $output = $level_label . '<ul class="mycred-badge-requirement-list"><li>' . implode('</li><li>', $level_req) . '</li></ul>';
//                                    if ((int) mycred_get_post_meta($badge_id, 'manual_badge', true) === 1)
//                                        $output = '<strong><small><em>' . __('This badge is manually awarded.', 'mycred') . '</em></small></strong>';

                                    echo $output;
                                    ?>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
            <?php
            return ob_get_clean();
        }

        /**
         * Override Badge template
         * @return string
         */
        public function override_badge_template() {
            $template = '<div class="the-badge row"><div class="col-xs-12"><div class="the-badge row"><div class="col-xs-12"><h3 class="badge-title">%badge_title%</h3><div class="badge-images">%default_image% %main_image%</div><div class="badge-requirements">%requirements%</div><div class="users-with-badge">%count%</div></div>';
            return $template;
        }

    }

    $progress_bar_module = new myCred_Progess_Maps_Module();
    $progress_bar_module->init();
}
