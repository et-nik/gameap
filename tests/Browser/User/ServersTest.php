<?php

namespace Tests\Browser\User;

use Facebook\WebDriver\WebDriverKeys;
use Gameap\Models\Server;
use Gameap\Models\User;
use Gameap\Repositories\UserRepository;
use Laravel\Dusk\Browser;
use Tests\Context\Browser\Models\ServerContextTrait;
use Tests\Context\Browser\Models\UserContextTrait;
use Silber\Bouncer\Bouncer;
use Tests\DuskTestCase;

class ServersTest extends DuskTestCase
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

        $this->browse(function (Browser $admin, Browser $user) {
            $admin->loginAs($this->adminModel);
            $user->loginAs($this->userModel);

            $admin->visit("/admin/users/{$this->userModel->id}/servers/{$this->server->id}/edit")
                ->assertPathIs('/admin/users/*/servers/*/edit');

            $this->assertNotChecked($admin, '#game-server-common');
            $this->assertChecked($admin, '#game-server-tasks');

            $user->visit('/servers')
                ->assertSeeIn('table.table-grid-models > tbody > tr > td:last-child', 'Control')
                ->click('.server-control:last-child > a:last-child')
                ->assertPathIs('/servers/*')
                ->assertDontSee(__('servers.task_scheduler'));

            $this->userRepository->updateServerPermission($this->userModel, $this->server, []);

            $admin->refresh();
            $this->assertNotChecked($admin, '#game-server-common');
            $this->assertNotChecked($admin, '#game-server-tasks');

            $user->refresh()
                ->assertSee(__('servers.task_scheduler'));
        });
    }

    public function taskDataProvider()
    {
        return [
            ['command' => 'start', 'ability' => 'game-server-start'],
            ['command' => 'stop', 'ability' => 'game-server-stop'],
            ['command' => 'restart', 'ability' => 'game-server-restart'],
            ['command' => 'update', 'ability' => 'game-server-update'],
        ];
    }

    /**
     * @dataProvider taskDataProvider
     * @group userServers
     */
    public function testForbiddenCreateTask(string $command, string $ability)
    {
        $this->userRepository->updateServerPermission($this->userModel, $this->server, []);

        $this->browse(function (Browser $admin, Browser $user) use ($command, $ability) {
            $admin->loginAs($this->adminModel);
            $user->loginAs($this->userModel);

            // Check allow
            $user->visit('/servers/' . $this->server->id)
                ->clickLink(__('servers.task_scheduler'))
                ->waitFor('#server-task-component', 10)
                ->press(__('main.add'))
                ->waitFor('.modal-content', 2)
                ->waitForText('New Task', 2)
                ->select('command', $command)
                ->type('date', '2020-05-26 00:00:00');
            $user->driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);
            $user->press(__('main.create'));
            sleep(1);
            $user->assertSee('2020-05-26 00:00:00');

            // Change ability to forbidden
            $admin->visit("/admin/users/{$this->userModel->id}/servers/{$this->server->id}/edit");
            $this->assertNotChecked($admin, "#{$ability}");

            $admin->click("label[for={$ability}]")
                ->scrollIntoView('input[type=submit]')
                ->press(__('main.save'))
                ->assertPathIs('/admin/users/*/edit');

            // Try to add task
            $user->clickLink(__('servers.task_scheduler'))
                ->waitFor('#server-task-component', 10)
                ->press(__('main.add'))
                ->waitFor('.modal-content', 2)
                ->waitForText('New Task', 2)
                ->select('command', $command)
                ->type('date', '2020-05-27 00:00:00');
            $user->driver->getKeyboard()->sendKeys(WebDriverKeys::ENTER);
            $user->press(__('main.create'));

            sleep(1);
            $user->assertSee('This action is unauthorized.')
                ->press('OK');
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
