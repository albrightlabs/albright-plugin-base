<?php namespace Albrightlabs\Brand;

use App;
use Event;
use Backend;
use System\Classes\PluginBrand;

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
      Event::listen('backend.menu.extendItems', function($navigationManager) {
        // $navigationManager->removeMainMenuItem('October.Cms', 'cms');
        $navigationManager->removeMainMenuItem('October.Backend', 'media');
      });
      Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
        if (strpos($_SERVER['REQUEST_URI'], 'backend/cms') == false) {
          $controller->addCss('/plugins/albrightlabs/brand/assets/css/backend.css');
          if ($action == 'index' && $controller instanceof \Backend\Controllers\Index){
            return Backend::redirect('albrightlabs/brand/dashboard');
          }
          if (!$controller instanceof \RainLab\Pages\Controllers\Index && !$controller instanceof \Cms\Controllers\Index && !$controller instanceof \Cms\Controllers\Media){
            $controller->addCss('/plugins/albrightlabs/brand/assets/css/sidenav.css');
            $controller->addJs('/plugins/albrightlabs/brand/assets/js/scripts.js');
          }
        } else {
          $controller->addCss('/plugins/albrightlabs/brand/assets/css/cms.css');
        }
      });
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Albrightlabs\Brand\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'albrightlabs.brand.some_permission' => [
                'tab' => 'Brand',
                'label' => 'Some permission'
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        return []; // Remove this line to activate

        return [
            'brand' => [
                'label'       => 'Brand',
                'url'         => Backend::url('albrightlabs/brand/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['albrightlabs.brand.*'],
                'order'       => 500,
            ],
        ];
    }
}
