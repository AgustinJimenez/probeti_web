<?php namespace Modules\Clientes\Repositories\Cache;

use Modules\Clientes\Repositories\ClientesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheClientesDecorator extends BaseCacheDecorator implements ClientesRepository
{
    public function __construct(ClientesRepository $clientes)
    {
        parent::__construct();
        $this->entityName = 'clientes.clientes';
        $this->repository = $clientes;
    }
}
