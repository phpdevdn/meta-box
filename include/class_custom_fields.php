<?php 
	class Custom_fields {
		public function __construct(){
			
		}
		public function thongtin(){
		add_action( 'admin_enqueue_scripts', $this->_thongtin_script());
		if(get_post_meta(get_the_id(),'info_player',true)){
			$info_player=get_post_meta(get_the_id(),'info_player',true);
		}else{
			$info_player='<ul>
			<li><span>Number : </span>...</li>
			</ul>';
		}
		
		echo '<label for="info-player" class="info-label">Insert infomation of player</label>';
		//echo '<textarea id="info-player" name="info_player" class="info-form">'.esc_attr($info_player).'</textarea>';
		$settings=array(
				'media_buttons'=>false,
				'textarea_name'=>'info_player',
				'editor_height'=>80,
				'teeny'=>true
			);
		wp_editor( $info_player, 'info-player', $settings );
		}
		public function gallery($post){
			add_action('admin_enqueue_scripts',$this->_gallery_script());
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
		private function _thongtin_script(){
 		wp_register_style( 'custom_fields', CUSTOM_FIELDS_DIR.'css/style.css');
		wp_enqueue_style('custom_fields');
		}
		private function _gallery_script(){
			wp_enqueue_media();
			wp_register_style( 'photo-style', CUSTOM_FIELDS_DIR.'css/gallery.css');
			wp_enqueue_style('photo-style');
			wp_register_script( 'photo-fields', CUSTOM_FIELDS_DIR.'js/scripts.js');
			wp_enqueue_script('photo-fields');
		}
	}
 ?>