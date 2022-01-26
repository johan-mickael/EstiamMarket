<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type: 'integer')]
	private $id;

	#[ORM\Column(type: 'string', length: 255)]
	private $label;

	#[ORM\Column(type: 'string', length: 255, nullable: true)]
	private $image;

	#[ORM\Column(type: 'text', nullable: true)]
	private $description;

	#[ORM\Column(type: 'datetime', nullable: true)]
	private $creation_date;

	#[ORM\Column(type: 'decimal', precision: 21, scale: 2)]
	private $ht_price;

	#[ORM\Column(type: 'integer')]
	private $vat;

	#[ORM\Column(type: 'float')]
	private $quantity;

	#[ORM\Column(type: 'string', length: 50)]
	private $reference;

	#[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'products')]
	private $categories;

	public function __construct()
	{
		$this->categories = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getLabel(): ?string
	{
		return $this->label;
	}

	public function setLabel(string $label): self
	{
		$this->label = $label;

		return $this;
	}

	public function getImage(): ?string
	{
		return $this->image;
	}

	public function setImage(?string $image): self
	{
		$this->image = $image;

		return $this;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function setDescription(?string $description): self
	{
		$this->description = $description;

		return $this;
	}

	public function getCreationDate(): ?\DateTimeInterface
	{
		return $this->creation_date;
	}

	public function setCreationDate(?\DateTimeInterface $creation_date): self
	{
		$this->creation_date = $creation_date;
		return $this;
	}

	public function getHtPrice(): ?string
	{
		return $this->ht_price;
	}

	public function setHtPrice(string $ht_price): self
	{
		$this->ht_price = $ht_price;
		return $this;
	}

	public function getVat(): ?int
	{
		return $this->vat;
	}

	public function setVat(int $vat): self
	{
		$this->vat = $vat;

		return $this;
	}

	public function getQuantity(): ?float
	{
		return $this->quantity;
	}

	public function setQuantity(float $quantity): self
	{
		$this->quantity = $quantity;
		return $this;
	}

	public function getReference(): ?string
	{
		return $this->reference;
	}

	public function setReference(string $reference): self
	{
		$this->reference = $reference;
		return $this;
	}

	/**
	 * @return Collection|Category[]
	 */
	public function getCategories(): Collection
	{
		return $this->categories;
	}

	public function addCategories(Category $category): self
	{
		if (!$this->categories->contains($category)) {
			$this->categories[] = $category;
		}
		return $this;
	}

	public function removeCategories(Category $categories): self
	{
		$this->categories->removeElement($categories);
		return $this;
	}

	public function getCategoriesString(): string {
		$res = '';
		foreach ($this->categories as $item) {
			$res .= $item->label . ', ';
		}
		return $res;
	}
}
