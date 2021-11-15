<?php
declare(strict_types=1);

namespace Skrepr\TeamsConnector\Services;


/**
 * @author Maël MENGUY <mael.menguy@gmail.com>
 */
class UtilService
{
    public static function validateThemeColor(string $themeColor): void
{
    if (!preg_match('/^#([0-9a-f]{6}|[0-9a-f]{3})$/i', $themeColor)) {
        throw new InvalidArgumentException('MessageCard themeColor must have a valid hex color format.');
    }
}
}
