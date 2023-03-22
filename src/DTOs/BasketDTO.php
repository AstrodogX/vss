<?php

namespace VSS\DTOs;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use VSS\Entities\Country;
use VSS\Entities\Product;
use VSS\Repositories\CountryRepository;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class BasketDTO
{
	#[Assert\Count(
		min: 1,
		minMessage: 'Please choose at least one product.'
	)]
	private Collection $products;

	#[Assert\NotBlank(message: 'VAT ID can\'t be blank.')]
	private string $vat_id = '';

	private ?Country $country = null;

	public function __construct(private CountryRepository $country_repository)
	{
		$this->products = new ArrayCollection();
	}

	public function getProducts(): Collection
	{
		return $this->products;
	}

	public function setProducts(Collection $products): static
	{
		$this->products = $products;
		return $this;
	}

	public function getVATID(): string
	{
		return $this->vat_id;
	}

	public function setVATID(string $vat_id): static
	{
		$vat_id = trim($vat_id);
		if ($this->vat_id != $vat_id) {
			$this->vat_id = $vat_id;
			$this->country = null;
		}
		return $this;
	}

	public function getCountry(): ?Country
	{
		return $this->country;
	}

	public function getVAT(): ?int
	{
		return $this->country?->getVAT();
	}

	public function getTotalPrice(): float
	{
		$result = 0;

		foreach ($this->products as $product) {
			/** @var Product $product */
			$result += $product->getPrice();
		}

		return $result;
	}

	public function getFinalPrice(): ?float
	{
		$price = $this->getTotalPrice();

		if ($vat = $this->getVAT()) {
			$price += $price * ($vat / 100.0);
		}

		return $price;
	}

	private function validateVATID(): ?string
	{
		preg_match('/^([a-zA-Z]{2})(\d{9,11})$/', $this->vat_id, $matches);

		if ($matches == false) {
			return 'Invalid VAT ID provided.';
		}

		list (, $code, $id) = $matches;

		$this->country = $this->country_repository->findOneBy(['code' => strtoupper($code)]);

		if ($this->country == null) {
			return 'Sorry, but these products are not available in your country.';
		}

		if (strlen($id) != $this->country->getVATIDLength()) {
			$this->country = null;
			return 'VAT ID has an invalid length for your country.';
		}

		return null;
	}

	#[Assert\Callback]
	public function validate(ExecutionContextInterface $context): void
	{
		if ($error = $this->validateVATID()) {
			$context->buildViolation($error)
				->atPath('vat_id')
				->addViolation()
			;
		}
	}
}