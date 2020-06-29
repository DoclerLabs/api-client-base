<?php declare(strict_types=1);

namespace DoclerLabs\ApiClientBase\Response;

use DoclerLabs\ApiClientBase\Response\Mapper\ResponseMapperInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \DoclerLabs\ApiClientBase\Response\ResponseMapperRegistry
 */
class ResponseMapperRegistryTest extends TestCase
{
    /**
     * @covers ::add
     * @covers ::get
     */
    public function testRegistry()
    {
        $schemaClassName = 'test';
        $mapper          = $this->createMock(ResponseMapperInterface::class);
        $registry        = new ResponseMapperRegistry();
        $registry->add(
            $schemaClassName,
            static function () use ($mapper) {
                return $mapper;
            }
        );

        $this->assertEquals($registry->get($schemaClassName), $mapper);
    }

    /**
     * @covers ::add
     * @covers ::get
     */
    public function testRegistryErrorWrongKey()
    {
        $mapper   = $this->createMock(ResponseMapperInterface::class);
        $registry = new ResponseMapperRegistry();
        $registry->add(
            'right',
            static function () use ($mapper) {
                return $mapper;
            }
        );

        $this->expectException(InvalidArgumentException::class);
        $this->assertEquals($registry->get('wrong'), $mapper);
    }

    /**
     * @covers ::add
     * @covers ::get
     */
    public function testRegistryErrorDuplicate()
    {
        $mapper   = $this->createMock(ResponseMapperInterface::class);
        $registry = new ResponseMapperRegistry();
        $registry->add(
            'double',
            static function () use ($mapper) {
                return $mapper;
            }
        );
        $this->expectException(InvalidArgumentException::class);
        $registry->add(
            'double',
            static function () use ($mapper) {
                return $mapper;
            }
        );
    }
}
