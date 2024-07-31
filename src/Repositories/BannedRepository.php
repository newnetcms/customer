<?php

namespace Newnet\Customer\Repositories;

use Newnet\Core\Repositories\BaseRepository;
use Newnet\Customer\Models\Banned;

class BannedRepository extends BaseRepository
{
    public function __construct(Banned $model)
    {
        parent::__construct($model);
    }
}
