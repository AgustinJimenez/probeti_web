<?php namespace Modules\Remision\Repositories\Cache;

use Modules\Remision\Repositories\RemisionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRemisionDecorator extends BaseCacheDecorator implements RemisionRepository
{
    public function __construct(RemisionRepository $remision)
    {
        parent::__construct();
        $this->entityName = 'remision.remisions';
        $this->repository = $remision;
    }
}
