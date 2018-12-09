<?php
/*
 * Plugin Name: Roles
 * Description: This plugin handles roles and capabilities.
 */

use Roles\RegisterRoles;

define('ROLES_PATH', __DIR__ . '/roles');

/** Register the Autoloader */
if (file_exists(ROLES_PATH .'/vendor/autoload.php')) {
    require_once(ROLES_PATH .'/vendor/autoload.php');
} else {
    throw new Exception('You need to run "composer update" in the following folder "' . ROLES_PATH . '" to get started.');
}

/** Runs the Role mu-plugin */
add_action('plugins_loaded', function() {
    $registerRoles = new RegisterRoles;

    register_roles_cron($registerRoles);

    $registerRoles->registerRoles();
});

/**
 * Register a CRON to regenerate Roles every day at midnight
 *
 * @param RegisterRoles $registerRoles
 */
function register_roles_cron(RegisterRoles $registerRoles)
{
    date_default_timezone_set(get_option('timezone_string'));

    if ( ! wp_next_scheduled('regenerate_roles')) {
        wp_schedule_event(strtotime('today midnight'), 'daily', 'regenerate_roles_hook');
    }

    add_action('regenerate_roles_hook', function() use ($registerRoles) {
        $registerRoles->regenerateRoles();
    });
}