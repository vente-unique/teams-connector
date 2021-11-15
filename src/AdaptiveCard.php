<?php

declare(strict_types=1);

namespace Skrepr\TeamsConnector;

use Skrepr\TeamsConnector\Actions\ActionInterface;
use Skrepr\TeamsConnector\Exception\InvalidArgumentException;
use Skrepr\TeamsConnector\Mention\MentionInterface;
use Skrepr\TeamsConnector\Section\SectionInterface;
use Skrepr\TeamsConnector\Services\UtilService;

/**
 * @author Maël MENGUY <mael.menguy@gmail.com>
 */
final class AdaptiveCard implements CardInterface
{
    private string $themeColor;

    private string $title;

    private ?string $text;

    /**
     * @var SectionInterface[]
     */
    private array $sections;

    /**
     * @var ActionInterface[]
     */
    private array $potentialAction;

    /**
     * @var MentionInterface[]
     */
    private array $mentions;

    public function __construct(string $title)
    {
        $this->title = $title;
        $this->text = null;
        $this->sections = [];
        $this->potentialAction = [];
        $this->mentions = [];
        $this->setThemeColor(CardInterface::STATUS_DEFAULT);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getThemeColor(): string
    {
        return $this->themeColor;
    }

    public function setThemeColor(string $themeColor): self
    {
        UtilService::validateThemeColor($themeColor);

        $this->themeColor = $themeColor;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return SectionInterface[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    public function addSection(SectionInterface $section): self
    {
        $this->sections[] = $section;

        return $this;
    }

    /**
     * @return ActionInterface[]
     */
    public function getPotentialActions(): array
    {
        return $this->potentialAction;
    }

    public function addPotentialAction(ActionInterface $action): self
    {
        $this->potentialAction[] = $action;

        return $this;
    }

    public function getMentions(): array
    {
        return $this->mention;
    }

    public function addMention(MentionInterface $mention): self
    {
        $this->mentions[] = $mention;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'type'        => 'message',
            'attachments' => [
                [
                    'contentType' => 'application/vnd.microsoft.card.adaptive',
                    'content'     => [
                        '$schema' => 'http://adaptivecards.io/schemas/adaptive-card.json',
                        'type'    => 'AdaptiveCard',
                        'version' => '1.0',
                        'body'    => array_map(static fn(SectionInterface $section) => $section->toArray(), $this->sections),
                        'msteams' => [
                            'entities' => array_map(static fn(MentionInterface $mention) => $mention->toArray(), $this->mentions),
                        ],
                        'actions' => array_map(static fn(ActionInterface $action) => $action->toArray(), $this->potentialAction),
                    ]
                ]
            ]
        ];
    }
}
