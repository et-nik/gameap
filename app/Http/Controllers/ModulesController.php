<?php

namespace Gameap\Http\Controllers;

use Artisan;

class ModulesController extends AuthController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $modules = app()['modules']->getCached();

        return view('modules', compact('modules'));
    }

    public function migrate()
    {
        Artisan::call('module:migrate');

        return redirect('modules')->with('success', __('modules.migrate_success_msg'));
    }
}