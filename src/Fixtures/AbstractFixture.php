<?php

namespace VSS\Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractFixture extends Fixture
{
	private ValidatorInterface $validator;

	public function __construct(ValidatorInterface $validator)
	{
		$this->validator = $validator;
	}

	protected function validate(object $object): void
	{
		$violations = $this->validator->validate($object);
		if ($violations->count()) {
			throw new \Exception('Fixture validation failed: ' . $violations);
		}
	}
}