<?php namespace components\api_cache\models; if(!defined('TX')) die('No direct access.');

class ServiceQueries extends \dependencies\BaseModel
{
  
  protected static
    $table_name = 'api_cache_service_queries';
  
  public function bump_requests()
  {
    
    $this->requested->set(
      $this->requested->get('int')+1
    );
    
    return $this;
    
  }
  
  public function bump_executes()
  {
    
    $this->executed->set(
      $this->executed->get('int')+1
    );
    
    return $this;
    
  }
  
  public function get_service()
  {
    return mk('Sql')
      ->table('api_cache', 'Services')
      ->pk($this->service_id)
      ->execute_single();
  }
  
  public function get_is_valid_cache()
  {
    
    if($this->dt_executed->is_empty())
      return false;
    
    if($this->response->is_empty())
      return false;
    
    $time = $this->service->cache_time->get('int');
    return strtotime($this->dt_executed->get()) + $time > time();
    
  }
  
}
