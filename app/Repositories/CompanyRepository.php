<?php

namespace App\Repositories;

use App\Criteria\CompanyCriteria;
use App\Models\Company;


/**
 * Class DolgozoRepositoryEloquent
 * @package namespace App\Repositories;
 */
class CompanyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Company::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria( CompanyCriteria::class );
    }
}
