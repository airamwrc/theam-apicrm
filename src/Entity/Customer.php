<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Customer implements \JsonSerializable
{
    private $serializableData = [];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="name could not be blank.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="surname could not be blank.")
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=511, nullable=true)
     */
    private $photo;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Assert\File(
     *      mimeTypes = { "image/jpeg", "image/png" },
     *      mimeTypesMessage = "Not valid image file. Allowed types are jpg and png",
     *      maxSize = "5M"
     * )
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id", nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="last_editor_id", referencedColumnName="id", nullable=false)
     */
    private $lastEditor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted = 0;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $identificationNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $businessName;

    /**
     * @ORM\Column(type="string", length=22, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=22, nullable=true)
     */
    private $phone2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contactName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tradeName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(File $imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }

    public function setCreator(User $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCreator(): User
    {
        return $this->creator;
    }

    public function setLastEditor(User $lastEditor): self
    {
        $this->lastEditor = $lastEditor;

        return $this;
    }

    public function getLastEditor(): User
    {
        return $this->lastEditor;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = new \DateTime();
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = new \DateTime();
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(?string $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getBusinessName(): ?string
    {
        return $this->businessName;
    }

    public function setBusinessName(?string $businessName): self
    {
        $this->businessName = $businessName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getPhone2(): ?string
    {
        return $this->phone2;
    }

    public function setPhone2(?string $phone2): self
    {
        $this->phone2 = $phone2;

        return $this;
    }

    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    public function getTradeName(): ?string
    {
        return $this->tradeName;
    }

    public function setTradeName(?string $tradeName): self
    {
        $this->tradeName = $tradeName;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    public function jsonSerialize(): array
    {
        $defaultSerializableData = [
            'id'                    => $this->id,
            'name'                  => $this->name,
            'surname'               => $this->surname,
            'identificationNumber'  => $this->identificationNumber,
            'address'               => $this->address,
            'businessName'          => $this->businessName,
            'tradeName'             => $this->tradeName,
            'contactName'           => $this->contactName,
            'phone'                 => $this->phone,
            'phone2'                => $this->phone2,
            'notes'                 => $this->notes,
            'creator'               => $this->creator,
            'lastEditor'            => $this->lastEditor,
            'created'               => $this->created->format('Y-m-d H:i:s'),
            'updated'               => $this->updated->format('Y-m-d H:i:s'),
        ];

        $serializableData = array_merge($defaultSerializableData, $this->serializableData);

        return $serializableData;
    }

    public function addSerializableData($newSerializableData): void
    {
        $this->serializableData = array_merge($this->serializableData, $newSerializableData);
    }
}
