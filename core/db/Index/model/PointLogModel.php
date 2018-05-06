<?php

namespace core\db\index\model;

use core\base\Model;

class PointLogModel extends Model
{
    protected $pk = 'id';

    protected $name = 'pointLog';

//    protected $autoWriteTimestamp = true;

    protected $insert = [
        'id'
    ];


}