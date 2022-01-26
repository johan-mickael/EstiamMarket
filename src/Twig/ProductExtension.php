<?php

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ProductExtension extends AbstractExtension
{
	public function getFilters()
	{
		return [
			new TwigFilter('category', [$this, 'concatCategories']),
		];
	}

	public function concatCategories(PersistentCollection $categories)
	{
		$res = '';
		foreach ($categories as $category) {
			$res .= ($category->getLabel()) . ' - ';
		}
		return substr($res, 0, strlen($res) - 2);
	}
}
