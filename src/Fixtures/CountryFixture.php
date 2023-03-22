<?php

namespace VSS\Fixtures;

use Doctrine\Persistence\ObjectManager;

use VSS\Entities\Country;

class CountryFixture extends AbstractFixture
{
	private static array $countries = [
		['Germany', 'DE', 19, 9],
		['Italy',   'IT', 22, 11],
		['Greece',  'GR', 24, 9]
	];

	public function load(ObjectManager $manager)
	{
		foreach (self::$countries as $data) {
			list($name, $code, $vat, $vat_id_length) = $data;
			$country = new Country();
			$country->setName($name);
			$country->setCode($code);
			$country->setVAT($vat);
			$country->setVATIDLength($vat_id_length);

			$this->validate($country);

			$manager->persist($country);
		}

		$manager->flush();
	}
}