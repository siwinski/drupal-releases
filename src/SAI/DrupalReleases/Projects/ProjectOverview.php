<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases\Projects;

/**
 * <project>
 *     <title>Drupal core</title>
 *     <short_name>drupal</short_name>
 *     <link>http://drupal.org/project/drupal</link>
 *     <dc:creator>Drupal</dc:creator>
 *     <terms>...</terms>
 *     <project_status>published</project_status>
 *     <api_versions>
 *         <api_version>9.x</api_version>
 *         <api_version>8.x</api_version>
 *         <api_version>7.x</api_version>
 *         <api_version>6.x</api_version>
 *         <api_version>5.x</api_version>
 *         <api_version>4.7.x</api_version>
 *         <api_version>4.6.x</api_version>
 *         <api_version>4.5.x</api_version>
 *         <api_version>4.4.x</api_version>
 *         <api_version>4.3.x</api_version>
 *         <api_version>4.2.x</api_version>
 *         <api_version>4.1.x</api_version>
 *         <api_version>4.0.x</api_version>
 *     </api_versions>
 * </project>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class ProjectOverview extends \ArrayObject
{

    /**
     * Parent projects
     * @var SAI\DrupalReleases\Projects
     */
    protected $projects;

    /**
     *
     */
    public function __construct(\SimpleXMLElement $project, SAI\DrupalReleases\Projects &$projects)
    {
        $this->projects = $projects;

        $array = (array) $project;

        if (isset($array['terms'])) {
          $array['terms'] = new Terms($array['terms']);
        } else {
          $array['terms'] = new Terms(new \SimpleXMLElement('<terms></terms>'));
        }

        $api_versions = array();
        if (isset($array['api_versions'])) {
            foreach ($array['api_versions'] as $api_version) {
                $api_versions[] = (string) $api_version->api_version;
            }
        }
        $array['api_versions'] = $api_versions;

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     * Returns parent projects
     *
     * @return SAI\DrupalReleases\Projects
     */
    public function projects()
    {
        return $this->projects();
    }

    /**
     *
     */
    public function isPublished()
    {
        return 'published' == $this['project_status'];
    }

}
