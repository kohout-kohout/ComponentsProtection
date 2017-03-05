<?php

namespace Arachne\ComponentsProtection\Rules;

use Arachne\Verifier\Rules\ValidationRule;

/**
 * @author Jáchym Toušek <enumag@gmail.com>
 *
 * @Annotation
 * @Target({"METHOD", "ANNOTATION", "PROPERTY"})
 */
class Actions extends ValidationRule
{
    /** @var array */
    public $actions = [];
}
