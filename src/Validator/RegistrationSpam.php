<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "ANNOTATION"})
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class RegistrationSpam extends Constraint
{
    public string $message;

    public function __construct($options = null, string $message = null, array $groups = null, $payload = null)
    {
        $this->message = $message ?? 'Ботам здесь не место';

        parent::__construct($options, $groups, $payload);
    }
}
