<?php declare(strict_types=1);

namespace App\Events\Delivery\Api;

use Somnambulist\ApiBundle\Controllers\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class IndexController
 *
 * @package    App\Events\Delivery\Api
 * @subpackage App\Events\Delivery\Api\IndexController
 */
class IndexController extends ApiController
{

    public function __invoke()
    {
        return new JsonResponse(['services' => ['events']]);
    }
}
