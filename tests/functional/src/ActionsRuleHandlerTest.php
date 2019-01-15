<?php

declare(strict_types=1);

namespace Tests\Functional;

use Arachne\ComponentsProtection\Exception\MissingAnnotationException;
use Arachne\Verifier\Exception\VerificationException;
use Codeception\Test\Unit;
use Contributte\Codeception\Module\NetteApplicationModule;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
class ActionsRuleHandlerTest extends Unit
{
    /**
     * @var NetteApplicationModule
     */
    protected $tester;

    public function testActionDefault(): void
    {
        $this->tester->amOnPage('/article/');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->see('header');
        $this->tester->see('footer');
    }

    public function testActionDetail(): void
    {
        try {
            $this->tester->amOnPage('/article/detail/1');
            self::fail();
        } catch (VerificationException $e) {
            self::assertSame('Component is inaccessible for the given action.', $e->getMessage());
        }
    }

    public function testActionEdit(): void
    {
        $this->tester->amOnPage('/article/edit/1');
        $this->tester->seeResponseCodeIs(200);
        $this->tester->see('header');
        $this->tester->dontSee('footer');
    }

    public function testComponentNotAllowed(): void
    {
        try {
            $this->tester->amOnPage('/article/?do=unprotected-signal');
            self::fail();
        } catch (MissingAnnotationException $e) {
            self::assertSame('Missing annotation @Arachne\ComponentsProtection\Rules\Actions for component "unprotected".', $e->getMessage());
        }
    }
}
