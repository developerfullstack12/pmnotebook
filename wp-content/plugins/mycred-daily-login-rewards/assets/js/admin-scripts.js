jQuery( document ).ready( function(){
  jQuery( "#mycred-rc-penalty" ).change( function() {
    if( this.checked ) {
      jQuery( '.mycred-rc-penalty-tab' ).fadeIn();
    }
    else
      jQuery( '.mycred-rc-penalty-tab' ).fadeOut();
  });

  jQuery( "#mycred-limited-time" ).change( function() {
    if( this.checked ) {
      jQuery( '.mycred-rc-limited-tab' ).fadeIn();
    }
    else
      jQuery( '.mycred-rc-limited-tab' ).fadeOut();
  });

  jQuery( "#mycred-repeatable" ).change( function() {
    if( this.checked ) {
      jQuery( '.mycred-rc-repeatable-tab' ).fadeIn();
    }
    else
      jQuery( '.mycred-rc-repeatable-tab' ).fadeOut();
  });

  jQuery( "#mycred-complete-calender" ).change( function() {
    if( this.checked ) {
      jQuery( '.mycred-rc-calender-tab' ).fadeIn();
    }
    else
      jQuery( '.mycred-rc-calender-tab' ).fadeOut();
  });

  //AJAX Add new day
  var $current = jQuery( ".mycred-daily-login-rewards-add-new-reward" );
  jQuery( document ).on( 'click', '.mycred-daily-login-rewards-add-new-reward', function(){
    var lastLi = $current.prev();
    var menuOrder = jQuery( lastLi ).find( '.menu-order' ).val();
    menuOrder = typeof menuOrder === 'undefined' ? 0 : menuOrder; 
    menuOrder++;
    var parentPostID = jQuery( '.post-id' ).val();
    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'mycred-create-calendar-day',
        post_id: parentPostID,
      },
      success: function( postID ) 
      {
        var content = '', ranksContent = '';

        //If manual ranks is active, Show ranks dropdown
        if( myCREDIsManualRank() )
        {
          ranksContent = `
          <div class="reward-type-row">
            <label for="reward-type-rank-${postID}">
                <input type="radio" id="reward-type-rank-${postID}" name="mycred-dlr-type-${postID}" class="reward-type" value="rank">
                <span class="dashicons dashicons-rank"></span>
                <span>Rank</span>
            </label>
            <div class="reward-type-form reward-type-rank-form" style="display:none">
                <select class="reward-rank">
                  ${mycredDLROptions( myCredDLRData.ranks )}
                </select>
            </div>
        </div>
          `;
        }

        content = `
        <li class="reward-row reward-${postID}">
            <input type="hidden" name="reward_id" class='reward-id' value="${postID}">
            <input type="hidden" name="current_post_id" class='current-post-id' value="${parentPostID}">
            <input type="hidden" name="order" class='menu-order' value="${menuOrder}">
            <div class="reward-header">
                <h3>Day ${menuOrder}</h3>
                <div class="delete-reward">
                    <span class="dashicons dashicons-no-alt"></span>
                </div>
            </div>
            <div class="mycred-reward-thumbnail">
                <input type="hidden" name="reward_thumbnail" value="">
                <span class="dashicons dashicons-camera"></span>
                <span class="dashicons dashicons-no-alt mycred-remove-reward-thumbnail" style="display: none;"></span>
            </div>
            <span class="mycred-reward-thumbnail-desc reward-field-desc">Click the image to edit or update.</span>
            <input type="text" placeholder="Label" class="reward-label" value="">
            <div class="reward-types-list">
                <div class="reward-type-row">
                    <label for="reward-type-none-${postID}">
                        <input type="radio" id="reward-type-none-${postID}" name="mycred-dlr-type-${postID}" class="reward-type" value="none" checked="checked">
                        <span class="dashicons dashicons-marker"></span>
                        <span>Nothing</span>
                    </label>
                    <div class="reward-type-form reward-type-none-form">
                        <span class="reward-nothing-desc">That's okay, a day that user needs to log in but without get rewarded.</span>
                    </div>
                </div>
                <div class="reward-type-row">
                    <label for="reward-type-points-${postID}">
                        <input type="radio" id="reward-type-points-${postID}" name="mycred-dlr-type-${postID}" class="reward-type" value="points">
                        <span class="dashicons dashicons-star-filled"></span>
                        <span>Points</span>
                    </label>
                    <div class="reward-type-form reward-type-points-form" style="display:none">
                        <input type="number" class="reward-points-amount" min="0" placeholder="0" value="0">
                        <select class="reward-points-type">
                          ${mycredDLROptions( myCredDLRData.pointTypes )}
                        </select>
                    </div>
                </div>
                <div class="reward-type-row">
                    <label for="reward-type-badge-${postID}">
                        <input type="radio" id="reward-type-badge-${postID}" name="mycred-dlr-type-${postID}" class="reward-type" value="badge">
                        <span class="dashicons dashicons-awards"></span>
                        <span>Badge</span>
                    </label>
                    <div class="reward-type-form reward-type-badge-form" style="display:none">
                        <select class="reward-badge">
                          ${mycredDLROptions( myCredDLRData.badges )}
                        </select>
                    </div>
                </div>
                ${ranksContent}
            </div>
        </li>`;

        jQuery( '.mycred-daily-login-rewards-add-new-reward' ).before( content );
    },
    })
  } )

  //Deleting Element
  jQuery( document ).on( 'click', '.delete-reward', function(){
    var currentRewardID = jQuery( this ).closest('li').find( '.reward-id' ).val();
    var menuOrder = jQuery( this ).closest('li').find( '.menu-order' ).val();
    var parentPostID = jQuery( '.post-id' ).val();

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data: {
        action: 'mycred-delete-calendar-day',
        reward_id: currentRewardID,
        menu_order: menuOrder,
        parent_post_id: parentPostID
      },
      success: function( response ) 
      {
        response = JSON.parse( response );
        var toBeDeleted = jQuery( '.reward-' + currentRewardID );
        if( response.response == 'success' )
        {
          //If posts left after removing current
          if( typeof response.post_ids !== 'undefined' )
            myCreddlrUpdateDays( response.post_ids.length, response.post_ids, menuOrder );

          toBeDeleted.remove();
        }
      }
    });
  })

  //Opening image dialog box
  jQuery( document ).on( 'click', '.mycred-reward-thumbnail', function(){
    var currentElement = jQuery( this );
    var image_window = wp.media( {
      title: 'Insert Media',
      library: {type: 'image'},
      multiple: false,
      button: {text: 'Insert'}
    } );

    image_window.open();

    image_window.on( 'select', function() {

      currentElement.find( '.thumbnail-img' ).remove();

      var attachment = image_window.state().get('selection').first().toJSON();

      currentElement.find( '[name="reward_thumbnail"]' ).val( attachment.id );

      currentElement.append( `<img src="${attachment.url}" class='thumbnail-img' />` );

      currentElement.addClass( 'has-thumbnail' );

      currentElement.find( '.mycred-remove-reward-thumbnail' ).show();
    })
  } );

  //Opening image dialog box
  jQuery( document ).find( '.completed-image' ).on( 'click', '.mycred-complete-thumbnail', function(){
    var currentElement = jQuery( this );
    var image_window = wp.media( {
      title: 'Insert Media',
      library: {type: 'image'},
      multiple: false,
      button: {text: 'Insert'}
    } );

    image_window.open();

    image_window.on( 'select', function() {

      currentElement.find( '.thumbnail-img' ).remove();

      var attachment = image_window.state().get('selection').first().toJSON();

      currentElement.find( '[name="completed_image"]' ).val( attachment.id );

      currentElement.append( `<img src="${attachment.url}" class='thumbnail-img' />` );

      currentElement.addClass( 'has-thumbnail' );

      currentElement.find( '.mycred-remove-reward-thumbnail' ).show();
    })
  } );

  //Reward Type
  jQuery( document ).on( 'change', '.reward-type', function(){
    var currentElement = jQuery( this );
    var label = currentElement.closest( '.reward-type-row' );
    var mainDiv = currentElement.closest( '.reward-types-list' );
      if( this.value == 'points' ) 
      {
        label.find( '.reward-type-form' ).slideDown();
        mainDiv.find( '.reward-type-rank-form' ).slideUp();
        mainDiv.find( '.reward-type-badge-form' ).slideUp();
      }
      if( this.value == 'badge' ) 
      {
        label.find( '.reward-type-form' ).slideDown();
        mainDiv.find( '.reward-type-rank-form' ).slideUp();
        mainDiv.find( '.reward-type-points-form' ).slideUp();
      }
      if( this.value == 'rank' ) 
      {
        label.find( '.reward-type-form' ).slideDown();
        mainDiv.find( '.reward-type-points-form' ).slideUp();
        mainDiv.find( '.reward-type-badge-form' ).slideUp();
      }
      if( this.value == 'none' ) 
      {
        mainDiv.find( '.reward-type-points-form' ).slideUp();
        mainDiv.find( '.reward-type-badge-form' ).slideUp();
        mainDiv.find( '.reward-type-rank-form' ).slideUp();
      }
  } );

  //Ajax Save All Rewards
  jQuery( document ).on( 'click', '#save-all-rewards', function(){

    var reward = {};
    rewardDay = jQuery( '.reward-row' );
    rewardDay.each( function( index, value ){
      rewardID = jQuery( this ).find( '.reward-id' ).val();
      rewardData = {};

      rewardData['label'] = jQuery( this ).find( '.reward-label' ).val();
      rewardData['thumbnail'] = jQuery( this ).find( '[name="reward_thumbnail"]' ).val();
      rewardData['rewardType'] = jQuery( this ).find( '.reward-type:checked' ).val();

      if( rewardData['rewardType'] == 'points' )
      {
        rewardData['pointAmount'] = jQuery( this ).find( '.reward-points-amount' ).val();
        rewardData['pointType'] = jQuery( this ).find( '.reward-points-type option:selected' ).val();
      }

      if( rewardData['rewardType'] == 'badge' )
        rewardData['badgeID'] = jQuery( this ).find( '.reward-badge option:selected' ).val();

        if( rewardData['rewardType'] == 'rank' )
          rewardData['rankID'] = jQuery( this ).find( '.reward-rank option:selected' ).val();

      reward[rewardID] = rewardData;

    } );

    jQuery.ajax({
      url: ajaxurl,
      type: 'POST',
      data:{
        action: 'mycred-dlr-save-all-rewards',
        reward: JSON.stringify( reward )
      },
      beforeSend: function()
      {
        jQuery('#save-all-rewards .mycred-animate-switch').css("display", "inherit");
      },
      success: function( response )
      {
        jQuery('#save-all-rewards .mycred-animate-switch').css("display", "none");

        console.log( 'Settings Saved.' );
      }
    })
  } )

} )

function myCreddlrUpdateDays( length, postIDs, menuOrder )
{
  for( var i = 0; i < length; i++ )
  {
    var nextElement = jQuery( '.reward-' + postIDs[i] );
    nextElement.find( '.menu-order' ).val( menuOrder );
    nextElement.find( '.reward-header > h3' ).html( `Day ${menuOrder}` );
    menuOrder++;
  }
}

function mycredDLROptions( args )
{
  var content = '';

  jQuery.each( args, function( key, value ){
    content += `<option value='${key}'>${value}</option>`;
  } );

  return content;
}

function myCREDIsManualRank()
{
  return myCredDLRData.isManualRank == 'true' ? true : false;
}