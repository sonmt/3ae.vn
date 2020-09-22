<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/9/2017
 * Time: 3:00 PM
 */

namespace App\Ultility;


class Facebook
{
     private $appId = '887742841384108';
     private $appSecret = 'ae55c15a30ac02ae9791218508c684c2';
     private $defaultGraphVersion = 'v2.11';

     public function getAppId() {
         return $this->appId;
     }

    public function getAppSecret() {
        return $this->appSecret;
    }

    public function getDefaultGraphVersion() {
        return $this->defaultGraphVersion;
    }
}
