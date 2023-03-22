<?php

namespace VSS\Fixtures;

use Doctrine\Persistence\ObjectManager;

use VSS\Entities\Product;

class ProductFixture extends AbstractFixture
{
	private static array $products = [
		['Earphones',   100.0],
		['Phone Case',   20.0]
	];

	public function load(ObjectManager $manager)
	{
		foreach (self::$products as $data) {
			list($name, $price) = $data;
			$product = new Product();
			$product->setName($name);
			$product->setPrice($price);

			$this->validate($product);

			$manager->persist($product);
		}

		$manager->flush();
	}
}