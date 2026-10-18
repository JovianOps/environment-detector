<?php

declare(strict_types=1);

namespace DrevOps\EnvironmentDetector\Platforms;

use DrevOps\EnvironmentDetector\Environment;

/**
 * Render hosting platform.
 *
 * @package DrevOps\EnvironmentDetector\Platforms
 */
class Render extends AbstractPlatform {

  /**
   * {@inheritdoc}
   */
  public const ID = 'render';

  /**
   * {@inheritdoc}
   */
  public function active(): bool {
    return getenv('RENDER') !== FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function type(): ?string {
    // RENDER_SERVICE_TYPE is 'web' or 'background'; for environment tier
    // use RENDER_GIT_BRANCH compared to common production branch names.
    $branch = (string) getenv('RENDER_GIT_BRANCH');
    if ($branch === 'main' || $branch === 'master') {
      return Environment::PRODUCTION;
    }
    if ($branch === 'staging' || $branch === 'stage') {
      return Environment::STAGE;
    }
    if ($branch === 'develop' || $branch === 'development') {
      return Environment::DEVELOPMENT;
    }
    return Environment::PREVIEW;
  }

}
