<?php
/**
 * the template for displaying all posts.
 */
   get_header();  
   //$learndash_related_coures = educavo_option('learndash_related_coures'); 
?>
    <div class="container single-lp_course">
        <div id="content">
            <div class="rs-courses-details rs-edash-details">
                <div class="row">
                    <div class="col-lg-8 col-md-12 contents-sticky">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <div  class="post-content post-single">
                                <?php get_template_part( 'template-parts/learndash/learndash', 'page' ); ?>
                            </div>
        				<?php  endwhile; ?>
                    </div> <!-- .col-md-8 -->
                    <div class="col-lg-4 col-md-12 sticky-sidebar">
                        <div class="inner-column sticky-top edash-sidebar">
                            <?php 
                                $video_link = get_post_meta(get_the_ID(), 'video_links', true);
                                $video_bg   = get_the_post_thumbnail_url();                 
                                $video_link = !empty( $video_link ) ? $video_link : '';                   
                            ?>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="intro-video">  
                                    <?php the_post_thumbnail();?>    
                                    <?php if(!empty($video_link)) : ?>                 
                                        <a href="<?php echo wp_kses($video_link, 'educavo');?>" class="popup-videos intro-video-box"><span class="fa fa-play"></span></a>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php 
                            
                            $lesson = learndash_get_course_steps( get_the_ID(), array('sfwd-lessons') );
                            $topic  = learndash_get_course_steps( get_the_ID(), array( 'sfwd-topic') );

                             $quiz_args = new wp_Query(array(	
                                'post_type' => 'sfwd-quiz',							
								'meta_query' => array( 
									array( 'key' => 'course_id', 
									'value' => get_the_ID()
								))						
							));							
							$quiz = $quiz_args->post_count; 



                            ?>
                            <div class="course-features-info">      
                                <ul>
                                    <li class="lectures-feature">
                                    <i class="fa fa-files-o"></i>
                                    <span class="label"><?php echo esc_html__('Lessons', 'educavo');?></span>
                                    <span class="value">
                                    	<?php echo count($lesson);?>
                                    </span>
                                    </li>

                                    <li class="quizzes-feature">
                                        <i class="fa fa-tasks"></i>
                                       <span class="label"><?php echo esc_html__('Topics', 'educavo');?></span>
                                    <span class="value">
                                    	<?php echo count($topic);?>
                                    </span>
                                    </li>
                                   
                                    <li class="quizzes-feature">
                                        <i class="fa fa-puzzle-piece"></i>
                                       <span class="label"><?php echo esc_html__('Quizes','educavo');?></span>
                                    <span class="value">
                                    	<?php echo esc_html($quiz);?>
                                    </span>
                                    </li>

                                    <?php $duration = get_post_meta(get_the_ID(), 'course_duration', true); ?>
                                    

                                    <?php if( !empty( $duration )) : ?>
                                   
                                        <li class="duration-feature">
                                            <i class="fa fa-clock-o"></i>
                                            <span class="label"><?php echo esc_html__('Duration','educavo');?></span>
                                            <span class="value"><?php echo esc_html( $duration);?> </span>
                                        </li>
                                    <?php endif ; ?> 

                                
                                  <?php $student = get_post_meta(get_the_ID(), 'course_student', true); ?>

                                   <?php if( !empty( $student )) : ?>
                                    <li class="students-feature">
					                    <i class="fa fa-users"></i>
					                    <span class="label"><?php echo esc_html__('Students','educavo');?></span>
					                    <span class="value"><?php echo esc_html( $student);?></span>
					                </li>
					            	<?php endif;?>

					                 <?php $assment = get_post_meta(get_the_ID(), 'course_assesment', true); ?>
                                    <?php if( !empty( $assment )) : ?>
                                   
                                        <li class="assessments-feature">
                                            <i class="fa fa-check-square-o"></i>
                                            <span class="label"><?php echo esc_html__('Assesment','educavo');?></span>
                                            <span class="value"><?php echo esc_html( $assment);?> </span>
                                        </li>
                                    <?php endif ; ?>                             
                                   
                                </ul>
                            </div>

                            <?php dynamic_sidebar( 'course-1'); ?>
                        </div>
                    </div>
                </div> <!-- .row -->
            </div> <!-- .rs-courses-details -->
    </div> <!-- .container -->
</div> <!--#main-content -->
<?php get_footer(); ?>