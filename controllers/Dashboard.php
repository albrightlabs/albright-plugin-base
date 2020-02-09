<?php namespace Albright\Base\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Dashboard Back-end Controller
 */
class Dashboard extends Controller
{
    public function index(){
      $this->pageTitle = 'Dashboard';
    }

    public function __construct()
    {
      parent::__construct();

      BackendMenu::setContextOwner('October.Backend');
      BackendMenu::setContextMainMenu('dashboard');
    }
}
