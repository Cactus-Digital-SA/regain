<?php

namespace App\Domains\Categories\Models;

use App\Models\CactusEntity;

class Category extends CactusEntity
{

    //Todo connect to Results Type to be a multiple select2
    //Todo add a notify_practitioner_days

    /** Todo
     * Add a required information @var RequiredInfo $info that will be prompted to the practitioner if the tests it's finished
     */

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

    /**
     * @var int|null $sort
     * @JMS\Serializer\Annotation\SerializedName("sort")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $sort;


    /** @var Category|null $parent
     * @JMS\Serializer\Annotation\SerializedName("parent")
     * @JMS\Serializer\Annotation\Type("App\Domains\Categories\Models\Category")
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
            'sort' => $this->sort ?? null,
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

    /**
     * @return int|null
     */
    public function getSort(): ?int
    {
        return $this->sort;
    }

    /**
     * @param int|null $sort
     * @return Category
     */
    public function setSort(?int $sort): Category
    {
        $this->sort = $sort;
        return $this;
    }


}
