<?php

declare(strict_types=1);

namespace BeBat\Verify\Test\Stub;

/**
 * Example class for testing attribute access.
 */
class ExampleChild extends ExampleParent
{
    /** @var string */
    public $childPublic = 'child public property';

    /** @var string */
    public static $childStaticPublic = 'child static public property';

    /** @var string */
    protected $childProtected = 'child protected property';

    /** @var string */
    protected static $childStaticProtected = 'child static protected property';

    /** @var string */
    private $childPrivate = 'child private property';

    /** @var string */
    private static $childStaticPrivate = 'child static private property';
}
