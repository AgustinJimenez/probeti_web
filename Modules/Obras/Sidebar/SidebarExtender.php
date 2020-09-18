<?php namespace Modules\Obras\Sidebar;

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
            $group->item(trans('Obras'), function (Item $item) 
            {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->append('admin.obras.obras.create');
                    $item->route('admin.obras.obras.index');
                    $item->authorize(
                        $this->auth->hasAccess('obras.obras.index')
                    );
                
// append

            });
        });

        return $menu;
    }
}
