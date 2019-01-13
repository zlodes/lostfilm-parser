<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    abstract public function getModel(): Model;

    public function query(): Builder
    {
        return $this->getModel()->newQuery();
    }
}