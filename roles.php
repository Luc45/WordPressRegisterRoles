<?php
/*
 * Plugin Name: Roles
 * Description: This plugin handles roles and capabilities.
 */

use Roles\Libraries\WpDateTimeZone;
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
    $registerRoles->registerRoles();

    register_roles_cron($registerRoles);
});

/**
 * Register a CRON to regenerate Roles every day at midnight
 *
 * @param RegisterRoles $registerRoles
 */
function register_roles_cron(RegisterRoles $registerRoles)
{
    /** Generates a DateTime object according to WordPress's Settings -> General -> Timezone settings */
    $date = new DateTime('today midnight', WpDateTimeZone::getWpTimezone());

    if ( ! wp_next_scheduled('regenerate_roles')) {
        wp_schedule_event($date->getTimestamp(), 'daily', 'regenerate_roles_hook', $registerRoles);
    }
}

add_action('regenerate_roles_hook', function(RegisterRoles $registerRoles) {
    $registerRoles->regenerateRoles();
});