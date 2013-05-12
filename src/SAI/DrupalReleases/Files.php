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
 * <files>
 *     <file>...</file>
 *     <file>...</file>
 *     <file>...</file>
 *     ...
 * </files>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Files extends \ArrayObject
{

    /**
     *
     */
    public function __construct(\SimpleXMLElement $files)
    {
        $array = array();

        foreach ($files as $file) {
            $key = (string) $file->archive_type;
            $array[$key] = new File($file);
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function download()
    {
        foreach ($this as $file) {
            $file->download();
        }
    }

}
