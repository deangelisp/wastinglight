<?php
function add_page_attributes_meta_options($post_obj) {

    global $post;
    $value = get_post_meta($post_obj->ID, 'title_on_meta', true); 


    if('page'==$post->post_type) {
        echo '<p class="post-attributes-label-wrapper menu-title-label-wrapper"><label class="post-attributes-label" for="menu_order">Show title</label></p><div>'
            .'<label><input type="checkbox"' . (!empty($value) ? ' checked="checked" ' : null) . ' value="1" name="title_on_meta" /> Show title in front of the featured image.</label>'
            .'</div>';
    }
}

add_action('page_attributes_misc_attributes', 'add_page_attributes_meta_options');

function extra_page_attributes_meta_options_save($post_id, $post, $update) {

      $post_type = 'page';
      if ( $post_type != $post->post_type ) {
        return;
      }
     
      if ( wp_is_post_revision( $post_id ) ) {
        return;
      }

    update_post_meta($post_id, 'title_on_meta', $_POST['title_on_meta']);


}

add_action( 'save_post', 'extra_page_attributes_meta_options_save', 10 , 3);