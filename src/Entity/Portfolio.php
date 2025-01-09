<?php

namespace App\Entity;

use App\Repository\PortfolioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortfolioRepository::class)]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    #[ORM\OneToOne(inversedBy: 'portfolio', cascade: ['persist', 'remove'])]
    private ?About $about = null;

    /**
     * @var Collection<int, AboutCustomSection>
     */
    #[ORM\OneToMany(targetEntity: AboutCustomSection::class, mappedBy: 'portfolio', cascade: ['persist', 'remove'])]
    private Collection $aboutCustomSection;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'portfolio', cascade: ['persist', 'remove'])]
    private Collection $projects;

    /**
     * @var Collection<int, Experience>
     */
    #[ORM\OneToMany(targetEntity: Experience::class, mappedBy: 'portfolio')]
    private Collection $experiences;

    /**
     * @var Collection<int, AboutCustomSection>
     */
    #[ORM\OneToMany(targetEntity: AboutCustomSection::class, mappedBy: 'portfolio')]
    private Collection $aboutCustomSections;

    public function __construct()
    {
        $this->aboutCustomSection = new ArrayCollection();
        $this->projects = new ArrayCollection();
        $this->experiences = new ArrayCollection();
        $this->aboutCustomSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAbout(): ?About
    {
        return $this->about;
    }

    public function setAbout(?About $about): static
    {
        $this->about = $about;

        return $this;
    }

    /**
     * @return Collection<int, AboutCustomSection>
     */
    public function getAboutCustomSection(): Collection
    {
        return $this->aboutCustomSection;
    }

    public function addAboutCustomSection(AboutCustomSection $aboutCustomSection): static
    {
        if (!$this->aboutCustomSection->contains($aboutCustomSection)) {
            $this->aboutCustomSection->add($aboutCustomSection);
            $aboutCustomSection->setPortfolio($this);
        }

        return $this;
    }

    public function removeAboutCustomSection(AboutCustomSection $aboutCustomSection): static
    {
        if ($this->aboutCustomSection->removeElement($aboutCustomSection)) {
            // set the owning side to null (unless already changed)
            if ($aboutCustomSection->getPortfolio() === $this) {
                $aboutCustomSection->setPortfolio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setPortfolio($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getPortfolio() === $this) {
                $project->setPortfolio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Experience>
     */
    public function getExperiences(): Collection
    {
        return $this->experiences;
    }

    public function addExperience(Experience $experience): static
    {
        if (!$this->experiences->contains($experience)) {
            $this->experiences->add($experience);
            $experience->setPortfolio($this);
        }

        return $this;
    }

    public function removeExperience(Experience $experience): static
    {
        if ($this->experiences->removeElement($experience)) {
            // set the owning side to null (unless already changed)
            if ($experience->getPortfolio() === $this) {
                $experience->setPortfolio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AboutCustomSection>
     */
    public function getAboutCustomSections(): Collection
    {
        return $this->aboutCustomSections;
    }
}
