<?php
/*
* Plugin Name: customplugin
* Description: This plugin is for invoice
* Version:     1.1.0
* Author:      FK
* Author URI:  dit.com
* License:     GPLv2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: wpbc
* Domain Path: /languages
*/

//constants
define("PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));
define("PLUGIN_URL", plugins_url());
define("PLUGIN_VERSION", "1");

function add_my_custom_menu()
{
    add_menu_page("customplugin", "Custom Plugin", "manage_options", "custom-plugin", "add_new_function", "dashicons-dashboard", 11);
    add_submenu_page(
        "custom-plugin", //parrent slug
        "Add New",  //page title
        "Add New", //menu title
        "manage_options", //capability
        "custom-plugin", // menu slug
        "add_new_function" // callback function
    );
    add_submenu_page(
        "custom-plugin", //parrent slug
        "All Pages",  //page title
        "All Pages", //menu title
        "manage_options", //capability
        "all-pages", // menu slug
        "all_page_function" // callback function
    );
}
add_action("admin_menu", "add_my_custom_menu");

// function custom_admin_view(){
//     echo "Hello this is custom plugin view";
// }

function add_new_function()
{
    include_once(PLUGIN_DIR_PATH . "/views/add-new.php");
}

function all_page_function()
{
    include_once(PLUGIN_DIR_PATH . "/views/all-pages.php");
}

function create_page()
{
    //code for create page
    $page = array();
    $page['post_title'] = "Custom Plugin Title";
    $page['post_content'] = "Custom Plugin Content";
    $page['post_status'] = "publish";
    $page['post_slug'] = "custom-plugin-online";
    $page['post_type'] = "page";

    wp_insert_post($page);
}
register_activation_hook(__FILE__, "create_page");

function jscode()
{
    ?>
    <script>
        console.log("this is custom jscode");
    </script>

<?php
}

add_action("wp_head", "jscode");

function custom_plugin_assets()
{
    wp_enqueue_style(
        "cpl_style",
        PLUGIN_URL . "/customplugin/assets/css/style.css",
        "",
        PLUGIN_VERSION
    );

    wp_enqueue_script(
        "cpl_script",
        PLUGIN_URL . "/customplugin/assets/js/script.js",
        array("jquery"),
        time(),
        true
    );

    $object_array = array(
        "Name" => "Cust Plugin",
        "Author" => "FK",
        "ajaxurl" => admin_url("admin-ajax")
    );
    // wp_localize_script("cpl_script", "ajaxurl", $object_array);
    wp_localize_script("cpl_script", "ajaxurl", admin_url("admin-ajax.php"));
}
add_action("init", "custom_plugin_assets");

/*
//add custom Javascript Code

// function jsCode(){

?>
// <script>
    //         console.log("this is another js call");
    //     
</script>
// <?php
// }

// add_action("wp_head","jsCode");
// wp_localize_script("cp_script", "ajaxurl", admin_url("admin-ajax.php"));
*/
if ($_REQUEST['']) {
    switch ($_REQUEST['']) {
        case "custom_plugin_library":
            add_action("admin_init", "admin_custom_plugin_library");
            function admin_custom_plugin_library()
            { 
                global $wpdb;
                include_once(PLUGIN_DIR_PATH."/library/add-new.php");
            }
    }
}
