<?php

namespace core\db\index\model;

use core\base\Model;

class MemberUserModel extends Model
{
    protected $pk = 'id';

    protected $name = 'manage_member';

    protected $autoWriteTimestamp = true;

    protected $insert = [
        'id'
    ];


}