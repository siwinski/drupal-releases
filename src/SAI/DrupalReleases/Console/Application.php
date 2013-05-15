<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Application extends BaseApplication
{
    /**
     * ASCII art logo
     * @link http://patorjk.com/software/taag/#p=display&f=Standard&t=Drupal%20Releases
     */
    private static $logo = "  ____                         _   ____      _
 |  _ \ _ __ _   _ _ __   __ _| | |  _ \ ___| | ___  __ _ ___  ___  ___
 | | | | '__| | | | '_ \ / _` | | | |_) / _ \ |/ _ \/ _` / __|/ _ \/ __|
 | |_| | |  | |_| | |_) | (_| | | |  _ <  __/ |  __/ (_| \__ \  __/\__ \
 |____/|_|   \__,_| .__/ \__,_|_| |_| \_\___|_|\___|\__,_|___/\___||___/
                  |_|

";

    /**
     *
     */
    public function __construct()
    {
        parent::__construct('Drupal Releases', 'dev');
    }

    /**
     * {@inheritDoc}
     */
    public function getHelp()
    {
      return self::$logo . parent::getHelp();
    }

}
