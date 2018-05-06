<?php

namespace core\db\index\model;

use core\base\Model;

class FoodModel extends Model
{
    protected $pk = 'foodId';

    protected $name = 'food';

//    protected $autoWriteTimestamp = true;

    protected $insert = [
        'foodId'
    ];


}