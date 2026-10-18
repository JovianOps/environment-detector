<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Tests\Platforms;

use DrevOps\EnvironmentDetector\Environment;
use DrevOps\EnvironmentDetector\Platforms\Vercel;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Vercel::class)]
#[CoversClass(Environment::class)]
final class VercelTest extends PlatformTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->platformId = 'vercel';
  }

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
      fn() => self::envSet('VERCEL', '1') && self::envSet('VERCEL_ENV', 'production'),
      Environment::PRODUCTION,
      function ($test): void {
          $test->assertTrue(Environment::isProd());
      },
    ];
    yield [
      fn() => self::envSet('VERCEL', '1') && self::envSet('VERCEL_ENV', 'development'),
      Environment::DEVELOPMENT,
      function ($test): void {
          $test->assertTrue(Environment::isDev());
      },
    ];
    yield [
      fn() => self::envSet('VERCEL', '1') && self::envSet('VERCEL_ENV', 'preview'),
      Environment::PREVIEW,
      function ($test): void {
          $test->assertTrue(Environment::isPreview());
      },
    ];
    // VERCEL_ENV unset defaults to preview.
    yield [
      fn() => self::envSet('VERCEL', '1'),
      Environment::PREVIEW,
      function ($test): void {
          $test->assertTrue(Environment::isPreview());
      },
    ];
  }

}
