<?php

namespace App\Domains\Tests\Models;

use App\Domains\Categories\Models\Category;
use App\Domains\Questions\Models\Question;
use App\Domains\Results\Models\Threshold;
use App\Domains\Subscales\Models\Subscale;
use App\Models\CactusEntity;

class Test extends CactusEntity
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
    /**
     * @var int|null $sort
     * @JMS\Serializer\Annotation\SerializedName("sort")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $sort;
    /** @var Category|null $category
     * @JMS\Serializer\Annotation\SerializedName("category")
     * @JMS\Serializer\Annotation\Type("App\Domains\Categories\Models\Category")
     */
    private ?Category $category;
    /** @var int|null $category_id
     * @JMS\Serializer\Annotation\SerializedName("category_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private ?int $category_id;
    /**
     * @var Subscale[] $subscales
     * @JMS\Serializer\Annotation\SerializedName("subscales")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Subscales\Models\Subscale>")
     */
    private array $subscales = [];
    /**
     * @var Question[] $questions
     * @JMS\Serializer\Annotation\SerializedName("questions")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Questions\Models\Question>")
     */
    private array $questions = [];
    /**
     * @var Threshold[]|null $thresholds
     * @JMS\Serializer\Annotation\SerializedName("thresholds")
     * @JMS\Serializer\Annotation\Type("array<App\Domains\Results\Models\Threshold>")
     */
    private ?array $thresholds = [];

    /**
     * @param bool $withRelations
     * @return array
     */
    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'          => $this->id,
            'name'        => $this->name,
            'category_id' => $this->category_id ?? null,
            'sort'        => $this->sort ?? null
        ];

        if ($withRelations) {
            $data['category']   = $this->getCategory();
            $data['subscales']  = $this->getSubscales();
            $data['questions']  = $this->getQuestions();
            $data['thresholds'] = $this->getThresholds();
        }

        return $data;
    }

    /**
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Test
     */
    public function setCategory(Category $category): Test
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return array
     */
    public function getSubscales(): array
    {
        return $this->subscales;
    }

    /**
     * @param array $subscales
     * @return $this
     */
    public function setSubscales(array $subscales): Test
    {
        $this->subscales = $subscales;

        return $this;
    }

    /**
     * @return array
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    /**
     * @param array $questions
     * @return $this
     */
    public function setQuestions(array $questions): Test
    {
        $this->questions = $questions;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getThresholds(): ?array
    {
        return $this->thresholds;
    }

    /**
     * @param array|null $thresholds
     * @return Test
     */
    public function setThresholds(?array $thresholds): Test
    {
        $this->thresholds = $thresholds;

        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): Test
    {
        $this->id = $id;

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
     * @return Test
     */
    public function setSort(?int $sort): Test
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    /**
     * @param int|null $category_id
     * @return Test
     */
    public function setCategoryId(?int $category_id): Test
    {
        $this->category_id = $category_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Test
     */
    public function setName(string $name): Test
    {
        $this->name = $name;

        return $this;
    }
}
