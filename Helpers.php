<?php namespace components\api_cache; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $permissions = array(
      'access_service' => 0
    );
  
  protected function access_service($options)
  {
    
    switch ($options->name->get()) {
      
      case 'twitter-1.1':
        
        mk('Component')->load('api_cache', 'classes\\TwitterAPI', false);
        
        return new classes\TwitterAPI(mk('Sql')
          ->table('api_cache', 'Services')
          ->where('name', 'twitter-1.1')
          ->execute_single());
      
      default:
        throw new \exception\Programmer('Unknown service name "%s".', $options->name->get());
      
    }
    
  }
  
}
