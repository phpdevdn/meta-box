<?php 
	/*
	Plugin Name: custom fields my theme
	Author: Computer
	Description: tao custom fields trong post
	Author URI: http://localhost/wordpress
	*/
	/** khai bao custom fields**/
	define('CUSTOM_FIELDS_DIR',plugins_url('/',__FILE__));
	require_once plugin_dir_path(__FILE__).'include/class_custom_fields.php';
	
	function mytheme_meta_box()
	{
 		add_meta_box( 'thong-tin', 'Thông tin cầu thủ', 'mytheme_thong_tin_output', 'post', 'normal','high' );
		add_meta_box( 'photo-gallery','add photo in gallery','photo_cus_fields','post','side','low');
	}
	add_action( 'add_meta_boxes', 'mytheme_meta_box' );
	function mytheme_thong_tin_output(){
		$fields= new Custom_fields;
		$fields->thongtin();
	}
	function photo_cus_fields($post){
		$fields_1=new Custom_fields;
		$fields_1->gallery($post);		
	}	
	function mytheme_info_player_save( $post_id )
	{
	 //$info_player = sanitize_text_field( $_POST['info_player'] );
	if(isset($_POST['info_player'])){
		update_post_meta( $post_id, 'info_player',$_POST['info_player'] );
	}
 	 
	 if(isset($_POST['custom-img-id'] )){
			update_post_meta( $post_id, '_your_img_id', $_POST['custom-img-id'] );
		}
	}
	add_action( 'save_post', 'mytheme_info_player_save' );
	if(!function_exists('my_photo_galery')){
		function my_photo_galery($id_post,$name){
			$my_img_id = get_post_meta( $id_post,$name, true );
			$my_img_arr = (!empty($my_img_id)) ? explode(",",$my_img_id) : array();
			return $my_img_arr;
		}
	}
	
  ?>