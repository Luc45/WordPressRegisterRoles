<?php

namespace Roles\Roles;

use Roles\RoleAbstract;

class PublicRelationsRole extends RoleAbstract
{
    public function addRole()
    {
        add_role(
            'public_relations',
            __('Public Relations'),
            [
                'read'
            ]
        );
    }
}