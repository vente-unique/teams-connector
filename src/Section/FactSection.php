<?php

namespace Skrepr\TeamsConnector\Section;

class FactSection implements SectionInterface
{
    /**
     * @var array<int, array<string, string>>
     */
    private array $facts;

    public function __construct(string $activityTitle)
    {
        $this->facts = [];
    }

    public function getFacts(): array
    {
        return $this->facts;
    }

    public function addFact(string $name, string $value): self
    {
        $this->facts[] = [
            'title' => $name,
            'value' => $value,
        ];

        return $this;
    }

    public function clearFacts(): self
    {
        $this->facts = [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type'=> 'FactSet',
            'facts' => $this->facts,
        ];
    }
}
