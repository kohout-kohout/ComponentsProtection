<?php

/**
 * This file is part of the Arachne
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

namespace Arachne\ComponentsProtection;

use Arachne\ComponentsProtection\Exception\InvalidArgumentException;
use Arachne\ComponentsProtection\Exception\ComponentInaccessibleException;
use Arachne\Verifier\IAnnotation;
use Arachne\Verifier\IAnnotationHandler;
use Nette\Application\Request;
use Nette\Application\UI\Presenter;
use Nette\Object;

/**
 * @author Jáchym Toušek
 */
class ComponentsProtectionHandler extends Object implements IAnnotationHandler
{

	/**
	 * @param Allowed $annotation
	 * @param Request $request
	 * @throws ComponentInaccessibleException
	 */
	public function checkAnnotation(IAnnotation $annotation, Request $request)
	{
		if ($annotation instanceof Actions) {
			$this->checkAnnotationActions($annotation, $request);
		} else {
			throw new InvalidArgumentException('Unknown annotation \'' . get_class($annotation) . '\' given.');
		}
	}

	/**
	 * @param Actions $annotation
	 * @param Request $request
	 * @throws ComponentInaccessibleException
	 */
	protected function checkAnnotationActions(Actions $annotation, Request $request)
	{
		$parameters = $request->getParameters();
		if (!in_array($parameters[Presenter::ACTION_KEY], $annotation->actions)) {
			throw new ComponentInaccessibleException("Component is inaccessible for the given action.");
		}
	}


}
