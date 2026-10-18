<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Platforms;

use DrevOps\EnvironmentDetector\Environment;

/**
 * Vercel hosting platform.
 *
 * @package DrevOps\EnvironmentDetector\Platforms
 */
class Vercel extends AbstractPlatform {

  /**
   * {@inheritdoc}
   */
  public const ID = 'vercel';

  /**
   * {@inheritdoc}
   */
  public function active(): bool {
    return getenv('VERCEL') !== FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function type(): ?string {
    // VERCEL_ENV is set to 'production', 'preview', or 'development'.
    // Preview is the default for non-production, non-development deployments.
    return match (getenv('VERCEL_ENV')) {
      'production' => Environment::PRODUCTION,
      'development' => Environment::DEVELOPMENT,
      default => Environment::PREVIEW,
    };
  }

}
