<?php namespace Albrightlabs\Brand;

use App;
use Event;
use Backend;
use Backend\Models\BrandSetting as Settings;
use System\Classes\PluginBase;

/**
 * Brand Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * @var bool Plugin requires elevated permissions.
     */
    public $elevated = true;

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Brand',
            'description' => 'Provides Albright Labs client features.',
            'author'      => 'Albright Labs',
            'icon'        => 'icon-star-o'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
      if(!App::runningInBackend()){
        return;
      }
      Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
        if (strpos($_SERVER['REQUEST_URI'], 'backend/cms') == false) {
          $controller->addCss('/plugins/albrightlabs/brand/assets/css/backend.css');
          if (
                !$controller instanceof \RainLab\Pages\Controllers\Index &&
                !$controller instanceof \Cms\Controllers\Index &&
                !$controller instanceof \Cms\Controllers\Media &&
                Settings::get('sidenav_mode') == 'top'
            ){
            $controller->addCss('/plugins/albrightlabs/brand/assets/css/sidenav.css');
            $controller->addJs('/plugins/albrightlabs/brand/assets/js/scripts.js');
          }
        } else {
          $controller->addCss('/plugins/albrightlabs/brand/assets/css/cms.css');
        }
      });

      // Extend all backend form usage for AlbrightLabs.Note note model
      Event::listen('backend.form.extendFields', function($widget) {
          if (!$widget->model instanceof \Backend\Models\BrandSetting) {
              return;
          }
          $widget->addTabFields([
              'sidenav_mode' => [
                  'label' => 'Sidenav Mode',
                  'tab' => 'backend::lang.branding.navigation',
                  'type' => 'radio',
                  'options' => [
                      'side' => 'Side',
                      'top' => 'Top',
                  ],
              ],
          ]);
      });
    }
}
