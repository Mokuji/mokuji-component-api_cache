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
        
        //In case it has no oauth2 credentials, make them now.
        ->is('set', function($service){
          if($service->oauth2_credentials->is_empty()){
            $service->oauth2_credentials->set(
              mk('Sql')->model('api_cache', 'ServiceOauth2Credentials')
                ->set(array(
                  'service_id' => $service->id,
                  'api_key' => '',
                  'api_secret' => ''
                ))
                ->save()
            );
          }
        })
        
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
