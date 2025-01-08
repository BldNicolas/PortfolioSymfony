<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?User $userProfile = null;

    /**
     * @var Collection<int, ProfileSection>
     */
    #[ORM\OneToMany(targetEntity: ProfileSection::class, mappedBy: 'profile')]
    private Collection $profileSections;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'profile')]
    private Collection $projects;

    public function __construct()
    {
        $this->profileSections = new ArrayCollection();
        $this->projects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getUserProfile(): ?User
    {
        return $this->userProfile;
    }

    public function setUserProfile(?User $userProfile): static
    {
        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * @return Collection<int, ProfileSection>
     */
    public function getProfileSections(): Collection
    {
        return $this->profileSections;
    }

    public function addProfileSection(ProfileSection $profileSection): static
    {
        if (!$this->profileSections->contains($profileSection)) {
            $this->profileSections->add($profileSection);
            $profileSection->setProfile($this);
        }

        return $this;
    }

    public function removeProfileSection(ProfileSection $profileSection): static
    {
        if ($this->profileSections->removeElement($profileSection)) {
            // set the owning side to null (unless already changed)
            if ($profileSection->getProfile() === $this) {
                $profileSection->setProfile(null);
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
            $project->setProfile($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getProfile() === $this) {
                $project->setProfile(null);
            }
        }

        return $this;
    }
}
