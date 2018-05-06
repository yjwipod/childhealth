<?php

namespace core\db\index\model;

use core\base\Model;

class GradeModel extends Model
{
    protected $pk = 'id';

    protected $name = 'grade';

//    protected $autoWriteTimestamp = true;

    protected $insert = [
        'id'
    ];


}