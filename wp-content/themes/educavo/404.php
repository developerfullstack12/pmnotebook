<?php
/**
 * @author  rs-theme
 * @since   1.0
 * @version 1.0 
 */
wp_head();  
global $educavo_option; ?>

<div class="page-error">
    <div class="container">
        <div id="content">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">    
                    <section class="error-404 not-found">    
                        <div class="page-content">
                            <h2>
                                <span>
                                    
                                    <?php
                                        if(!empty($educavo_option['title_404'])){
                                            echo esc_html($educavo_option['title_404']);
                                        }
                                        else{
                                            echo esc_html__( '404', 'educavo' ); 
                                        }
                                    ?>
                                </span>                      
                                <?php

                                 if(!empty($educavo_option['text_404'])){
                                      echo esc_html($educavo_option['text_404']);
                                 }
                                 else{
                                  echo esc_html__( 'oops! page not found', 'educavo' ); }
                                 ?>
                            </h2>
                            <a class="readon" href="<?php echo esc_url( home_url('/') ); ?>">
                                <?php
                                 if(!empty($educavo_option['back_home'])){
                                     echo esc_html($educavo_option['back_home']);
                                 }
                                 else{
                                     esc_html_e('Or back to homepage', 'educavo'); 
                                  }
                                ?>
                            </a>
                        </div><!-- .page-content -->
                    </section><!-- .error-404 -->    
                </main><!-- #main -->
            </div><!-- #primary -->
        </div>
    </div>   
</div> <!-- .page-error -->
<?php
wp_footer();
