<?php namespace Modules\Factura\Repositories\Cache;

use Modules\Factura\Repositories\FacturaRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheFacturaDecorator extends BaseCacheDecorator implements FacturaRepository
{
    public function __construct(FacturaRepository $factura)
    {
        parent::__construct();
        $this->entityName = 'factura.facturas';
        $this->repository = $factura;
    }
}
