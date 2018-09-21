<?php

namespace Drupal\custom_block\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CustomController extends ControllerBase {

  public function content($node, $uid) {
    $user = \Drupal\user\Entity\User::load($uid);
    $user->field_user_bookmark[] = ['target_id' => $node];

    $user->save();
    $acc = \Drupal::currentUser()->id();


    return $this->redirect('user.page');


  }



}