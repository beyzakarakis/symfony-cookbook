<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\NewCookBookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
#use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
#use Symfony\Component\String\Slugger\SluggerInterface;
use Gedmo\Mapping\Annotation as Gedmo;
#use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Controller\NewCookBookController;



#[ORM\Entity(repositoryClass: NewCookBookRepository::class)]
#[UniqueEntity('slug')]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'NewCookBook:item']),
        new GetCollection(normalizationContext: ['groups' => 'NewCookBook:list'])
    ],
    order: ['year' => 'DESC', 'city' => 'ASC'],
    paginationEnabled: false,
)]
class NewCookBook
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['NewCookBook:list', 'NewCookBook:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)]
    #[Groups(['NewCookBook:list', 'NewCookBook:item'])]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['NewCookBook:list', 'NewCookBook:item'])]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['NewCookBook:list', 'NewCookBook:item'])]
    private ?float $size = null;

    #[ORM\ManyToOne(inversedBy: 'newCookBook')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['NewCookBook:list', 'NewCookBook:item'])]
    private ?Category $category = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageFile = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\Column]
    private ?float $recommend_price = null;

    #[ORM\Column]
    private ?float $cost_percentage = null;

    #[ORM\Column(nullable: true)]
    private ?int $time1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $time2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $time3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $preparing = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $service = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(?float $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): static
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getRecommendPrice(): ?float
    {
        return $this->recommend_price;
    }

    public function setRecommendPrice(float $recommend_price): static
    {
        $this->recommend_price = $recommend_price;

        return $this;
    }

    public function getCostPercentage(): ?float
    {
        return $this->cost_percentage;
    }

    public function setCostPercentage(float $cost_percentage): static
    {
        $this->cost_percentage = $cost_percentage;

        return $this;
    }

    public function getTime1(): ?int
    {
        return $this->time1;
    }

    public function setTime1(?int $time1): static
    {
        $this->time1 = $time1;

        return $this;
    }

    public function getTime2(): ?int
    {
        return $this->time2;
    }

    public function setTime2(?int $time2): static
    {
        $this->time2 = $time2;

        return $this;
    }

    public function getTime3(): ?int
    {
        return $this->time3;
    }

    public function setTime3(?int $time3): static
    {
        $this->time3 = $time3;

        return $this;
    }

    public function getPreparing(): ?string
    {
        return $this->preparing;
    }

    public function setPreparing(?string $preparing): static
    {
        $this->preparing = $preparing;

        return $this;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(?string $service): static
    {
        $this->service = $service;

        return $this;
    }
}
