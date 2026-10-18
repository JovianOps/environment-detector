<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Tests\Platforms;

use DrevOps\EnvironmentDetector\Environment;
use DrevOps\EnvironmentDetector\Platforms\Vercel;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Vercel::class)]
#[CoversClass(Environment::class)]
final class VercelTest extends PlatformTestCase {

  public static function dataProviderActive(): \Iterator|array {
    yield [fn(): null => NULL, FALSE];
    yield [fn() => self::envSet('VERCEL', '1'), TRUE];
  }

  public static function dataProviderType(): \Iterator|array {
    yield [
      fn(): null => NULL,
      NULL,
    ];
    yield [
      fn() => self::envSetMultiple(['VERCEL' => '1', 'VERCEL_ENV' => 'production']),
      Environment::PRODUCTION,
    ];
    yield [
      fn() => self::envSetMultiple(['VERCEL' => '1', 'VERCEL_ENV' => 'development']),
      Environment::DEVELOPMENT,
    ];
    yield [
      fn() => self::envSetMultiple(['VERCEL' => '1', 'VERCEL_ENV' => 'preview']),
      Environment::PREVIEW,
    ];
    yield [
      fn() => self::envSet('VERCEL', '1'),
      Environment::PREVIEW,
    ];
  }

}
