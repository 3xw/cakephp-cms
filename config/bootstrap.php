<?php
use Cake\Core\Configure;

Configure::load('Trois/Cms.cms');
try {
    Configure::load('cms','default',true);
} catch (\Exception $e) {

}
