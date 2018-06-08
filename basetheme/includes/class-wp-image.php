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
   * @param string|array $srcset Any other sizes to get as well the base size.
   *                             These sizes will be added as srcset URIs.
   * @param string|array $sizes  The sizes attribute to place on the image.
   * @return string
   */
  public function getAttributes( $srcset = array(), $sizes = array() ) {
    // Convert strings into valid array formats
    if ( is_string( $srcset ) && strpos( $srcset, "," ) ) {
      $srcset = explode( ",", $srcset );
    }
    if ( is_string( $sizes ) && strpos( $sizes, "," ) ) {
      $sizes = explode( ",", $sizes );
    }
    
    if ( !empty( $srcset ) && !is_array( $srcset ) ) {
      $srcset = array( $srcset );
    }
    if ( !empty( $sizes ) && !is_array( $sizes ) ) {
      $sizes = array( $sizes );
    }

    if ( empty( $srcset ) || empty( $sizes ) ) {
      // Without both parts, the srcset will not work
      return sprintf(
        'src="%s" alt="%s" width="%s" height="%s"',
        $this->src,
        $this->alt,
        $this->width,
        $this->height
      );
    } else {
      // If we have both, build a srcset and sizes attribute
      array_unshift( $srcset, $this->_size );

      foreach ($srcset as $key => &$value) {
        $srcsetImageObject = wp_get_attachment_image_src( $this->ID, trim( $value ) );
        $value = $srcsetImageObject[0] . ' ' . $srcsetImageObject[1] . 'w';

        unset( $value );
      }

      return sprintf(
        'src="%s" srcset="%s" sizes="%s" alt="%s" width="%s" height="%s"',
        $this->src,
        implode( ',', $srcset ),
        implode( ',', $sizes ),
        $this->alt,
        $this->width,
        $this->height
      );
    }
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

    $imageObject = wp_get_attachment_image_src( $this->ID, $this->_size );

    if ( $imageObject ) {
      $this->src = $imageObject[0];
      $this->alt = get_post_meta( $this->ID, '_wp_attachment_image_alt', true );
      $this->width = $imageObject[1];
      $this->height = $imageObject[2];
    } else {
      $this->src = '';
      $this->alt = '';
      $this->width = 0;
      $this->height = 0;
    }

    return $this;
  }
}
