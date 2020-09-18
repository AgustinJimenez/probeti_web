<?php namespace Modules\Factura\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('Factura'), function (Item $item) 
            {
                $item->icon('fa fa-copy');
                $item->weight(10);
                //$item->append('admin.factura.factura.create');
                $item->route('admin.factura.factura.index');
                $item->authorize(
                    $this->auth->hasAccess('factura.facturas.index')
                );
            });

            $group->item(trans('Editar Nro de Factura'), function (Item $item) 
            {
                $item->icon('fa fa-copy');
                $item->weight(10);
                //$item->append('admin.factura.factura.create');
                $item->route('admin.factura.factura.editNroFactura');
                $item->authorize(
                    $this->auth->hasAccess('factura.facturas.index')
                );
            });
        });

        return $menu;
    }
}
