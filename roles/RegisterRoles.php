<?php

namespace Roles;

use Roles\Roles\PublicRelationsRole;

/**
 * Class RegisterRoles
 * @package Roles
 */
class RegisterRoles
{
    protected $roles = [];

    /**
     * RegisterRoles constructor.
     *
     * Defines additional Roles for this website.
     */
    public function __construct()
    {
        $this->roles[] = new PublicRelationsRole;
    }

    /**
     * Triggers registerRole for each Role
     */
    public function registerRoles()
    {
        foreach ($this->roles as $role) {
            $this->registerRole($role);
        }
    }

    /**
     * Check if role was added to database and
     * add it if not. Useful for production.
     *
     * @param RoleAbstract $role
     */
    private function registerRole(RoleAbstract $role)
    {
        if ( ! $role->isRegistered()) {
            $role->register();
        }
    }

    /**
     * Triggers regenerateRole for each Role
     */
    public function regenerateRoles()
    {
        foreach ($this->roles as $role) {
            $this->regenerateRole($role);
        }
    }

    /**
     * Saves a role in the database regardless
     * it already existed or not. Useful to update
     * a role after changing it's capabilities.
     *
     * @param RoleAbstract $role
     */
    private function regenerateRole(RoleAbstract $role)
    {
        $role->register();
    }
}
