<?php

namespace core\db\index\model;

use core\base\Model;

class EatplanModel extends Model
{
    protected $pk = 'id';

    protected $name = 'userEat';

//    protected $autoWriteTimestamp = true;

    protected $insert = [
        'id'
    ];


}