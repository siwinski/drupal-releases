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

use  SAI\DrupalReleases\Projects\ProjectOverview;

/**
 * <projects>
 *     <project>...</project>
 *     <project>...</project>
 *     <project>...</project>
 *     ...
 * </projects>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Projects extends ClientAbstract
{
    const URL_PATH = '/release-history/project-list/all';

    protected $xpath = '/projects/project';

    /**
     *
     */
    public function __construct($apiVersion = null, $unpublished = false, $sandbox = false)
    {
        $this->response = self::getClient()->get(self::URL_PATH)->send();
        $filters        = array();

        // Published
        if (null !== $unpublished) {
            $filters[] = $unpublished ?
                'string(project_status)="unpublished"' :
                'string(project_status)="published"';
        }

        // Sandbox
        if (null !== $sandbox) {
            $filters[] = $sandbox ?
                'contains(link,"/sandbox/")' :
                'not(contains(link,"/sandbox/"))';
        }

        // API versions
        if (!empty($apiVersion)) {
            $apiVersionFilters = array();

            foreach ((array) $apiVersion as $v) {
                $v = intval($v);
                if (!empty($v)) {
                    $apiVersionFilters[] = sprintf('string(*/api_version)="%d.x"', $v);
                }
            }

            if (!empty($apiVersionFilters)) {
                $filters[] = '(' . implode(' or ', $apiVersionFilters) . ')';
            }
            unset($apiVersionFilters);
        }

        if (!empty($filters)) {
            $this->xpath .= '[' . implode(' and ', $filters) . ']';
        }
        unset($filters);

        $xpathArray = $this->response->xml()->xpath($this->xpath);
        $array      = array();
        foreach ($xpathArray as $projectOverview) {
            $key = (string) $projectOverview->short_name;
            $array[$key] = new ProjectOverview($projectOverview, $this);
        }
        unset($xpathArray);

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function xpath()
    {
        return $this->xpath;
    }

}
