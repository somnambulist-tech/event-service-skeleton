<?php declare(strict_types=1);

namespace App\Events\Tests\Support\Behaviours;

use App\Events\Tests\Support\ObjectFactoryHelper;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;
use function sprintf;

/**
 * Trait UseObjectFactoryHelper
 *
 * @package    App\Events\Tests\Support\Behaviours
 * @subpackage App\Events\Tests\Support\Behaviours\UseObjectFactoryHelper
 *
 * @property-read Generator           $faker
 * @property-read ObjectFactoryHelper $factory
 */
trait UseObjectFactoryHelper
{

    private ?ObjectFactoryHelper $unitTester = null;

    public function __get($name)
    {
        switch ($name) {
            case 'faker': return $this->factory()->faker();
            case 'factory': return $this->factory();
        }

        throw new InvalidArgumentException(sprintf('No property found for "%s"', $name));
    }

    protected function factory(string $locale = Factory::DEFAULT_LOCALE): ObjectFactoryHelper
    {
        if (!$this->unitTester instanceof ObjectFactoryHelper) {
            $this->unitTester = new ObjectFactoryHelper($locale);
        }

        return $this->unitTester;
    }
}
