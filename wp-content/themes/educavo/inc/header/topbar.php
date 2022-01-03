<?php
/*
Header Style
*/

global $educavo_option;
$post_meta_topbar = '';

//check individual header 
if(is_page() || is_single()){
	$post_meta_topbar = get_post_meta(get_the_ID(), 'topbar_select', true);
	
}elseif(is_home() && !is_front_page() || is_home() && is_front_page()){
	$post_meta_topbar = get_post_meta(get_queried_object_id(), 'topbar_select', true);
}
elseif(function_exists('woocommerce')){
	if(is_shop()):
		$your_shop_page = get_post( wc_get_page_id( 'shop' ) );
		$post_meta_topbar = get_post_meta($your_shop_page->ID, 'topbar_select', true);
	endif;	
}

if(!empty($educavo_option['enable_global'])){	
    $topbar_style    =  !empty($educavo_option['topbar_layout']) ? $educavo_option['topbar_layout'] : '';
	if($topbar_style == 'style1'){		 
		get_template_part('inc/header/top-head/top-head-one'); 		
	}
	if($topbar_style == 'style2'){		 
		get_template_part('inc/header/top-head/top-head-two'); 	
	}
	if($topbar_style == 'style3'){		
		get_template_part('inc/header/top-head/top-head-three');       
	}	 
	if($topbar_style == 'style4'){		
		get_template_part('inc/header/top-head/top-head-four');        
	}	   
}
else{
	if($post_meta_topbar !=''){	 	
		if($post_meta_topbar == 'topbar1'){		 
			get_template_part('inc/header/top-head/top-head-one');				
		}
		if($post_meta_topbar == 'topbar2'){		 
			get_template_part('inc/header/top-head/top-head-two');		
		}
		if($post_meta_topbar == 'topbar3'){		
			get_template_part('inc/header/top-head/top-head-three');       
		}
		if($post_meta_topbar == 'topbar4'){		
			get_template_part('inc/header/top-head/top-head-four');       
		}	  
	} 

	elseif(!empty($educavo_option['topbar_layout'])){	   
		$topbar_style = $educavo_option['topbar_layout'];
		if($topbar_style == 'style1'){		 
			get_template_part('inc/header/top-head/top-head-one'); 		
		}
		if($topbar_style == 'style2'){		 
			get_template_part('inc/header/top-head/top-head-two'); 	
		}
		if($topbar_style == 'style3'){		
			get_template_part('inc/header/top-head/top-head-three');       
		}	 
		if($topbar_style == 'style4'){		
			get_template_part('inc/header/top-head/top-head-four');        
		}	   
	}
	else {
		get_template_part('inc/header/top-head/top-head-two'); 
	}	 
}


