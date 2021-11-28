<?php

namespace Tests\Browser\User;

use Facebook\WebDriver\WebDriverKeys;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Laravel\Dusk\Browser;
use Tests\Browser\BrowserTestCase;
use Tests\Context\Browser\Models\ServerContextTrait;
use Tests\Context\Browser\Models\UserContextTrait;
use Silber\Bouncer\Bouncer;

class ServersTest extends BrowserTestCase
{
    use UserContextTrait;
    use ServerContextTrait;

    /**
     * @var User
     */
    protected $adminModel;

    /**
     * @var User
     */
    protected $userModel;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /** @var Bouncer */
    protected $bouncer;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminModel = User::find(1);
        $this->userModel  = $this->givenUser();
        $this->server     = $this->givenGameServer();

        $this->bouncer = $this->app->get(Bouncer::class);
        $this->bouncer->dontCache();

        $this->bouncer->sync($this->userModel)->roles(['user']);
        $this->bouncer->refresh();

        $this->userRepository = new UserRepository($this->bouncer);
    }

    /**
     * @group userServers
     */
    public function testTasksView()
    {
        $this->userRepository->updateServerPermission($this->userModel, $this->server, [
            'game-server-tasks' => 'disallow'
        ]);

        $this->browse(function (Browser $admin) {
            $admin->loginAs($this->adminModel);
            $admin->visit("/admin/users/{$this->userModel->id}/servers/{$this->server->id}/edit")
                ->assertPathIs('/admin/users/*/servers/*/edit');
            $this->assertNotChecked($admin, '#game-server-common');
            $this->assertChecked($admin, '#game-server-tasks');
        });

        $this->browse(function (Browser $user) {
            $user->loginAs($this->userModel);
            $user->visit('/servers')
                ->assertSeeIn('table.table-grid-models > tbody > tr > td:last-child', 'Control')
                ->click('.server-control:last-child > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertDontSee(__('servers.task_scheduler'));
        });

        $this->userRepository->updateServerPermission($this->userModel, $this->server, []);

        $this->browse(function (Browser $admin) {
            $admin->loginAs($this->adminModel);
            $admin->visit("/admin/users/{$this->userModel->id}/servers/{$this->server->id}/edit")
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $this->assertNotChecked($admin, '#game-server-common');
            $this->assertNotChecked($admin, '#game-server-tasks');
        });

        $this->browse(function (Browser $user) {
            $user->loginAs($this->userModel);
            $user->visit('/servers/' . $this->server->id)
                ->assertSee(__('servers.task_scheduler'));
        });
    }

    // https://github.com/laravel/dusk/issues/209#issue-218628939
    public function assertChecked($browser, $selector)
    {
        $fullSelector = $browser->resolver->format($selector);
        $element = $browser->resolver->findOrFail($selector);

        $this->assertTrue(
            $element->isSelected(),
            "Expected checkbox [{$fullSelector}] to be checked, but it wasn't."
        );

        return $browser;
    }

    // https://github.com/laravel/dusk/issues/209#issue-218628939
    public function assertNotChecked($browser, $selector)
    {
        $fullSelector = $browser->resolver->format($selector);
        $element = $browser->resolver->findOrFail($selector);

        $this->assertFalse(
            $element->isSelected(),
            "Checkbox [{$fullSelector}] was unexpectedly checked."
        );

        return $browser;
    }
}
