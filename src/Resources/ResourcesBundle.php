<?php declare(strict_types=1);

namespace App\Events\Resources;

use Somnambulist\Components\Domain\Doctrine\TypeBootstrapper;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ResourcesBundle
 *
 * @package    App\Events\Resources
 * @subpackage App\Events\Resources\ResourcesBundle
 */
class ResourcesBundle extends Bundle
{

    public function boot()
    {
        $this->registerDoctrineTypesAndEnumerations();
    }

    private function registerDoctrineTypesAndEnumerations()
    {
        TypeBootstrapper::registerEnumerations();
        TypeBootstrapper::registerTypes(TypeBootstrapper::$types);
    }
}
