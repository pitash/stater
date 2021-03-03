<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MenuBuilderController extends Controller
{
    /**
     * Display the menu Builder
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($id)
    {
        Gate::authorize('app.menus.index');
        $menu = Menu::findOrFail($id);
        return view('backend.menus.builder', compact('menu'));
    }

    public function order(Request $request, $id)
    {
        Gate::authorize('app.menus.index');
        // $menu = Menu::findOrFail($id);
        $menuItemOrder = json_decode($request->get('order'));
        $this->orderMenu($menuItemOrder, null);
        // return view('backend.menus.builder', compact('menu'));
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        Gate::authorize('app.menus.index');
        foreach ($menuItems as $index => $item) {
            // $menuItem = MenuItem::findOrFail($item->id);
            // $item->order = $index + 1;
            // $item->parent_id = $parentId;
            // $item->save();

            $menuItem = MenuItem::findOrFail($item->id);
            $menuItem->update([
                'order' => $index + 1,
                'parent_id' => $parentId
            ]);

            if (isset($item->children)) {
                $this->orderMenu($item->children, $item->id);
            }

            // if (isset($item->children)) {
            //     $this->orderMenu($item->children, $menuItem->id);
            // }

        }
    }

    /**
     * Create new menu item
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemCreate($id)
    {
        Gate::authorize('app.menus.create');
        $menu = Menu::findOrFail($id);
        return view('backend.menus.item.form',compact('menu'));
    }

    /**
     * Store new menu item
     * @param StoreMenuItemRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemStore(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'type'=> 'required|string',
            'divider_title'=> 'nullable|string',
            'title'=> 'nullable|string',
            'url'=> 'nullable|string',
            'target'=> 'nullable|string',
            'icon_class'=> 'nullable|string'
          ]);

        MenuItem::create([
            'menu_id' => $menu->id,
            'type' => $request->type,
            'title' => $request->title,
            'divider_title' => $request->divider_title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon_class
        ]);
        notify()->success('Menu Item Added.', 'Successfully');
        return redirect()->route('app.menus.builder',$menu->id);
    }

    /**
     * Edit menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function itemEdit($menuId, $itemId)
    {
        Gate::authorize('app.menus.edit');
        $menu = Menu::findOrFail($menuId);
        $menuItem = MenuItem::where('menu_id', $menu->id)->findOrFail($itemId);
        return view('backend.menus.item.form',compact('menu','menuItem'));
    }

    /**
     * Update menu item
     * @param Request $request
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function itemUpdate(Request $request, $id, $itemId)
    {
        $request->validate([
            'type'=> 'required|string',
            'divider_title'=> 'nullable|string',
            'title'=> 'nullable|string',
            'url'=> 'nullable|string',
            'target'=> 'nullable|string',
            'icon_class'=> 'nullable|string'
          ]);

        $menu = Menu::findOrFail($id);
        $menuItem = MenuItem::where('menu_id', $menu->id)->findOrFail($itemId)->update([
            'type' => $request->type,
            'title' => $request->title,
            'divider_title' => $request->divider_title,
            'url' => $request->url,
            'target' => $request->target,
            'icon_class' => $request->icon_class
        ]);
        notify()->success('Menu Item Successfully.', 'Updated');
        return redirect()->route('app.menus.builder',$menu->id);
    }

    /**
     * Delete a menu item
     * @param $menuId
     * @param $itemId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function itemDestroy($id, $itemId)
    {
        Gate::authorize('app.menus.destroy');
        Menu::findOrFail($id)
            ->menuItems()
            ->findOrFail($itemId)
            ->delete();
        notify()->success('Menu Item Successfully.', 'Deleted');
        return redirect()->back();
    }

}
