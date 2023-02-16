<?php

namespace App\Repositories;

use App\Criteria\PersonCriteria;
use App\Models\Person;

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
        return Person::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot(){
        //$this->pushCriteria(app(RequestCriteria::class));
        $this->pushCriteria(PersonCriteria::class);
    }
}
