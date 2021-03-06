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
 * <release>
 *     <name>drupal 7.22</name>
 *     <version>7.22</version>
 *     <tag>7.22</tag>
 *     <version_major>7</version_major>
 *     <version_patch>22</version_patch>
 *     <status>published</status>
 *     <release_link>http://drupal.org/drupal-7.22-release-notes</release_link>
 *     <download_link>http://ftp.drupal.org/files/projects/drupal-7.22.tar.gz</download_link>
 *     <date>1365027013</date>
 *     <mdhash>068d7a77958fce6bb002659aa7ccaeb7</mdhash>
 *     <filesize>3183014</filesize>
 *     <files>...</files>
 *     <terms>...</terms>
 * </release>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Release extends \ArrayObject
{

    /**
     * Parent project
     * @var SAI\DrupalReleases\Project
     */
    protected $project;

    /**
     *
     */
    public function __construct(\SimpleXMLElement $release, Project &$project)
    {
        $this->project = $project;

        $array = (array) $release;

        if (isset($array['files'])) {
            $array['files'] = new Files($array['files'], $this);
        } else {
            $array['files'] = new Files(new \SimpleXMLElement('<files></files>'), $this);
        }

        if (isset($array['terms'])) {
            $array['terms'] = new Terms($array['terms']);
        } else {
            $array['terms'] = new Terms(new \SimpleXMLElement('<terms></terms>'));
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
    public function isPublished()
    {
        return 'published' == $this['status'];
    }

    /**
     *
     */
    public function isRecommendedMajor()
    {
        return $this['version_major'] == $this->project['recommended_major'];
    }

    /**
     *
     */
    public function isSupportedMajor()
    {
        return in_array($this['version_major'], $this->project['supported_majors']);
    }

    /**
     *
     */
    public function isDefaultMajor()
    {
        return $this['version_major'] == $this->project['default_major']);
    }

    /**
     *
     */
    public function isDevelopment()
    {
        return isset($this['version_extra']) && ('dev' == $this['version_extra']);
    }

    /**
     * Alias for {@link isDevelopment()}.
     */
    public function isDev()
    {
        return $this->isDevelopment();
    }

    /**
     * @uses ClientAbstract::getClient()
     */
    public function download()
    {
        $fileUrl  = $this['download_link'];
        $fileName = preg_replace('#.*/#', '', $fileUrl);

        ClientAbstract::getClient()->get($fileUrl, null, $fileName)->send();

        // TODO: Validate downloaded file
    }

}
