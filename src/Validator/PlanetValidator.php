<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

class PlanetValidator
{
    private const ID = 'id';
    private const NAME = 'name';
    private const ROT_PERIOD = 'rotation_period';
    private const ORB_PERIOD = 'orbital_period';
    private const DIAMETER = 'diameter';

    /**
     * @param $input
     * @return array
     */
    public function postValidate($input): array
    {
        $validator = Validation::createValidator();
        $groups = new Assert\GroupSequence(['Default']);
        $constraint = array(
            self::ID => new Assert\Positive(),
            self::NAME => new Assert\Length(['min' => 3])
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
        if (array_key_exists(self::ROT_PERIOD , $input)) {
            $optionalArray[self::ROT_PERIOD] = new Assert\Positive();
        }
        if (array_key_exists(self::ORB_PERIOD , $input)) {
            $optionalArray[self::ORB_PERIOD] = new Assert\Positive();
        }
        if (array_key_exists(self::DIAMETER , $input)) {
            $optionalArray[self::DIAMETER] = new Assert\Positive();
        }
        $constraint = array_merge($constraint, $optionalArray);
        return new Assert\Collection($constraint);
    }
}