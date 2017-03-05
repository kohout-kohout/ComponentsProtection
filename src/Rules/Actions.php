<?php

/**
 * This file is part of the Arachne.
 *
 * Copyright (c) Jáchym Toušek (enumag@gmail.com)
 *
 * For the full copyright and license information, please view the file license.md that was distributed with this source code.
 */

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
