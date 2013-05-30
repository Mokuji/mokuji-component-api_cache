<?php namespace components\api_cache\models; if(!defined('TX')) die('No direct access.');

class Services extends \dependencies\BaseModel
{
  
  protected static
    $table_name = 'api_cache_services';
  
  public function get_oauth2_credentials()
  {
    
    return mk('Sql')
      ->table('api_cache', 'ServiceOauth2Credentials')
      ->pk($this->id)
      ->execute_single();
    
  }
  
}
