<?php namespace components\api_cache; if(!defined('TX')) die('No direct access.');

//Make sure we have the things we need for this class.
mk('Component')->check('update');
mk('Component')->load('update', 'classes\\BaseDBUpdates', false);

class DBUpdates extends \components\update\classes\BaseDBUpdates
{
  
  protected
    $component = 'api_cache',
    $updates = array(
      '0.0.1-alpha' => '0.0.2-alpha'
    );
  
  public function install_0_0_1_alpha($dummydata, $forced)
  {
    
    if($forced === true){
      mk('Sql')->query('DROP TABLE IF EXISTS `#__api_cache_services`');
      mk('Sql')->query('DROP TABLE IF EXISTS `#__api_cache_service_oauth2_credentials`');
      mk('Sql')->query('DROP TABLE IF EXISTS `#__api_cache_service_queries`');
    }
    
    mk('Sql')->query('
      CREATE TABLE `#__api_cache_services` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `title` varchar(255) NOT NULL,
        `cache_time` int(10) unsigned NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`id`),
        UNIQUE KEY `name` (`name`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    mk('Sql')->query('
      CREATE TABLE `#__api_cache_service_oauth2_credentials` (
        `service_id` int(10) unsigned NOT NULL,
        `api_key` varchar(255) NOT NULL,
        `api_secret` varchar(255) NOT NULL,
        `bearer_token` varchar(255) NULL DEFAULT NULL,
        PRIMARY KEY (`service_id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    mk('Sql')->query('
      CREATE TABLE `#__api_cache_service_queries` (
        `service_id` int(10) unsigned NOT NULL,
        `query_hash` varchar(255) NOT NULL,
        `query` text NOT NULL,
        `response` longtext NOT NULL,
        `dt_executed` timestamp NULL DEFAULT NULL,
        `executed` int(10) unsigned NOT NULL DEFAULT \'0\',
        `requested` int(10) unsigned NOT NULL DEFAULT \'0\',
        PRIMARY KEY (`service_id`, `query_hash`),
        INDEX `dt_executed` (`dt_executed`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8
    ');
    
    mk('Sql')
      ->model('api_cache', 'Services')
      ->set(array(
        'name' => 'twitter-1.1',
        'title' => 'Twitter API 1.1',
        'cache_time' => 90
      ))
      ->save();
    
    //Queue self-deployment with CMS component.
    $this->queue(array(
      'component' => 'cms',
      'min_version' => '0.4.0'
      ), function($version){
          
          mk('Component')->helpers('cms')->_call('ensure_pagetypes', array(
            array(
              'name' => 'api_cache',
              'title' => 'API cache'
            ),
            array(
              'cache_control' => 'SETTINGS'
            )
          ));
          
        }); //END - Queue CMS
    
  }
  
}

