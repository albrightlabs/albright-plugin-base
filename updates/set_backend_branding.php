<?php namespace AlbrightLabs\Base\Updates;

use Db;
use October\Rain\Database\Updates\Migration;

class SetBackendBranding extends Migration
{
    public function up()
    {
      Db::table('system_settings')->insert(
        ['item' => 'backend_brand_settings', 'value' => '{"app_name":"Albright Labs","app_tagline":"Albright Labs","primary_color":"#222222","secondary_color":"#3498db","accent_color":"#3498db","menu_mode":"inline","custom_css":""}']
      );
    }

    public function down(){

    }
}
