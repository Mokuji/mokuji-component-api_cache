<?php namespace components\api_cache; if(!defined('TX')) die('No direct access.'); ?>

<p class="settings-description"><?php __($names->component, 'CACHE_CONTROL_VIEW_DESCRIPTION'); ?></p>

<form id="edit_api_cache_oauth2_credentials_form" class="form edit-api-cache-oauth2-credentials-form" method="PUT" action="<?php echo url('rest=api_cache/oauth2_credentials', true); ?>">
  
  <div class="ctrlHolder">
    <label for="l_twitter_credentials_api_key"><?php __($names->component, 'Twitter API key'); ?></label>
    <input type="text" id="l_twitter_credentials_api_key" name="credentials[<?php echo $data->twitter_credentials->service_id; ?>][api_key]" value="<?php echo $data->twitter_credentials->api_key; ?>" />
    
    <label for="l_twitter_credentials_api_secret"><?php __($names->component, 'Twitter API secret'); ?></label>
    <input type="text" id="l_twitter_credentials_api_secret" name="credentials[<?php echo $data->twitter_credentials->service_id; ?>][api_secret]" value="<?php echo $data->twitter_credentials->api_secret; ?>" />
  </div>
  
  <div class="buttonHolder">
    <input type="submit" class="primaryAction button black" value="<?php __('Save'); ?>" />
  </div>
  
</form>

<script type="text/javascript">
jQuery(function($){
  $('#edit_api_cache_oauth2_credentials_form').restForm();
});
</script>

<?php if(DEBUG){ ?>

  Example code
<pre>
$tweets = json_decode(
  mk('Component')
    ->helpers('api_cache')
    ->call('access_service', array('name'=>'twitter-1.1'))
    ->user_timeline(array('screen_name'=>'mokujidev','count'=>2))
    ->get('string')
);
</pre>

  <?php $data->services->not('empty', function($services)use($names){
    echo $services->as_table(array(
      __($names->component, 'Service', true) => 'title',
      __($names->component, 'Key', true) => 'name',
      __($names->component, 'Cache time', true) => function($r)use($names){ return $r->cache_time->get().' '. __($names->component, 'Seconds', true, 'l'); }
    ));
  });

  $data->queries->not('empty', function($queries)use($names){
    echo $queries->as_table(array(
      __($names->component, 'Service', true) => function($r){ return $r->service->title; },
      __($names->component, 'Query', true) => 'query',
      __($names->component, 'Last executed', true) => 'dt_executed',
      __($names->component, 'Execute counter', true) => 'executed',
      __($names->component, 'Request counter', true) => 'requested',
    ));
  });

} //END Debug part