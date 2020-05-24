<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
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

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--disable-dev-shm-usage',
            '--headless',
            '--no-sandbox',
        ]);

        return RemoteWebDriver::create(
            env('SELENIUM_URL', 'http://127.0.0.1:4444/wd/hub'),
            DesiredCapabilities::chrome()->setCapability(ChromeOptions::CAPABILITY_W3C, $options)
        );
    }
}
