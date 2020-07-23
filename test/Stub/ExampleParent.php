<?php

declare(strict_types=1);

namespace BeBat\Verify\Test\Stub;

/**
 * Example class for testing attribute access.
 */
class ExampleParent
{
    /** @var string */
    public $parentPublic = 'parent public property';

    /** @var string */
    public static $parentStaticPublic = 'parent static public property';

    /** @var string */
    protected $parentProtected = 'parent protected property';

    /** @var string */
    protected static $parentStaticProtected = 'parent static protected property';

    /** @var string */
    private $parentPrivate = 'parent private property';

    /** @var string */
    private static $parentStaticPrivate = 'parent static private property';
}
