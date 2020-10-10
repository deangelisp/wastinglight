<?php
add_action( 'add_meta_boxes', 'meta_video_box' );
function meta_video_box(){
    add_meta_box( 'meta_video', 'Featured Video', 'meta_inner_video', 'page', 'normal', 'default' );
}
function meta_inner_video($post){
    $video_box = get_post_meta( $post->ID, 'video_box', true ) ? get_post_meta( $post->ID, 'video_box', true ) : false;
    $title_video = $video_box ? get_the_title($video_box) : '';
    wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );


?>
<style>

    #video_project *{ box-sizing: border-box; }  

    .remove-video{
        display: none;
    }

    .video_box_title{
        display: none;
        padding: 10px;
        background-color: whitesmoke;
    }
    .video_box_title span.dashicons{
        margin-right: 10px;
        color: #82878c;
    }

    .content-video.has-video .remove-video,
    .content-video.has-video .video_box_title{display: block;}.

</style>
<section id="content-video" class="content-video <?php echo $video_box ? 'has-video' : ''; ?>">
    <?php
    echo '<p class="video_box_title" id=""><span class="dashicons dashicons-video-alt2"></span>';
    echo '<span id="video_box_title">' . $title_video  . '</span>';
    echo '<p>';
    ?>
    <input type="hidden" name="video_box" id="video_box" value="<?php echo $video_box ?>" />
    <p class="submitbox" style="display: flex;    justify-content: space-between; ">
        <a href="#" id="add-video" data-text="Excluir">Set featured video</a>
        <a href="#" id="remove-video" class="remove-video submitdelete">Remove featured video</a>
    </p>
</section>
<script>
    window.addEventListener('load', function(){
        jQuery('#add-video').click(function(){
            var count = jQuery('.item-video').length;

            selectvideo(count);
        });

        jQuery('body').on('click','#remove-video',removeImagem);
    });

    var custom_uploader;

    function selectvideo(_imagem) {

        //            var element = _imagem;            

        custom_uploader = wp.media.frames.file_frame = wp.media({
            multiple: false,
            library: {
                type: 'video'
            },
            //                elemento: element.attributes.mira.value
        });

        custom_uploader.on('select', function() {


            var attachment = custom_uploader.state().get('selection').toJSON();


            attachment = attachment[0];

            console.log(attachment);

            jQuery('#video_box').val(attachment.id);
            jQuery('#video_box_title').html(attachment.title);
            jQuery('#content-video').addClass('has-video');     


        });

        custom_uploader.open();

    }

    function removeImagem(){
        jQuery('#video_box').val('');
        jQuery('#video_box_title').html('');
        jQuery('#content-video').removeClass('has-video'); 
    }
</script>
<?php
}
add_action( 'save_post', 'save_video_project' );
function save_video_project( $post_id  ){
    if(isset($_POST["video_box"])){
        update_post_meta( $post_id, 'video_box', $_POST["video_box"] );
    }
}