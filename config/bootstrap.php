<?php
use Cake\Core\Configure;

Configure::load('Trois/Cms.cms');
try {
    Configure::load('cms','default',false);
} catch (\Exception $e) {

}
