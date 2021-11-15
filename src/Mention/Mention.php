<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector\Mention;

/**
 * @author Maël MENGUY <mael.menguy@gmail.com>
 */
final class Mention implements MentionInterface
{
    private string $mentionText;

    /**
     * @var array<int, array<string, string>>
     */
    private array $mentioned;

    public function __construct(string $mentionText)
    {
        $this->mentionText = sprintf('<at>%s</at>', $mentionText);
        $this->mentioned   = [];
    }

    public function getMentionText(): string
    {
        return $this->mentionText;
    }

    public function setMentionText(string $mentionText): self
    {
        $this->mentionText = $mentionText;

        return $this;
    }

    public function getMentioned(): array
    {
        return $this->mentioned;
    }

    public function setMentioned(string $id, string $name): self
    {
        $this->mentioned = [
            'id' => $id,
            'name' => $name,
        ];

        return $this;
    }

    public function clearMentioned(): self
    {
        $this->mentioned = [];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => 'mention',
            'text' => $this->mentionText,
            'mentioned' => $this->mentioned,
        ];
    }
}
