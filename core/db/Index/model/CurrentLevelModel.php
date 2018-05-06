<?php

namespace core\db\index\model;

use core\base\Model;

class CurrentLevelModel extends Model
{
    protected $pk = 'id';

    protected $name = 'current_level';

    protected $autoWriteTimestamp = true;

    protected $insert = [
        'id'
    ];


}