<?php

namespace Tests\Unit;

use Arachne\ComponentsProtection\Actions;
use Arachne\ComponentsProtection\ComponentsProtectionHandler;
use Codeception\TestCase\Test;
use Mockery;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;

/**
 * @author Jáchym Toušek
 */
class ComponentsProtectionHandlerTest extends Test
{

	/** @var ComponentsProtectionHandler */
	private $handler;

	protected function _before()
	{
		$this->handler = new ComponentsProtectionHandler();
	}

	public function testAllowedTrue()
	{
		$annotation = new Actions();
		$annotation->actions = [ 'default' ];
		$request = new Request('Test', 'GET', [
			Presenter::ACTION_KEY => 'default',
		]);

		$this->assertNull($this->handler->checkRule($annotation, $request));
	}

	/**
	 * @expectedException Arachne\ComponentsProtection\Exception\ComponentInaccessibleException
	 * @expectedExceptionMessage Component is inaccessible for the given action.
	 */
	public function testAllowedFalse()
	{
		$annotation = new Actions();
		$annotation->actions = [];
		$request = new Request('Test', 'GET', [
			Presenter::ACTION_KEY => 'default',
		]);

		$this->handler->checkRule($annotation, $request);
	}

	/**
	 * @expectedException Arachne\ComponentsProtection\Exception\InvalidArgumentException
	 */
	public function testUnknownAnnotation()
	{
		$annotation = Mockery::mock('Arachne\Verifier\IRule');
		$request = new Request('Test', 'GET', []);

		$this->handler->checkRule($annotation, $request);
	}

}
