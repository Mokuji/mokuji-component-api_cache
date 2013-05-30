<?php namespace components\api_cache; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected
    $permissions = array(
      'twitter' => 1
    );
  
  protected function get_twitter($data, $params)
  {
    
    $params->{0}->validate('Twitter API method', array('required', 'string', 'in'=>array('user_timeline')))->back();
    
    return json_decode(mk('Component')
      ->helpers('api_cache')
      ->call('access_service', array('name'=>'twitter-1.1'))
      ->{$params->{0}->get('string')}($data)
      ->get());
    
  }
  
  protected function update_oauth2_credentials($data, $params)
  {
    
    $data->credentials->each(function($service_credentials){
      
      mk('Sql')
        ->table('api_cache', 'ServiceOauth2Credentials')
        ->pk($service_credentials->key())
        ->execute_single()
        ->merge($service_credentials->having('api_key', 'api_secret'))
        ->save();
      
    });
    
  }
  
}
