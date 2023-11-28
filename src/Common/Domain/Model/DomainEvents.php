<?php

namespace Common\Domain\Model;

/*            <<<SQL
                INSERT INTO domain_events (id, aggregate_id, name, body, occurred_on)
                VALUES ($id, $aggregateId, $name, $body, $occurredOn);
            SQL*/
class DomainEvents
{
    public function __construct(
        private readonly string $id,
        private string $aggregateId,
        private string $name,
        private readonly array $body,
        private readonly string $occurredOn
    ) {}


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function getOccurredOn(): string
    {
        return $this->occurredOn;
    }

    public function setAggregateId(string $aggregateId): static
    {
        $this->aggregateId = $aggregateId;
        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }


}