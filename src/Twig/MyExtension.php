<?php

namespace App\Twig;

use Doctrine\ORM\PersistentCollection;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class MyExtension extends AbstractExtension
{
	public function getFilters()
	{
		return [
			new TwigFilter('category', [$this, 'concatCategories']),
			new TwigFilter('jsonArray', [$this, 'printJsonArray']),
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

	public function printJsonArray($json)
	{
		$res = '';
		foreach ($json as $item) {
			$res .= $item . ', ';
		}
		return substr($res, 0, strlen($res) - 2);
	}
}
