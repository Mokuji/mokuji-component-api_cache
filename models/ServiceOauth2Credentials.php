<?php namespace components\api_cache\models; if(!defined('TX')) die('No direct access.');

class ServiceOauth2Credentials extends \dependencies\BaseModel
{
  
  protected static
    $table_name = 'api_cache_service_oauth2_credentials';
  
  public function get_service()
  {
    return mk('Sql')
      ->table('api_cache', 'Services')
      ->pk($this->service_id)
      ->execute_single();
  }
  
}
