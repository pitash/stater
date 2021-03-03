<?php

namespace App\Http\Controllers\Backend;

use App\Models\Menu;
use App\Models\Page;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        Gate::authorize('app.dashboard');
        $data['usersCount'] = User::count();
        $data['rolesCount'] = Role::count();
        $data['pagesCount'] = Page::count();
        $data['menusCount'] = Menu::count();
        $data['users'] = User::orderBy('created_at','desc')->take(10)->get();
        return view('backend.dashboard', $data);
    }
}
