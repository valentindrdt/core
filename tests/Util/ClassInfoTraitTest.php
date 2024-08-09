<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\Tests\Util;

use ApiPlatform\Metadata\Util\ClassInfoTrait;
use ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy;
use PHPUnit\Framework\TestCase;

class ClassInfoTraitTest extends TestCase
{
    private function getClassInfoTraitImplementation()
    {
        return new class {
            use ClassInfoTrait {
                ClassInfoTrait::getRealClassName as public;
            }
        };
    }

    public function testDoctrineRealClassName(): void
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertSame(Dummy::class, $classInfo->getRealClassName('Proxies\__CG__\ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy'));
    }

    public function testProxyManagerRealClassName(): void
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertSame(Dummy::class, $classInfo->getRealClassName('MongoDBODMProxies\__PM__\ApiPlatform\Tests\Fixtures\TestBundle\Entity\Dummy\Generated'));
    }

    public function testUnmarkedRealClassName(): void
    {
        $classInfo = $this->getClassInfoTraitImplementation();

        $this->assertSame(Dummy::class, $classInfo->getRealClassName(Dummy::class));
    }
}
