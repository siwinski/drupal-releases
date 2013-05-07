<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases;

/**
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Releases extends \ArrayObject
{

    /**
     *
     */
    public function __construct(\SimpleXMLElement $releases)
    {
        $array = array();

        foreach ($releases as $release) {
            $array[] = new Release($release);
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

}