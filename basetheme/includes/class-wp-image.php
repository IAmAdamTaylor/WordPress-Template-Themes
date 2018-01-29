<?php

/**
 * Wrapper around a WordPress media library image.
 * 
 */
class WP_Image {
  /**
   * The image ID.
   * @var integer
   */
  public $ID;

  /**
   * The size label of the image.
   * @var string
   */
  private $_size;

  /**
   * The image source URI.
   * @var string
   */
  public $src;

  /**
   * The image alt text.
   * @var string
   */
  public $alt;

  /**
   * The image width in pixels.
   * @var integer
   */
  public $width;

  /**
   * The image height in pixels.
   * @var integer
   */
  public $height;

  function __construct( $image_id, $size = 'full' ) {
    $this->ID = $image_id;
    $this->setSize( $size );
  }

  /**
   * Check if the image exists in the WordPress media library.
   * @return boolean
   */
  public function exists() {
    return '' !== $this->src;
  }

  /**
   * Get the set of attributes required to show this image on an <img> tag.
   * @return string
   */
  public function getAttributes() {
    return sprintf(
      'src="%s" alt="%s" width="%s" height="%s"',
      $this->src,
      $this->alt,
      $this->width,
      $this->height
    );
  }

  /**
   * Get the size of the image.
   * @return string|array
   */
  public function getSize() {
    return $this->_size;
  }

  /**
   * Set the size of the image.
   * @param  string|array $size Any valid image size, or an array of 
   *                            width and height values in pixels (in that order).
   * @return self
   */
  public function setSize( $size ) {
    $this->_size = $size;

    $image_object = wp_get_attachment_image_src( $this->ID, $this->_size );

    if ( $image_object ) {
      $this->src = $image_object[0];
      $this->alt = get_post_meta( $this->ID, '_wp_attachment_image_alt', true );
      $this->width = $image_object[1];
      $this->height = $image_object[2];
    } else {
      $this->src = '';
      $this->alt = '';
      $this->width = 0;
      $this->height = 0;
    }

    return $this;
  }
}
