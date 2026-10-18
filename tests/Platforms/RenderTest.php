<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Tests\Platforms;

use DrevOps\EnvironmentDetector\Environment;
use DrevOps\EnvironmentDetector\Platforms\Render;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(Render::class)]
#[CoversClass(Environment::class)]
final class RenderTest extends PlatformTestCase {

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
      fn() => self::envSetMultiple(['RENDER' => '1', 'RENDER_GIT_BRANCH' => 'main']),
      Environment::PRODUCTION,
    ];
    yield [
      fn() => self::envSetMultiple(['RENDER' => '1', 'RENDER_GIT_BRANCH' => 'master']),
      Environment::PRODUCTION,
    ];
    yield [
      fn() => self::envSetMultiple(['RENDER' => '1', 'RENDER_GIT_BRANCH' => 'staging']),
      Environment::STAGE,
    ];
    yield [
      fn() => self::envSetMultiple(['RENDER' => '1', 'RENDER_GIT_BRANCH' => 'develop']),
      Environment::DEVELOPMENT,
    ];
    yield [
      fn() => self::envSetMultiple(['RENDER' => '1', 'RENDER_GIT_BRANCH' => 'feature/foo']),
      Environment::PREVIEW,
    ];
    yield [
      fn() => self::envSet('RENDER', '1'),
      Environment::PREVIEW,
    ];
  }

}
