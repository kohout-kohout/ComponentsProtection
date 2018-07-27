<?php

declare(strict_types=1);

namespace Arachne\ComponentsProtection\Application;

use Arachne\ComponentsProtection\Exception\MissingAnnotationException;
use Arachne\ComponentsProtection\Rules\Actions;
use Arachne\Verifier\Application\VerifierPresenterTrait;
use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionMethod;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 */
trait ComponentsProtectionTrait
{
    use VerifierPresenterTrait {
        VerifierPresenterTrait::checkRequirements as verifierCheckRequirements;
    }

    /**
     * @var Reader
     */
    private $reader;

    /**
     * @param Reader $reader
     */
    final public function injectReader(Reader $reader): void
    {
        $this->reader = $reader;
    }

    /**
     * @param ReflectionClass|ReflectionMethod $reflection
     */
    public function checkRequirements($reflection): void
    {
        if (
            $reflection instanceof ReflectionMethod
            && substr($reflection->getName(), 0, 15) === 'createComponent'
            && $this->reader->getMethodAnnotation($reflection, Actions::class) === null
        ) {
            $name = lcfirst(substr($reflection->getName(), 15));
            throw new MissingAnnotationException(sprintf('Missing annotation @%s for component "%s".', Actions::class, $name));
        }

        $this->verifierCheckRequirements($reflection);
    }
}
