<?php

namespace App\Application\Common;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;

abstract class AbstractHandler
{
    protected ValidatorInterface $validator;

    public function __construct(
        ValidatorInterface $validator
    )
    {
        $this->validator = $validator;
    }

    /**
     * @param object $dto
     * @throws ValidationFailedException
     */
    protected function validateDto(object $dto): void
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            $messages = [];
            foreach ($errors as $error) {
                $messages[$error->getPropertyPath()] = $error->getMessage();
            }

            throw new ValidationFailedException($dto, $errors, null, $messages);
        }
    }
}
