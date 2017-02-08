<?php

/*  Register Scripts and Style */

function theme_register_scripts() {
    wp_enqueue_style( 'style-css', get_stylesheet_uri() );
    wp_enqueue_script('react', 'https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react.min.js');
    wp_enqueue_script('react-dom', 'https://cdnjs.cloudflare.com/ajax/libs/react/15.4.2/react-dom.min.js', array('react'));
    wp_enqueue_script('babel', 'https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.22.1/babel.min.js');
    wp_enqueue_script('axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js');
    wp_enqueue_script('main', get_template_directory_uri() . '/js/app.js', array('react', 'react-dom', 'babel', 'axios'));
}
add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );

function md_modify_jsx_tag( $tag, $handle, $src ) {
  if($handle !== 'main'){
      return $tag;
  }
  return '<script src="' . $src . '" type="text/babel"></script>' . "\n";
}
add_filter( 'script_loader_tag', 'md_modify_jsx_tag', 10, 3 );

/* Add post image support */
add_theme_support( 'post-thumbnails' );


/* Add custom thumbnail sizes */
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( '300x180', 300, 180, true );
}


function prepare_rest($data, $post, $request){
    $_data = $data->data;


    //Thumbnail
    $thumbnail_id = get_post_thumbnail_id( $post->ID );
    $thumbnail300x180 = wp_get_attachment_image_src( $thumbnail_id, '300x180' );
    $thumbnailMedium = wp_get_attachment_image_src( $thumbnail_id, 'medium' );

    //Categories
    $cats = get_the_category($post->ID);


    $_data['fi_300x180'] = $thumbnail300x180[0];
    $_data['fi_medium'] = $thumbnailMedium[0];
    $_data['cats'] = $cats;

    $data->data = $_data;

    return $data;
}
add_filter('rest_prepare_post', 'prepare_rest', 10, 3);
