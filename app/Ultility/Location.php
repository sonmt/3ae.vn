<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/6/2017
 * Time: 2:15 PM
 */

namespace App\Ultility;


class Location
{
      private $locationMenu = array(
          'menu-top' => 'menu trên cùng',
          'menu-footer' => 'menu cuối trang',
          'footer' => 'footer',
          'menu-food' => 'Menu thưc đơn'
      );

      public function getLocationMenu() {
          return $this->locationMenu;
      }
}
