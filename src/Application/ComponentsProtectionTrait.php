<?php

namespace Arachne\ComponentsProtection\Application;

use Arachne\ComponentsProtection\Exception\MissingAnnotationException;
use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\Verifier\Application\VerifierPresenterTrait;
use Doctrine\Common\Annotations\Reader;
use Nette\ComponentModel\IComponent;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
trait ComponentsProtectionTrait
{
    use VerifierPresenterTrait;

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    final public function injectReader(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * Component factory. Delegates the creation of components to a createComponent<Name> method.
     *
     * @param string $name
     *
     * @return IComponent|null
     */
    protected function createComponent($name)
    {
        $method = 'createComponent'.ucfirst($name);
        if (method_exists($this, $method)) {
            $reflection = $this->getReflection()->getMethod($method);
            if (!$this->reader->getMethodAnnotation($reflection, Actions::class)) {
                throw new MissingAnnotationException(sprintf('Missing annotation @%s for component "%s".', Actions::class, $name));
            }
            $this->checkRequirements($reflection);
        }

        return parent::createComponent($name);
    }
}
