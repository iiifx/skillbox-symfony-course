<?php

namespace App\Validator;

use App\Homework\RegistrationSpamFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RegistrationSpamValidator extends ConstraintValidator
{
    public function __construct(
        protected RegistrationSpamFilter $spamFilter
    ) {
    }

    /**
     * @param RegistrationSpam $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        if (!$this->spamFilter->filter($value)) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
