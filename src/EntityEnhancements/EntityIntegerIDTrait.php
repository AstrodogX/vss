<?php

namespace VSS\EntityEnhancements;

use Doctrine\ORM\Mapping as ORM;

trait EntityIntegerIDTrait
{
	#[ORM\Id]
	#[ORM\Column(type: 'integer')]
	#[ORM\GeneratedValue]
	protected ?int $id = null;

	public function getID(): ?int
	{
		return $this->id;
	}
}