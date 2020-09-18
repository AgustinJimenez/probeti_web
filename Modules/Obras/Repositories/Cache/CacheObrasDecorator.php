<?php namespace Modules\Obras\Repositories\Cache;

use Modules\Obras\Repositories\ObrasRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheObrasDecorator extends BaseCacheDecorator implements ObrasRepository
{
    public function __construct(ObrasRepository $obras)
    {
        parent::__construct();
        $this->entityName = 'obras.obras';
        $this->repository = $obras;
    }
}
