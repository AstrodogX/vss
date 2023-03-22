<?php

namespace VSS\Entities;

use Doctrine\ORM\Mapping as ORM;

use VSS\EntityEnhancements\EntityIntegerIDInterface;
use VSS\EntityEnhancements\EntityIntegerIDTrait;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product implements EntityIntegerIDInterface
{
	use EntityIntegerIDTrait;

	#[Assert\NotBlank(message: 'Name can\'t be blank.')]
	#[ORM\Column(type: 'string', length: 512, unique: true)]
	private string $name = '';

	#[Assert\Type('integer')]
	#[Assert\GreaterThan(value: 0, message: 'Price must be greater than 0.')]
	#[ORM\Column(type: 'integer', options: ['unsigned' => true])]
	private int $price = 0;

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): static
	{
		$this->name = trim($name);
		return $this;
	}

	public function getPrice(): float
	{
		return $this->price / 100;
	}

	public function setPrice(float $price): static
	{
		$this->price = $price * 100;
		return $this;
	}
}