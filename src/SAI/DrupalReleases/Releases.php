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

    protected $recommended = null;

    protected $development = null;

    /**
     * Parent project
     * @var SAI\DrupalReleases\Project
     */
    protected $project;

    /**
     *
     */
    public function __construct(\SimpleXMLElement $releases, Project &$project)
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

    /**
     *
     */
    public function recommended()
    {
        if (!isset($this->recommended)) {
            $major = $this->project['recommended_major'];
            $max   = null;

            foreach ($this as &$release) {
                if ($release['version_major'] != $major) {
                    continue;
                }

                if (!isset($max) || version_compare($release['version'], $max, '>')) {
                    $max = $release['version'];
                    $this->recommended = &$release;
                }
            }

            if (!isset($this->recommended)) {
                $this->recommended = &$this->development();
            }
        }

        return $this->recommended;
    }

    /**
     *
     */
    public function development()
    {
        if (!isset($this->development)) {
            $major = $this->project['recommended_major'];

            foreach ($this as &$release) {
                if (($release['version_major'] == $major)
                    && $release->isDevelopment()) {
                    $this->development = &$release;
                    break;
                }
            }
        }

        return $this->development;
    }

    /**
     * Alias for {@link development()}.
     */
    public function dev()
    {
        return $this->development();
    }

}
