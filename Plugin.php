<?php namespace Albright\Base;

use App;
use Event;
use Backend;
use System\Classes\PluginBase;

/**
 * Base Plugin Information File
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
            'name'        => 'Base',
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
        $navigationManager->removeMainMenuItem('October.Cms', 'cms');
        $navigationManager->removeMainMenuItem('October.Backend', 'media');
      });
      Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
        $controller->addCss('/plugins/albright/base/assets/css/backend.css');
        if ($action == 'index' && $controller instanceof \Backend\Controllers\Index){
          return Backend::redirect('albright/base/dashboard');
        }
        if (!$controller instanceof \RainLab\Pages\Controllers\Index && !$controller instanceof \Cms\Controllers\Index && !$controller instanceof \Cms\Controllers\Media){
          $controller->addCss('/plugins/albright/base/assets/css/sidenav.css');
          $controller->addJs('/plugins/albright/base/assets/js/scripts.js');
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
            'Albright\Base\Components\MyComponent' => 'myComponent',
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
            'albright.base.some_permission' => [
                'tab' => 'Base',
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
            'base' => [
                'label'       => 'Base',
                'url'         => Backend::url('albright/base/mycontroller'),
                'icon'        => 'icon-leaf',
                'permissions' => ['albright.base.*'],
                'order'       => 500,
            ],
        ];
    }
}
