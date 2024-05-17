<?php

namespace Gameap\Http\Controllers\Admin;

use Gameap\Http\Controllers\AuthController;
use Gameap\Http\Requests\Admin\UserCreateRequest;
use Gameap\Http\Requests\Admin\UserUpdateRequest;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Silber\Bouncer\Bouncer;

class UsersController extends AuthController
{
    /**
     * The UserRepository instance.
     *
     * @var \Gameap\Repositories\UserRepository
     */
    protected $repository;

    /** @var \Silber\Bouncer\Bouncer */
    private $bouncer;

    /**
     * @param  \Gameap\Repositories\UserRepository $repository
     * @param  \Silber\Bouncer\Bouncer $bouncer
     */
    public function __construct(UserRepository $repository, Bouncer $bouncer)
    {
        parent::__construct();

        $this->repository = $repository;
        $this->bouncer = $bouncer;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.users.list', [
            'users' => $this->repository->getAll(),
        ]);
    }

    /**
     * Display new create user page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = $this->bouncer->role()->all();
        $roleOptions = $roles->map(function ($item) {
            return [
                'label' => $item->title,
                'value' => $item->name,
            ];
        })->toArray();

        return view('admin.users.create', [
            'roles' => $roles,
            'roleOptions' => $roleOptions,
        ]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserCreateRequest $request)
    {
        $this->repository->store($request->all());

        return redirect()->route('admin.users.index')
            ->with('success', __('users.create_success_msg'));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.view', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = $this->bouncer->role()->all();
        $roleOptions = $roles->map(function ($item) {
            return [
                'label' => $item->title,
                'value' => $item->name,
            ];
        })->toArray();

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $roles,
            'roleOptions' => $roleOptions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Gameap\Http\Requests\Admin\UserUpdateRequest  $request
     * @param  \Gameap\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        if ($this->repository->update($user, $request->all())) {
            return redirect()->route('admin.users.index')
                ->with('success', __('users.update_success_msg'));
        }
        return redirect()->route('admin.users.index')
                ->with($user->getValidationErrors()->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Gameap\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', __('users.delete_success_msg'));
    }
}
