<?php

namespace App\Models;

use App\Lib\Model;

/**
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    protected static $table_name = "categories";

    protected $id = 0;
    protected $cat;

    public function __construct($cat) {
        $this->cat = $cat;
    }
} // End of Category class