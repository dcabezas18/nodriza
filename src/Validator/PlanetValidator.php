<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class PlanetValidator
{
    /**
     * @param $input
     * @return array
     */
    public function postValidate($input): array
    {
        $validator = Validation::createValidator();
        $groups = new Assert\GroupSequence(['Default']);
        $constraint = array(
            'id' => new Assert\Positive(),
            'name' => new Assert\Length(['min' => 3])
        );
        $constraint = $this->checkOptionalParams($constraint, $input);

        $validated = $validator->validate($input, $constraint, $groups);
        $message = array();
        if ($validated) {
            foreach ($validated as $violation) {
                $message[] = $violation->getPropertyPath() . ' ' . $violation->getMessage();
            }
        }
        return $message;
    }

    /**
     * @param $constraint
     * @param $input
     * @return Assert\Collection
     */
    private function checkOptionalParams($constraint, $input): Assert\Collection
    {
        $optionalArray = array();
        if (array_key_exists('rotation_period' , $input)) {
            $optionalArray['rotation_period'] = new Assert\Positive();
        }
        if (array_key_exists('orbital_period' , $input)) {
            $optionalArray['orbital_period'] = new Assert\Positive();
        }
        if (array_key_exists('diameter' , $input)) {
            $optionalArray['diameter'] = new Assert\Positive();
        }
        $constraint = array_merge($constraint, $optionalArray);
        return new Assert\Collection($constraint);
    }
}