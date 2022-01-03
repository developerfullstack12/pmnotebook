<?php
if (!defined('ABSPATH')) {
    exit; // disable direct access
}


/**
 * Register Learndash Complete Quiz between grades
 * 
 */


add_filter('mycred_setup_hooks', 'Learndash_Complete_Quiz_Percentage_Range_myCRED_Hook');


function Learndash_Complete_Quiz_Percentage_Range_myCRED_Hook($installed) {

    $installed['hook_complete_quiz_percentage_range_learndash'] = array(
        'title' => __('Complete Quiz Between Grades (LearnDash)', 'mycred'),
        'description' => __('Awards %_plural% for LearnDash actions.', 'mycred'),
        'callback' => array('myCRED_Hook_Learndash_Complete_Quiz_Percentage_Range')
    );

    return $installed;
}


/**
 * Hook for LearnDash Complete Quiz between grades
 */
add_action('mycred_load_hooks', 'mycred_load_learndash_complete_quiz_percentage_range_hook', 10);


function mycred_load_learndash_complete_quiz_percentage_range_hook() {

    if (!class_exists('myCRED_Hook_Learndash_Complete_Quiz_Percentage_Range') && class_exists('myCRED_Hook')) {


        class myCRED_Hook_Learndash_Complete_Quiz_Percentage_Range extends myCRED_Hook {  

                /**
             * Construct
             */
            function __construct($hook_prefs, $type = 'mycred_default') {
                parent::__construct(array(
                    'id' => 'hook_complete_quiz_percentage_range_learndash',
                    'defaults' => array( 
                        'creds' => 0,
                        'log' => __('%plural% for Completing a Quiz between grades', 'mycred-learndash'),
                        'minimum_grade_percentage' => 0,
                        'maximum_grade_percentage' => 0,
                        'limit' => '0/x',
                        'check_specific_hook' => 0,
                        'quiz_range_percent_grade' => array(
                        'creds' => array(),
                        'log' => array(),
                        'min_percentage_range' => array(),
                        'max_percentage_range' => array(),
                        'range_select_quiz' => array(),
                            
                      ),
                         
                    )
                        ), $hook_prefs, $type);
            } 

            public function run() {
                 add_action( 'learndash_quiz_completed', array($this,'mycred_ld_complete_quiz_between_grade_range'), 40, 2 );
            }

             public function quiz_name() {
                $query_args = array( 
                    'post_type'         =>   'sfwd-quiz', 
                    'posts_per_page'    =>   -1,
                    'orderby'           =>   'title',
                    'order'             =>   'ASC',                                        
                );
         
                $query_results = new WP_Query( $query_args );

                if( !empty( $query_results->posts ) )
                    return $query_results->posts;

                return false;

            }


             public function mycred_learndash_quiz_range_arrange_data( $specific_quiz_range_hook_data ){
              
                $hook_data = array();
                foreach ( $specific_quiz_range_hook_data['creds'] as $key => $value ) {
                    $hook_data[$key]['creds']      = $value;
                    $hook_data[$key]['log']        = $specific_quiz_range_hook_data['log'][$key];
                    $hook_data[$key]['limit'] = $specific_quiz_range_hook_data['limit'][$key];
                    $hook_data[$key]['range_select_quiz'] = $specific_quiz_range_hook_data['range_select_quiz'][$key];
                     $hook_data[$key]['min_percentage_range'] = $specific_quiz_range_hook_data['min_percentage_range'][$key];
                    $hook_data[$key]['max_percentage_range'] = $specific_quiz_range_hook_data['max_percentage_range'][$key];

                    
                }
                return $hook_data;
            
            }

            public function mycred_ld_complete_quiz_between_grade_range($quiz_data, $current_user){


                $prefs = $this->prefs;
                $course_id = $quiz_data['course'] instanceof WP_Post ? absint( $quiz_data['course']->ID ) : 0;
                $score = absint( $quiz_data['percentage'] ); 
                $quiz_id = $quiz_data['quiz']->ID;
                $current_user_id = $current_user->ID;
                $ref_type  = array( 'ref_type' => 'post' );


                if( $prefs['check_specific_hook'] == '1' && !empty( $prefs['quiz_range_percent_grade']['range_select_quiz'] ) && in_array( $quiz_data['quiz']->ID, $prefs['quiz_range_percent_grade']['range_select_quiz'] ) ) {
                    $hook_index = array_search( $quiz_data['quiz']->ID, $prefs['quiz_range_percent_grade']['range_select_quiz'] );
    
                    if (  
                        !empty( $prefs['quiz_range_percent_grade']['creds'] ) && isset( $prefs['quiz_range_percent_grade']['creds'][$hook_index] ) &&
                        !empty( $prefs['quiz_range_percent_grade']['log'] ) && !empty( $prefs['quiz_range_percent_grade']['log'][$hook_index] ) &&
                        !empty( $prefs['quiz_range_percent_grade']['range_select_quiz'] ) && isset( $prefs['quiz_range_percent_grade']['range_select_quiz'][$hook_index] )
                    ){ 


                         if ($this->over_hook_limit('quiz_range_percent_grade', 'learndash_quiz_range_percent_grade', $current_user->ID))
                              return;
    
                        $score = absint( $quiz_data['percentage'] ); 
                        $quiz_id = $quiz_data['quiz']->ID;
                        $current_user_id = $current_user->ID;
    
                        // Make sure this is unique event
                        if ( $this->core->has_entry( 'learndash_quiz_range_percent_grade', $quiz_data['quiz']->ID, $current_user->ID) ) return;
    

                        if($score>= $prefs['quiz_range_percent_grade']['min_percentage_range'][$hook_index]   && $score<= $prefs['quiz_range_percent_grade']['max_percentage_range'][$hook_index]  && $quiz_data['pass']  )
                                $this->core->add_creds(
                                    'learndash_quiz_range_percent_grade',
                                    $current_user->ID,
                                    $prefs['quiz_range_percent_grade']['creds'][$hook_index],
                                    $prefs['quiz_range_percent_grade']['log'][$hook_index],
                                    $quiz_data['quiz']->ID,
                                    array('ref_type' => 'post'),
                                    $this->mycred_type
                                );
    
                    }
                }

                else{


                      if ($this->over_hook_limit('', 'learndash_quiz_range_percent_grade', $current_user->ID)) 
                         return; 

                     // Make sure this is unique event
                     if ( $this->core->has_entry( 'learndash_quiz_range_percent_grade', $quiz_data['quiz']->ID, $current_user->ID) ) return;

                   
                     $this->core->add_creds(
                        'learndash_quiz_range_percent_grade',
                        $current_user->ID,
                        $prefs['creds'],
                        $prefs['log'],
                        $quiz_data['quiz']->ID,
                        array('ref_type' => 'post'),
                        $this->mycred_type
                    );

                }


            }   

            public function specific_field_name( $field = '' ) {

                 $hook_prefs_key = 'mycred_pref_hooks';

                if ( is_array( $field ) ) {
                    $array = array();
                    foreach ( $field as $parent => $child ) {
                        if ( ! is_numeric( $parent ) )
                            $array[] = $parent;
    
                        if ( ! empty( $child ) && !is_array( $child ) )
                            $array[] = $child;
                    }
                    $field = '[' . implode( '][', $array ) . ']';
                }
                else {
                    $field = '[' . $field . ']';
                }

                $option_id = 'mycred_pref_hooks';
                if ( ! $this->is_main_type )
                $option_id = $option_id . '_' . $this->mycred_type;
    
                return $option_id . '[hook_prefs]['. $this->id . ']'  . $field . '[]';
    
            } 

             /**
             * Preferences for LearnDash
             */
            public function preferences( ) {

                $prefs = $this->prefs;

                ?>

                 <!-- general starts -->

                 <div class="hook-instance">
                    <h3><?php _e( 'General', 'mycred' ); ?></h3>
                    <div class="row">

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="<?php echo $this->field_id( 'creds' ); ?>"><?php echo $this->core->plural(); ?></label>
                                <input type="text" name="<?php echo $this->field_name( 'creds' ); ?>" id="<?php echo $this->field_id( 'creds' ); ?>" value="<?php echo $this->core->number( $prefs['creds'] ); ?>" class="form-control" />
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="<?php echo $this->field_id( 'minimum_grade_percentage' ); ?>"><?php _e('Minimum Percent Grade', 'minimum_grade_percentage'); ?></label>
                                <input type="text" name="<?php echo $this->field_name( 'minimum_grade_percentage' ); ?>" id="<?php echo $this->field_id( 'minimum_grade_percentage' ); ?>" value="<?php echo $this->core->number( $prefs['minimum_grade_percentage'] ); ?>" class="form-control" />
                                
                            </div>
                        </div>


                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                            <div class="form-group">

                                <label for="<?php echo $this->field_id( 'maximum_grade_percentage' ); ?>"><?php _e('Maximum Percent Grade', 'maximum_grade_percentage'); ?></label>
                                <input type="text" name="<?php echo $this->field_name( 'maximum_grade_percentage' ); ?>" id="<?php echo $this->field_id( 'maximum_grade_percentage' ); ?>" value="<?php echo $this->core->number( $prefs['maximum_grade_percentage'] ); ?>" class="form-control" />

                                
                            </div>
                        </div>

                       

                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                           <div class="form-group">
                                <label for="<?php echo $this->field_id('log' ); ?>"><?php _e('Log Template', 'mycred'); ?></label>
                                <input type="text" name="<?php echo $this->field_name( 'log' ); ?>" id="<?php echo $this->field_id( 'log' ); ?>" value="<?php echo esc_attr( $prefs['log'] ); ?>" class="form-control" />
                                <span class="description"><?php echo $this->available_template_tags(array('general', 'post')); ?></span>
                            </div>
                        </div>
   

                    </div>
                    
            
                </div>

                 <!-- general ends -->


                <?php

                $quiz_range_percent_grade = array(
                     array(
                        'creds' => 0,
                        'log' => __('%plural% for Completing a Specific Quiz between grades', 'mycred-learndash'),
                        'limit' => '0/x',
                    'range_select_quiz' => 0,
                    
                    'min_percentage_range' => 0,
                    'max_percentage_range' => 0,
                       
                  ),
                );

                if ( count( $prefs['quiz_range_percent_grade']['creds'] ) > 0 ) {

                      $quiz_range_percent_grade = $this->mycred_learndash_quiz_range_arrange_data( $prefs['quiz_range_percent_grade'] );
    
                }

                $score = get_post_meta(absint($_POST['leaderboard_id']), 'score_quiz_based', true);

                $quiz_percent_grade_range = $this->quiz_name();

                ?>

                <div class="hook-instance" id="specific-hook">

                     

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="hook-title">
                                <h3><?php _e( 'Specific', 'mycred' ); ?></h3>
                            </div>
                        </div>
                    </div>

                    <div class="checkbox" style="margin-bottom:14px;">
                            
                            <input type="checkbox" id="<?php echo $this->field_id('check_specific_hook'); ?>" name="<?php echo $this->field_name('check_specific_hook'); ?>" value="1" <?php if( $prefs['check_specific_hook'] == '1') echo "checked = 'checked'"; ?>>
                            <label for="specifichook"> Enable Specific Hook</label>
                        </div> 


                    <?php 
                    foreach($quiz_range_percent_grade as $hook => $label){
  

                        ?>
                 <div class="custom_hook_class">
                    <div class="row">

                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label for="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'creds')); ?>"><?php echo $this->core->plural(); ?></label>
                                <input type="text" name="<?php echo $this->specific_field_name(array('quiz_range_percent_grade' => 'creds')); ?>" id="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'creds')); ?>" value="<?php echo $this->core->number( $label['creds']); ?>" class="form-control mycred-learndash-creds" />
                            </div>
                        </div>




                     <div class="col-lg-3">

                            <div class="form-group">


                                <label for="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'min_percentage_range')); ?>"><?php _e('Minimum Percent Grade', 'min_percentage_range'); ?></label>
                                        <input type="text" name="<?php echo $this->specific_field_name(array('quiz_range_percent_grade' => 'min_percentage_range')); ?>" id="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'min_percentage_range')); ?>" value="<?php echo $this->core->number( $label['min_percentage_range']); ?>" class="form-control mycred-learndash-creds" />
                            </div>
                      </div>


                <div class="col-lg-3">
                            <div class="form-group">
                                <label for="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'max_percentage_range')); ?>"><?php _e('Maximum Percent Grade', 'max_percentage_range'); ?></label>
                                        <input type="text" name="<?php echo $this->specific_field_name(array('quiz_range_percent_grade' => 'max_percentage_range')); ?>" id="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'max_percentage_range')); ?>" value="<?php echo $this->core->number( $label['max_percentage_range']); ?>" class="form-control mycred-learndash-creds" />
                            </div>
                </div>


                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label><?php _e( 'Select Specific Quiz', 'range_select_quiz' ); ?></label>
                                <select class="form-control mycred-learndash-quiz-range" name="<?php echo $this->specific_field_name(array('quiz_range_percent_grade' => 'range_select_quiz')); ?>" value=""  >
                            
                                <?php 
                                $selected = '';
                                foreach ($quiz_percent_grade_range as $quiz_name) {

                                $quiz_id = $quiz_name->ID;

                                    echo '<option class="select-value" value="'.$quiz_name->ID.'" '. ( $quiz_name->ID == $label['range_select_quiz'] ? ' selected' : '') .' >'.$quiz_name->post_title.'</option>';
                                }
                                
                                ?>
                                    
                                </select>
                                
                                
                            </div>
                        </div>

                        <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 ">
                            <div class="form-group" >
                                <label style="margin-top:10px;" for="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'log')); ?>"><?php _e('Log Template', 'mycred'); ?></label>
                                <input type="text" name="<?php echo $this->specific_field_name(array('quiz_range_percent_grade' => 'log')); ?>" id="<?php echo $this->field_id(array('quiz_range_percent_grade' => 'log')); ?>" value="<?php echo esc_attr($label['log']) ; ?>" class="form-control mycred-learndash-log" />
                                <span class="description"><?php echo $this->available_template_tags(array('general', 'post')); ?></span>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12  field_wrapper">
                                <div class="form-group specific-hook-actions textright" >
                                    <button class="button button-small mycred-add-specific-learndash-hook add_button" id="clone_btn" type="button">Add More</button>
                                    <button class="button button-small mycred-remove-specific-quiz-hook" type="button">Remove</button>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                    <?php 

                            }
                    
                    ?>
            </div>

               <div class="hook-instance">
                        <h3><?php _e( 'Limit', 'mycred' ); ?></h3>
                        <div class="row">
                            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <?php add_filter('mycred_hook_limits', array($this, 'custom_limit')); ?>
                                    <label for="<?php echo $this->field_id( 'limit' ); ?>"><?php _e('', 'mycred'); ?></label>
                                    <?php echo $this->hook_limit_setting( $this->field_name( 'limit' ), $this->field_id( 'limit' ), $prefs['limit'] ); ?>
                                </div>
                            </div> 
                        </div>
                </div>

             <?php


            }  

            function sanitise_preferences($data) {

               $data['creds'] = ( !empty( $data['creds'] ) ) ? floatval( $data['creds'] ) : $this->defaults['creds'];
               $data['check_specific_hook'] = ( !empty( $data['check_specific_hook'] ) ) ? sanitize_text_field( $data['check_specific_hook'] ) : $this->defaults['check_specific_hook'];
               $data['log'] = ( !empty( $data['log'] ) ) ? sanitize_text_field( $data['log'] ) : $this->defaults['log'];

               if ( isset( $data['limit'] ) && isset( $data['limit_by'] ) ) {
                $limit = sanitize_text_field( $data['limit'] );
                if ( $limit == '' ) $limit = 0;
                $data['limit'] = $limit . '/' . $data['limit_by'];
                unset( $data['limit_by'] );
                }

             
               foreach ( $data[ 'quiz_range_percent_grade' ] as $data_key => $data_value ) {

                    foreach ( $data_value as $key => $value) {

                        if ( $data_key == 'creds' ) {
                            $data[ 'quiz_range_percent_grade' ][$data_key][$key] = ( !empty( $value ) ) ? floatval( $value ) : 10;
                        }
                        else if ( $data_key == 'log' ) {
                            $data[ 'quiz_range_percent_grade' ][$data_key][$key] = ( !empty( $value ) ) ? sanitize_text_field( $value ) : '%plural% for completing course between grades.';
                        }
                       
                        else if ( $data_key == 'min_percentage_range' ) {
                            $data[ 'quiz_range_percent_grade' ][$data_key][$key] = ( !empty( $value ) ) ? sanitize_text_field( $value ) : '0';
                        }

                          else if ( $data_key == 'max_percentage_range' ) {
                            $data[ 'quiz_range_percent_grade' ][$data_key][$key] = ( !empty( $value ) ) ? sanitize_text_field( $value ) : '0';
                        }

                        else if ( $data_key == 'range_select_quiz' ) {
                            $data[ 'quiz_range_percent_grade' ][$data_key][$key] = ( !empty( $value ) ) ? sanitize_text_field( $value ) : '0';
                        }
                    }
                }

                return $data;

            }    


            public function custom_limit() {
                return array(
                    'x' => __('No limit', 'mycred'),
                    'd' => __('/ Day', 'mycred'),
                    'w' => __('/ Week', 'mycred'),
                    'm' => __('/ Month', 'mycred'),
                );
            }             


        }

    }


}
