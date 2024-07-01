<?php

namespace App\Domains\Tests\Models;

use App\Models\CactusEntity;

class Category extends CactusEntity
{

    /**
     * @var int $id
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;


    /** @var string $name
     * @JMS\Serializer\Annotation\SerializedName("name")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $name;


    /** @var string $slug
     * @JMS\Serializer\Annotation\SerializedName("slug")
     * @JMS\Serializer\Annotation\Type("string")
     */
    private string $slug;


    /** @var int|null $parent_id
     * @JMS\Serializer\Annotation\SerializedName("parent_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $parent_id = null;

    /**
     * @var bool $status
     * @JMS\Serializer\Annotation\SerializedName("status")
     * @JMS\Serializer\Annotation\Type("bool")
     */
    private bool $status = true;


    /** @var Category|null $parent
     * @JMS\Serializer\Annotation\SerializedName("parent")
     * @JMS\Serializer\Annotation\Type("App\Domains\Tests\Models\Category")
     */
    private ?Category $parent = null;

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'parent_id' => $this->parent_id,
            'status' => $this->status,
        ];

        if ($withRelations) {
            $data['parent'] = $this->getParent();
        }

        return $data;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Category
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): Category
    {
        $this->slug = $slug;
        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): Category
    {
        $this->parent_id = $parent_id;
        return $this;
    }

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): Category
    {
        $this->status = $status;
        return $this;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(?Category $parent): Category
    {
        $this->parent = $parent;
        return $this;
    }




}
