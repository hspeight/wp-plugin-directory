<?php
/*
Plugin Name: wp-plugin-directory
Plugin URI:  https://temporalyou.com/
Description: Lists details of all plugins available at https://wordpress.org/plugins/
Version:     1.0
Author:      hspeight
Author URI:  https://temporalyou.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

wp-plugin-directory is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

wp-plugin-directory is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with wp-plugin-directory. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

//require "inc/Form.php";
require "inc/Form.php";




class WP_Plugin_Directory {
  public function __construct() {
    if (is_admin()) {
      register_activation_hook(__FILE__, array(&$this, 'wppd_activate'));
      register_deactivation_hook(__FILE__, array(&$this, 'wppd_deactivate'));
      add_action('admin_menu',array(&$this,'test_plugin_setup_menu'));
      //add_action('admin_init',function() {
      //register_setting('md_things_plugin','md_things_plugin');
    //});
    }
  }

  public function wppd_activate() {
    $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
    fwrite($myfile, "random");
    fwrite($myfile, "\n");
    fclose($myfile);
  }

  public function wppd_deactivate() {
    $myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
    fwrite($myfile, "plugin deactivated");
    fwrite($myfile, "\n");
    fclose($myfile);
  }

  public function test_plugin_setup_menu() {
    //add_management_page('Plugin Directory','Plugin Directory','manage_options','wp_directory_plugin',array(&$this,'plugin_options'));
    add_menu_page('Plugin Directory List', 'Plugin Directory', 'manage_options', 'wp_directory_plugin', array(&$this,'list_table_page'));
  }



  /**
     * Display the list table page
     *
     * @return Void
     */
    public function list_table_page()
    {
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2>Example List Table Page</h2>
                <?php $exampleListTable->display(); ?>
            </div>
        <?php
    }

}



/*
public function plugin_options() {
  if (!current_user_can('manage_options')) {
    wp_die(__('You do not have sufficient permissions to access this page.'));
  }
  $this->options=get_option('wp_directory_plugin');
  include('options.tpl.php');
}
*/

$wp_plugin_directory = new WP_Plugin_Directory();
