<?php namespace EdmondsCommerce\BehatErrorHandling;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Behat\Behat\Hook\Scope\AfterStepScope;
/**
 * Defines application features from the specific context.
 */
class ErrorHandlingContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    /**
     * Allow Behat to be killed after the first failed scenario
     * To enable, in your command prompt run:
     *  export BEHAT_DIE_ON_FAILURE=true;
     * @AfterScenario
     * @param AfterScenarioScope $scope
     */
    public function dieOnFailedScenario(AfterScenarioScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode())
        {
            if (isset($_SERVER['BEHAT_DIE_ON_FAILURE']))
            {
                die("BEHAT_DIE_ON_FAILURE is defined\nKilling Full Process");
            }
        }
    }

    /**
     * Take screen shot when step fails.
     * And then pause everything
     * Works only with Selenium2Driver.
     *
     * @param AfterStepScope $scope
     *
     * @AfterStep
     */
    public function myAfterStepHook(AfterStepScope $scope)
    {
        if (99 === $scope->getTestResult()->getResultCode())
        {
            $driver = $this->getSession()->getDriver();
            if ($driver instanceof \Behat\Mink\Driver\Selenium2Driver)
            {

                $name = preg_replace(
                    '%[^a-z0-9]%i',
                    '_',
                    array_pop($_SERVER['argv']) . ':' . $scope->getStep()->getText() . '_' . $driver->getCurrentUrl()
                );
                if (!file_exists('/tmp/behat'))
                {
                    mkdir('/tmp/behat/');
                }
                $file = '/tmp/behat/' . $name . '.png';
                file_put_contents($file, $this->getSession()->getDriver()->getScreenshot());
                echo "Error Screen Shot Saved to $file";
                xdebug_break();
            }
        }
    }
}
