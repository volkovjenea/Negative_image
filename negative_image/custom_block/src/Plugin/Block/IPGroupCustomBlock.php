<?php

namespace Drupal\custom_block\Plugin\Block;


use Drupal\Core\Block\BlockBase;
use Drupal\Component\Render\FormattableMarkup;
use Drupal\file\Entity\File;


/**
 * Provides a 'Custom' Block.
 *
 * @Block(
 *   id = "ipgroup_customblock",
 *   admin_label = @Translation("IpGroupCustom Block"),
 *   category = @Translation("Blocks"),
 * )
 */
class IPGroupCustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */

  public function build() {

    $my_title = \Drupal::config('custom_block.adminsettings')->get('title_field');
    $my_body = \Drupal::config('custom_block.adminsettings')->get('body_field');
//    $my_image = \Drupal::config('custom_block.adminsettings')->get('image');

    $file=File::load(8);

    $variables = array(
      'style_name' => 'thumbnail',
      'uri' => $file->getFileUri(),
    );

    // The image.factory service will check if our image is valid.
    $image = \Drupal::service('image.factory')->get($file->getFileUri());
    if ($image->isValid()) {
      $variables['width'] = $image->getWidth();
      $variables['height'] = $image->getHeight();
    }
    else {
      $variables['width'] = $variables['height'] = NULL;
    }

    $logo_render_array = [
      '#theme' => 'image_style',
      '#width' => $variables['width'],
      '#height' => $variables['height'],
      '#style_name' => $variables['style_name'],
      '#uri' => $variables['uri'],
    ];
    $renderer = \Drupal::service('renderer');
    $renderer->addCacheableDependency($logo_render_array, $file);

    $url = \Drupal\Core\Url::fromUri(file_create_url($file->getFileUri()))->toString();


/*    $result = new FormattableMarkup(
      '<span class="fullname-wrapper">
        <span class="title-field"><p>Title: @title</p></span>
        <span class="body-field"><p>Body:@body</p></span>
        <img src="@image"></img>
      </span>',
      [
        '@title' => $my_title,
        '@body' => $my_body,
        '@image' => $url,
      ]
    );*/

    return [
      '#theme' => 'custom_template',
      '#title' => $my_title,
      '#body' => $my_body,
      '#image'=>$url,
    ];
  }
}
