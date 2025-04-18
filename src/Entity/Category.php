<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CategoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'Category:item']),
        new GetCollection(normalizationContext: ['groups' => 'Category:list'])
    ],
    order: ['createdAt' => 'DESC'],
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['conference' => 'exact'])]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Category:list', 'Category:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['Category:list', 'Category:item'])]
    private ?string $name = null;

    /**
     * @var Collection<int, NewCookBook>
     */
    #[ORM\OneToMany(targetEntity: NewCookBook::class, mappedBy: 'category')]
    #[Groups(['Category:list', 'Category:item'])]
    private Collection $newCookBooks;

    public function __construct()
    {
        $this->newCookBooks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, NewCookBook>
     */
    public function getNewCookBooks(): Collection
    {
        return $this->newCookBooks;
    }

    public function addNewCookBook(NewCookBook $newCookBook): self
    {
        if (!$this->getNewCookBooks->contains($newCookBook)) {
            $this->newCookBooks->add($newCookBook);
            $newCookBook->setCategory($this);
        }

        return $this;
    }

    public function removeNewCookBook(NewCookBook $newCookBook): self
    {
        if ($this->newCookBooks->removeElement($newCookBook)) {
            // set the owning side to null (unless already changed)
            if ($newCookBook->getCategory() === $this) {
                $newCookBook->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
