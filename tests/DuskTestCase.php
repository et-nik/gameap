<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Facades\DB;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('server_user')->delete();
        DB::table('servers')->delete();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        return $this->driverChrome();
    }

    protected function driverChrome()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless',
            '--no-sandbox',
        ]);

        return RemoteWebDriver::create(
            env('SELENIUM_URL', 'http://127.0.0.1:4444/wd/hub'),
            DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY_W3C, $options)
        );
    }

    protected function driverFirefox()
    {
        $options = (new FirefoxOptions())->addArguments([
            '--headless',
            '--disable-gpu',
        ]);

        return RemoteWebDriver::create(
            env('SELENIUM_FIREFOX_URL', 'http://127.0.0.1:4444/wd/hub'),
            DesiredCapabilities::firefox()->setCapability(FirefoxOptions::CAPABILITY, $options)
        );
    }
}
