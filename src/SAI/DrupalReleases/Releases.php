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
 * <releases>
 *     <release>...</release>
 *     <release>...</release>
 *     <release>...</release>
 *     ...
 * </releases>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Releases extends \ArrayObject
{

    /**
     * Parent project
     * @var SAI\DrupalReleases\Project
     */
    protected $project;

    /**
     *
     */
    public function __construct(\SimpleXMLElement $releases, SAI\DrupalReleases\Project &$project)
    {
        $this->project = $project;

        $array = array();

        foreach ($releases as $release) {
            $key = (string) $release->version;
            $array[$key] = new Release($release, $project);
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     * Returns parent project
     *
     * @return SAI\DrupalReleases\Project
     */
    public function project()
    {
        return $this->project;
    }

}
