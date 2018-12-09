<?php

namespace Roles;

abstract class RoleAbstract
{
    /** @var string $option */
    protected $option;

    public function __construct()
    {
        $this->option = sanitize_title(get_class($this));
    }

    /**
     * Function that has to be implemented for
     * each concrete class to actually add the role.
     */
    public abstract function addRole();

    /**
     * Asserts if given role was already registered
     * This helps to minimize database usage.
     *
     * @return mixed
     */
    public function isRegistered()
    {
        return get_option('is_role_registered_' . $this->option);
    }

    /**
     * Saves the Role in the database and set a option
     * to mark it as saved
     */
    public function register()
    {
        $this->addRole();
        update_option('is_role_registered_' . $this->option, true);
    }
}