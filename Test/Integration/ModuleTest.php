<?php declare(strict_types=1);

namespace Yireo\LokiCheckoutMollie\Test\Integration;

use PHPUnit\Framework\TestCase;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\AssertModuleIsEnabled;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\AssertModuleIsRegistered;
use Yireo\IntegrationTestHelper\Test\Integration\Traits\AssertModuleIsRegisteredForReal;

class ModuleTest extends TestCase
{
    use AssertModuleIsRegistered;
    use AssertModuleIsRegisteredForReal;
    use AssertModuleIsEnabled;

    public function testIfModuleIsEnabled()
    {
        // @todo: Follow module.xml dependencies instead
        $requiredModules = [
            'Yireo_LokiCheckoutMollie',
            'Yireo_LokiCheckout',
            'Mollie_Payment',
        ];
        foreach ($requiredModules as $moduleName) {
            $this->assertModuleIsRegistered($moduleName);
            $this->assertModuleIsRegisteredForReal($moduleName);
            $this->assertModuleIsEnabled($moduleName);
        }
    }
}
