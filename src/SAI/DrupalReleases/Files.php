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
     * Parent release
     * @var SAI\DrupalReleases\Release
     */
    protected $release;

    /**
     *
     */
    public function __construct(\SimpleXMLElement $files, SAI\DrupalReleases\Release &$release)
    {
        $this->release = $release;

        $array = array();
        foreach ($files as $file) {
            $array[(string) $file->archive_type] = new File($file, $release);
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     * Returns parent release
     *
     * @return SAI\DrupalReleases\Release
     */
    public function release()
    {
      return $this->release;
    }

    /**
     * Returns parent project
     *
     * @return SAI\DrupalReleases\Project
     */
    public function project()
    {
      return $this->release->project();
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
