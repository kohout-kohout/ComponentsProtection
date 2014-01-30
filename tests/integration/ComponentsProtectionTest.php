<?php

namespace Tests\Integration;

use Codeception\TestCase\Test;

class ComponentsProtectionTest extends Test
{

	public function testActionDefault()
	{
		$this->codeGuy->amOnPage('/article/');
		$this->codeGuy->seeResponseCodeIs(200);
		$this->codeGuy->see('header');
		$this->codeGuy->see('footer');
	}

	/**
	 * @expectedException Arachne\ComponentsProtection\Exception\ComponentInaccessibleException
	 * @expectedExceptionMessage Component is inaccessible for the given action.
	 */
	public function testActionDetail()
	{
		$this->codeGuy->amOnPage('/article/detail/1');
	}

	public function testActionEdit()
	{
		$this->codeGuy->amOnPage('/article/edit/1');
		$this->codeGuy->seeResponseCodeIs(200);
		$this->codeGuy->see('header');
		$this->codeGuy->dontSee('footer');
	}

	/**
	 * @expectedException Arachne\ComponentsProtection\Exception\MissingAnnotationException
	 * @expectedExceptionMessage Missing annotation @Arachne\ComponentsProtection\Actions for component 'unprotected'.
	 */
	public function testComponentNotAllowed()
	{
		$this->codeGuy->amOnPage('/article/?do=unprotected-signal');
	}

}
