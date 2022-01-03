<?php

Class MNP_Settings {

    public function __construct() {
        add_action( 'mycred_after_core_prefs', array( $this, 'mycred_popup_settings' ), 10, 1 );
        add_filter( 'mycred_save_core_prefs', array( $this, 'mycred_save_popup_setting' ), 10, 3 );
    }

    public function mycred_popup_settings( $obj ) {
		$exp_mail = mycred_get_option('mycred_pref_core');
		
        ?>
			<h4><span class="dashicons dashicons-format-status"></span><label><?php _e( 'Social Proof', 'mycred' ); ?></label></h4>
			<div class="body ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display:none;" id="ui-id-8" aria-labelledby="ui-id-7" role="tabpanel" aria-hidden="true">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="mycred-points-exp-before-days">Enable </label>
							<input type="checkbox" <?php echo ( ( isset( $exp_mail['mycred_popup_notify']['enable_popup'] ) && $exp_mail['mycred_popup_notify']['enable_popup'] == '1' ) ? 'checked' : '' ) ?> id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'enable_popup' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'enable_popup' ) )?>" placeholder="Required" value="1" class="mycred-check-count">
						</div>		
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="mycred-points-exp-before-days">Popup Visiblitlity Duration</label>
							<input type="number" id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'on_screen_time' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'on_screen_time' ) )?>" placeholder="5" value="<?php echo esc_attr( $obj->core->mycred_popup_notify['on_screen_time'] );?>" class="form-control">
							<p><span class="description">Set time duration in seconds to hold notification popup on screen.</span></p>
						</div>
					</div>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="mycred-points-exp-before-subject">Popup Interval Time</label>
							<input type="number" id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'interval_time' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'interval_time' ) )?>" placeholder="10" value="<?php echo esc_attr( $obj->core->mycred_popup_notify['interval_time'] );?>" class="form-control">
							<p><span class="description">Set time duration in seconds for each notification interval.</span></p>
						</div>
					</div>	

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
							<label for="mycred-points-exp-before-subject">Select Reference to Notification</label>
							<?php echo $this->get_all_references_dropdown($obj)?>
							<p><span class="description">Use CTRL to select multiple.</span></p>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<label for="mycred-points-exp-before-subject">Select Theme</label>
							<div class="checkbox">								
								<input type="radio" <?php echo ( ( isset( $exp_mail['mycred_popup_notify']['theme'] ) && $exp_mail['mycred_popup_notify']['theme'] == 'light_theme' ) ? 'checked' : '' ) ?> id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'theme' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'theme' ) )?>" value="light_theme">
								Light Theme<p><span class="description"></span></p>
							</div>
							<div class="checkbox">								
								<input type="radio" <?php echo ( ( isset( $exp_mail['mycred_popup_notify']['theme'] ) && $exp_mail['mycred_popup_notify']['theme'] == 'dark_theme' ) ? 'checked' : '' ) ?> id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'theme' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'theme' ) )?>" value="dark_theme">
								Dark Theme<p><span class="description"></span></p>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<label for="mycred-points-exp-before-subject">Template</label>							
							<input type="text" id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'title' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'title' ) )?>" placeholder="%username% has been rewarded" value="<?php  echo ( isset( $obj->core->mycred_popup_notify['title'] ) && !empty( $obj->core->mycred_popup_notify['title'] ) ? $obj->core->mycred_popup_notify['title'] : '' );?>" class="form-control">
								<p><span class="description">Social Proof Title</span></p>							
							<input type="text" id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'description' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'description' ) )?>" placeholder="%creds% %ctype% for %reference%" value="<?php echo ( isset( $obj->core->mycred_popup_notify['description'] ) && !empty( $obj->core->mycred_popup_notify['description'] ) ? $obj->core->mycred_popup_notify['description'] : '' );?>" class="form-control">
								<p><span class="description"></span>Social Proof Description</p>						
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<label for="mycred-points-exp-before-subject">Border Style</label>
							<div class="checkbox">								
								<input type="radio" <?php echo ( ( isset( $exp_mail['mycred_popup_notify']['border_style'] ) && $exp_mail['mycred_popup_notify']['border_style'] == 'round' ) ? 'checked' : '' ) ?> id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'border_style' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'border_style' ) )?>" value="round">
								Round Border<p><span class="description"></span></p>
							</div>
							<div class="checkbox">								
								<input type="radio" <?php echo ( ( isset( $exp_mail['mycred_popup_notify']['border_style'] ) && $exp_mail['mycred_popup_notify']['border_style'] == 'square' ) ? 'checked' : '' ) ?> id="<?php echo $obj->field_id( array( 'mycred_popup_notify' => 'border_style' ) )?>" name="<?php echo $obj->field_name( array( 'mycred_popup_notify' => 'border_style' ) )?>" value="square">
								Square Border<p><span class="description"></span></p>
							</div>
						</div>
					</div>
                </div>
			</div>
            <?php
    }

    public function mycred_save_popup_setting( $new_data, $post, $obj ) {
        
        $new_data['mycred_popup_notify'] = array(
            'enable_popup' => sanitize_text_field( $post['mycred_popup_notify']['enable_popup'] ),
            'on_screen_time' => sanitize_text_field( $post['mycred_popup_notify']['on_screen_time'] ),
            'interval_time' => sanitize_text_field( $post['mycred_popup_notify']['interval_time'] ),
            'references' => $post['mycred_popup_notify']['references'],
            'theme' => $post['mycred_popup_notify']['theme'],
            'title' => $post['mycred_popup_notify']['title'],
            'description' => $post['mycred_popup_notify']['description'],
            'border_style' => $post['mycred_popup_notify']['border_style'],
        );

        return $new_data;
	}
	
	/**
	 * myCRED all registered references
	 * @since 1.0
	 * @version 1.0
	 */
	public function get_all_references_dropdown($obj) {
		$all_references = mycred_get_all_references();

		$html = '<div class="msp-ref"><input type="button" id="msp-btn" class="button-primary" value="Select All References" /></div>';
		$html .= '<select multiple class="mycred_ref" name="'.$obj->field_name( array( 'mycred_popup_notify' => 'references' ) ) .'[]">';
		foreach( $all_references as $ref_key => $reference ) {
			
			$html .= '<option value="'.$ref_key.'" '. ( isset( $obj->core->mycred_popup_notify['references'] ) && in_array( $ref_key , $obj->core->mycred_popup_notify['references'] ) ? 'selected' : '' ) .'>'.$reference.'</option>';
		}
		$html .= '</select>';
		return $html;
	}
}

$MNP_Settings = new MNP_Settings();