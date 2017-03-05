<?php

namespace Tests\Functional;

use Arachne\Codeception\Module\NetteApplicationModule;
use Arachne\ComponentsProtection\Exception\MissingAnnotationException;
use Arachne\Verifier\Exception\VerificationException;
use Codeception\Test\Unit;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ActionsRuleHandlerTest extends Unit
{
    /**
     * @var NetteApplicationModule
     */
    protected $tester;

    public function testActionDefault()
    {
        $this->tester->amOnPage('/article/');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->see('header');
        $this->tester->see('footer');
    }

    public function testActionDetail()
    {
        try {
            $this->tester->amOnPage('/article/detail/1');
            self::fail();
        } catch (VerificationException $e) {
            self::assertSame('Component is inaccessible for the given action.', $e->getMessage());
        }
    }

    public function testActionEdit()
    {
        $this->tester->amOnPage('/article/edit/1');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->see('header');
        $this->tester->dontSee('footer');
    }

    public function testComponentNotAllowed()
    {
        try {
            $this->tester->amOnPage('/article/?do=unprotected-signal');
            self::fail();
        } catch (MissingAnnotationException $e) {
            self::assertSame('Missing annotation @Arachne\ComponentsProtection\Rules\Actions for component "unprotected".', $e->getMessage());
        }
    }
}
