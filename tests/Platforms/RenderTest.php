<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Tests\Platforms;

use DrevOps\EnvironmentDetector\Environment;
use DrevOps\EnvironmentDetector\Platforms\Render;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Render::class)]
#[CoversClass(Environment::class)]
final class RenderTest extends PlatformTestCase {

  /**
   * {@inheritdoc}
   */
  protected function setUp(): void {
    parent::setUp();
    $this->platformId = 'render';
  }

  public static function dataProviderActive(): \Iterator|array {
    yield [fn(): null => NULL, FALSE];
    yield [fn() => self::envSet('RENDER', '1'), TRUE];
  }

  public static function dataProviderType(): \Iterator|array {
    yield [
      fn(): null => NULL,
      NULL,
    ];
    yield [
      fn() => self::envSet('RENDER', '1') && self::envSet('RENDER_GIT_BRANCH', 'main'),
      Environment::PRODUCTION,
      function ($test): void {
          $test->assertTrue(Environment::isProd());
      },
    ];
    yield [
      fn() => self::envSet('RENDER', '1') && self::envSet('RENDER_GIT_BRANCH', 'master'),
      Environment::PRODUCTION,
      function ($test): void {
          $test->assertTrue(Environment::isProd());
      },
    ];
    yield [
      fn() => self::envSet('RENDER', '1') && self::envSet('RENDER_GIT_BRANCH', 'staging'),
      Environment::STAGE,
      function ($test): void {
          $test->assertTrue(Environment::isStage());
      },
    ];
    yield [
      fn() => self::envSet('RENDER', '1') && self::envSet('RENDER_GIT_BRANCH', 'develop'),
      Environment::DEVELOPMENT,
      function ($test): void {
          $test->assertTrue(Environment::isDev());
      },
    ];
    yield [
      fn() => self::envSet('RENDER', '1') && self::envSet('RENDER_GIT_BRANCH', 'feature/foo'),
      Environment::PREVIEW,
      function ($test): void {
          $test->assertTrue(Environment::isPreview());
      },
    ];
    // No branch info: defaults to preview.
    yield [
      fn() => self::envSet('RENDER', '1'),
      Environment::PREVIEW,
      function ($test): void {
          $test->assertTrue(Environment::isPreview());
      },
    ];
  }

}
