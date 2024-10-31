<?php

namespace App\Service;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * ValidationService class
 *
 * Validates bid data to ensure required fields and valid values.
 */
class ValidationService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateBidData(array $data): array
    {
        $constraints = new Assert\Collection([
            'basePrice' => [
                new Assert\NotBlank(),
                new Assert\Type('numeric'),
                new Assert\GreaterThan(0)
            ],
            'vehicleType' => [
                new Assert\NotBlank(),
                new Assert\Choice(['Common', 'Luxury'])
            ]
        ]);

        $violations = $this->validator->validate($data, $constraints);

        $errors = [];
        foreach ($violations as $violation) {
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
        }

        return $errors;
    }
}