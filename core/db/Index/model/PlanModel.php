<?php

namespace core\db\index\model;

use core\base\Model;

class PlanModel extends Model
{
    protected $pk = 'planId';

    protected $name = 'userPlan';

//    protected $autoWriteTimestamp = true;

    protected $insert = [
        'planId'
    ];


}