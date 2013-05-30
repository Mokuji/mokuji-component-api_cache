<?php namespace components\api_cache; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected function cache_control()
  {
    
    return array(
      
      'twitter_credentials' => mk('Sql')
        ->table('api_cache', 'Services')
        ->where('name', 'twitter-1.1')
        ->execute_single()
        ->oauth2_credentials,
      
      'services' => DEBUG ? mk('Sql')
        ->table('api_cache', 'Services')
        ->order('name')
        ->execute() : null,
      
      'queries' => DEBUG ? mk('Sql')
          ->table('api_cache', 'ServiceQueries')
          ->order('dt_executed', 'DESC')
          ->execute() : null
      
    );
    
  }
  
}
