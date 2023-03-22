<?php

namespace VSS\Entities;

use Doctrine\ORM\Mapping as ORM;

use VSS\EntityEnhancements\EntityIntegerIDInterface;
use VSS\EntityEnhancements\EntityIntegerIDTrait;
use VSS\Repositories\CountryRepository;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'countries')]
class Country implements EntityIntegerIDInterface
{
	use EntityIntegerIDTrait;

	#[Assert\NotBlank(message: 'Name can\'t be blank.')]
	#[ORM\Column(type: 'string', length: 512, unique: true)]
	private string $name = '';

	#[Assert\NotBlank(message: 'Code can\'t be blank.')]
	#[ORM\Column(type: 'string', length: 2, unique: true)]
	private string $code = '';

	#[Assert\Type('integer')]
	#[Assert\GreaterThan(value: 0, message: 'VAT ID length must be greater than 0.')]
	#[ORM\Column(type: 'integer', options: ['unsigned' => true])]
	private int $vat_id_length = 9;

	#[Assert\Type('integer')]
	#[Assert\GreaterThanOrEqual(value: 0, message: 'VAT must be greater than or equal to 0.')]
	#[ORM\Column(type: 'integer', options: ['unsigned' => true])]
	private int $vat = 0;

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): static
	{
		$this->name = trim($name);
		return $this;
	}

	public function getVAT(): int
	{
		return $this->vat;
	}

	public function setVAT(int $vat): static
	{
		$this->vat = $vat;
		return $this;
	}

	public function getCode(): string
	{
		return $this->code;
	}

	public function setCode(string $code): static
	{
		$this->code = strtoupper(trim($code));
		return $this;
	}

	public function getVATIDLength(): int
	{
		return $this->vat_id_length;
	}

	public function setVATIDLength(int $vat_id_length): self
	{
		$this->vat_id_length = $vat_id_length;
		return $this;
	}
}