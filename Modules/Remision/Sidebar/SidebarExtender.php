<?php namespace Modules\Remision\Sidebar;

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
        
       $menu->group(trans('core::sidebar.content'), function (Group $group) 
        {
            $group->item(trans('Remisiones'), function (Item $item, Group $group) 
            {
                
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->append('admin.remision.remision.create');
                $item->route('admin.remision.remision.index');
                $item->authorize(
                    $this->auth->hasAccess('remision.remisions.index')
                );

                
            });
        });

        $menu->group(trans('core::sidebar.content'), function (Group $group) 
        {
            $group->item(trans('Probetas del Dia'), function (Item $item, Group $group) 
            {
                
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->route('admin.remision.remision.probeta.lista');
                $item->authorize(
                    $this->auth->hasAccess('remision.remisions.index')
                );
                

            });
        });

        $menu->group(trans('core::sidebar.content'), function (Group $group) 
        {
            $group->item(trans('Reporte General'), function (Item $item, Group $group) 
            {
                
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->route( 'admin.remision.remision.reporte_remision_obra_cliente', ['obra' => 0, 'cliente' => 0, "general" => ""]);
                $item->authorize(
                    $this->auth->hasAccess('remision.remisions.index')
                );
                

            });
        });
        

        return $menu;
    }
/*
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('workshop::workshop.title'), function (Group $group) 
        {
            $group->item(trans('setting::settings.title.settings'), function (Item $item) 
            {
                $item->icon('fa fa-cog');
                $item->weight(50);
                $item->route('admin.setting.settings.index');
                $item->authorize(
                    $this->auth->hasAccess('setting.settings.index')
                );
            });
        });

        return $menu;
    }
*/














}
