<?php declare(strict_types=1);

namespace App\Events\Tests\Support\Behaviours;

use Symfony\Component\BrowserKit\AbstractBrowser;

/**
 * Trait BootTestClient
 *
 * @package App\Events\Tests\Support\Behaviours
 * @subpackage App\Events\Tests\Support\Behaviours\BootTestClient
 *
 * @method void setKernelClass()
 * @method void setUpTests()
 */
trait BootTestClient
{

    protected ?AbstractBrowser $__kernelBrowserClient = null;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        if (method_exists($this, 'setKernelClass')) {
            self::setKernelClass();
        }

        $this->__kernelBrowserClient = self::createClient();

        if (method_exists($this, 'setUpTests')) {
            $this->setUpTests();
        }
    }
}
