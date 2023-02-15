<?php

namespace App\Repositories;

use App\Models\Product;
use App\Criteria\ProductCriteria;

/**
 * Interface PersonRepositoryRepository.
 *
 * @package namespace App\Repositories;
 */
class PersonRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(){
        return Product::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot(){
        $this->pushCriteria( ProductCriteria::class );
    }
}
