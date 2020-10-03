<?php declare(strict_types=1);

namespace App\Events\Tests\Support\Behaviours;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Trait GenerateRouteTo
 *
 * @package    App\Events\Tests\Support\Behaviours
 * @subpackage App\Events\Tests\Support\Behaviours\GenerateRouteTo
 *
 * @property ContainerInterface static $container
 */
trait GenerateRouteTo
{

    /**
     * Create a route from the named route with the specified parameters
     *
     * @param string $name
     * @param array  $parameters
     *
     * @return mixed
     */
    protected function routeTo(string $name, array $parameters = []): string
    {
        return static::$container->get('router')->getGenerator()->generate($name, $parameters);
    }
}
