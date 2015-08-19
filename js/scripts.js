jQuery(function($){

  // Set all variables to be used in scope
  var frame,
      //metaBox = $('#meta-box-id.postbox')
      metaBox = $('#photo-gallery'), // Your meta box id here
      addImgLink = metaBox.find('.upload-custom-img'),
      delImgLink = metaBox.find( '.delete-custom-img'),
      imgContainer = metaBox.find( '.custom-img-container'),
      imgIdInput = metaBox.find( '.custom-img-id' ),
      att_ids=[];
  if(imgIdInput.val()){
    att_ids=imgIdInput.val().split(',');
  }   
  console.log(att_ids);           
  // ADD IMAGE LINK
  addImgLink.on( 'click', function( event ){
    
    event.preventDefault();
    
    // If the media frame already exists, reopen it.
    if ( frame ) {
      frame.open();
      return;
    }
    
    // Create a new media frame
    frame = wp.media({
      title: 'Select or Upload Media',
      button: {
        text: 'Use this media'
      },
      multiple: true  // Set to true to allow multiple files to be selected
    });

    
    // When an image is selected in the media frame...
    frame.on( 'select', function() {
      
      // Get media attachment details from the frame state
      var attachment = frame.state().get('selection').first().toJSON();
      var attachment_1 = frame.state().get('selection').toJSON();
      console.log(attachment_1);
      // Send the attachment URL to our custom image input field.
      $.each(attachment_1,function(index,value){
        var $photo_div=$("<div></div>").addClass('img_blk').attr({ 'data-id': value.id });
        var $photo_butt=$("<span></span>").addClass('delete-custom-img').text('x');
        var $photo=$("<img>").attr({
                    'src':value.url,
                    'height':'100px',
                    'width':'100px'
                  });
        $photo_div.append($photo_butt,$photo);
        imgContainer.append($photo_div);
        att_ids.push(value.id.toString());
      });
      //imgContainer.append( '<img src="'+attachment.url+'" alt="" style="max-width:100%;"/>' );
      // Send the attachment id to our hidden input
      imgIdInput.val( att_ids.toString() );
       // Hide the add image link
      //addImgLink.addClass( 'hidden' );

      // Unhide the remove image link
      //delImgLink.removeClass( 'hidden' );
    });

    // Finally, open the modal on click
    frame.open();
  });
  
  
  // DELETE IMAGE LINK
  imgContainer.on( 'click','.delete-custom-img', function( event ){
    // Clear out the preview image
    var $pt_div=$(this).parent('.img_blk');
    var $pt_id=$pt_div.attr('data-id');
    console.log($pt_id);
    $pt_div.remove();
    var i = att_ids.indexOf($pt_id);
    console.log(i);
    att_ids.splice(i,1);
    imgIdInput.val( att_ids.toString() );
  });

});