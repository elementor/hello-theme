<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Create the column
add_filter( 'manage_upload_columns', function($columns) {
  $columns['bpFilesize'] = __('File Size');
  return $columns;
});

// Display the file size
add_action( 'manage_media_custom_column', function($column_name, $media_item) {
  if ('bpFilesize' != $column_name || !wp_attachment_is_image($media_item)) {
    return;
  }

  $bpFilesize = filesize(get_attached_file($media_item));
  $bpFilesize = size_format($bpFilesize, 2);

  echo $bpFilesize;
}, 10, 2 );

// Format the column width with CSS
add_action( 'admin_head', function() {
  echo '<style>.column-bpFilesize {width: auto;}</style>';
});