<?php

/*Plugin Name: my-custom-fields
Plugin URI: 
Description: create upload multiple images in post.
Version: 1.0
Author : Computer
*/
function register_cus_fields(){
	add_meta_box( 'photo-gallery','add photo in gallery','photo_cus_fields','post','side','low');
}
add_action('add_meta_boxes','register_cus_fields');
function photo_cus_fields($post){
  	$upload_link = esc_url( get_upload_iframe_src( 'image', $post->ID ) );
	// See if there's a media id already saved as post meta
	$your_img_id = get_post_meta( $post->ID, '_your_img_id', true );
	$your_img_id_arr = (!empty($your_img_id)) ? explode(",",$your_img_id) : array();
	//var_dump($your_img_id);
?>
<div class="custom-img-container">
    <?php if ( count($your_img_id_arr) > 0) : ?>
    	<?php foreach($your_img_id_arr as $value) : ?>
    	<?php $your_img_src = wp_get_attachment_image_src( $value, 'full' ); ?>
    	<div class="img_blk" data-id=<?php echo $value ?>>
		<span class="delete-custom-img">x</span>
		<img src="<?php echo $your_img_src[0] ?>" width="100px" height="100px"/>
    	</div>        
    <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Your add & remove image links -->
<p class="hide-if-no-js">
    <a class="upload-custom-img" 
       href="<?php echo $upload_link ?>">
        <?php _e('Set custom image') ?>
    </a>
</p>

<!-- A hidden input to set and post the chosen image id -->
<input class="custom-img-id" name="custom-img-id" type="hidden" value="<?php echo esc_attr( $your_img_id ); ?>" />
<?php 
	} 
	add_action( 'save_post', 'save_cus_fields' );
	function save_cus_fields($post_id){
		if(!isset($_POST['custom-img-id'])){
			return;
		}
		update_post_meta( $post_id, '_your_img_id', $_POST['custom-img-id'] );
	}
	function test_plugin(){
		echo "test ok";
	}
	function my_photo_galerry($id_post,$name){
		$my_img_id = get_post_meta( $id_post,$name, true );
		$my_img_arr = (!empty($my_img_id)) ? explode(",",$my_img_id) : array();
		if(count($my_img_arr) > 0) :
			foreach($my_img_arr as $value) :
				$my_img_src= wp_get_attachment_image_src( $value,'full');
				echo "<img src='".$my_img_src[0]."'>";
			endforeach;
		endif;
	}
	function register_scripts_cus_fields(){
		wp_enqueue_media();
		wp_register_style( 'photo-style', plugins_url('css/style.css',__FILE__));
		wp_enqueue_style('photo-style');
		wp_register_script( 'photo-fields', plugins_url('js/scripts.js',__FILE__));
		wp_enqueue_script('photo-fields');
	}
	add_action('admin_enqueue_scripts','register_scripts_cus_fields');
?>