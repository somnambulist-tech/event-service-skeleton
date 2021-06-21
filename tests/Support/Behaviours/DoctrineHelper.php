<?php declare(strict_types=1);

namespace App\Events\Tests\Support\Behaviours;

use Doctrine\ORM\EntityManagerInterface;
use Somnambulist\Components\Domain\Doctrine\AbstractEntityLocator;

/**
 * Trait DoctrineHelper
 *
 * @package    App\Events\Tests\Support\Behaviours
 * @subpackage App\Events\Tests\Support\Behaviours\DoctrineHelper
 */
trait DoctrineHelper
{

    protected function doctrine(): EntityManagerInterface
    {
        return static::getContainer()->get('doctrine')->getManager();
    }

    protected function locatorFor(string $class): AbstractEntityLocator
    {
        return static::getContainer()->get('doctrine')->getManager()->getRepository($class);
    }
}
