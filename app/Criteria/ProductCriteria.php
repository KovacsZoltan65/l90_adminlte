<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ProductCriteria implements CriteriaInterface {

    public function apply($model, RepositoryInterface $repository) {
        return $model;
    }

}
