<?php

declare(strict_types=1);

namespace App\Domains\Questions\Models;

use App\Domains\Responses\Models\Response;
use App\Models\CactusEntity;
use DateTime;

class QuestionResponse extends CactusEntity
{
    /**
     * @JMS\Serializer\Annotation\SerializedName("id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $id;
    /**
     * @JMS\Serializer\Annotation\SerializedName("question_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $questionId;
    /**
     * @JMS\Serializer\Annotation\SerializedName("response_id")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $responseId;
    /**
     * @JMS\Serializer\Annotation\SerializedName("score")
     * @JMS\Serializer\Annotation\Type("int")
     */
    private int $score;
    /**
     * @JMS\Serializer\Annotation\SerializedName("created_at")
     * @JMS\Serializer\Annotation\Type("DateTime")
     */
    private DateTime $createdAt;
    /**
     * @JMS\Serializer\Annotation\SerializedName("updated_at")
     * @JMS\Serializer\Annotation\Type("DateTime")
     */
    private DateTime $updatedAt;
    /**
     * @JMS\Serializer\Annotation\SerializedName("question")
     * @JMS\Serializer\Annotation\Type("App\Domains\Questions\Models\Question")
     */
    private ?Question $question = null;
    /**
     * @JMS\Serializer\Annotation\SerializedName("response")
     * @JMS\Serializer\Annotation\Type("App\Domains\Responses\Models\Response")
     */
    private ?Response $response = null;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): QuestionResponse
    {
        $this->id = $id;

        return $this;
    }

    public function getQuestionId(): int
    {
        return $this->questionId;
    }

    public function setQuestionId(int $questionId): QuestionResponse
    {
        $this->questionId = $questionId;

        return $this;
    }

    public function getResponseId(): int
    {
        return $this->responseId;
    }

    public function setResponseId(int $responseId): QuestionResponse
    {
        $this->responseId = $responseId;

        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function setScore(int $score): QuestionResponse
    {
        $this->score = $score;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): QuestionResponse
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): QuestionResponse
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): QuestionResponse
    {
        $this->question = $question;

        return $this;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function setResponse(?Response $response): QuestionResponse
    {
        $this->response = $response;

        return $this;
    }

    public function getValues(bool $withRelations = true): array
    {
        $data = [
            'id'          => $this->id,
            'question_id' => $this->questionId,
            'response_id' => $this->responseId,
            'score'       => $this->score,
            'created_at'  => $this->createdAt,
            'updated_at'  => $this->updatedAt,
        ];

        if ($withRelations) {
            $data['question'] = $this->getQuestion();
            $data['response'] = $this->getResponse();
        }

        return $data;
    }
}
