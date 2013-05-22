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
    public function __construct(array $machineNames = array(), $apiVersion = null, $unpublished = false, $sandbox = false)
    {
        $this->response = self::getClient()->get(self::URL_PATH)->send();
        $filters        = array();

        // Machine names
        if (!empty($machineNames)) {
            $machineNameFilters = array();

            foreach ($machineNames as $mn) {
                // machine_name (equals)
                if (FALSE == strstr($mn, '*')) {
                    $machineNameFilters[] = sprintf('string(short_name)="%s"', $mn);
                // *machine_name* (contains)
                } elseif (preg_match('/^\*.*\*$/', $mn)) {
                    $machineNameFilters[] = sprintf('contains(short_name,"%s")', str_replace('*', '', $mn));
                // machine_name* (starts with)
                } elseif (preg_match('/\*$/', $mn)) {
                    $machineNameFilters[] = sprintf('starts-with(short_name,"%s")', str_replace('*', '', $mn));
                // *machine_name (ends with)
                // See:
                //     http://stackoverflow.com/questions/5435310/php-xpath-ends-with
                //     http://stackoverflow.com/questions/402211/how-to-use-xpath-function-in-a-xpathexpression-instance-programatically/402357#402357
                } elseif (preg_match('/^\*/', $mn)) {
                    $mn = str_replace('*', '', $mn);
                    $machineNameFilters[] = sprintf('"%s"=substring(short_name, string-length(short_name) - %d)', $mn, strlen($mn) - 1);
                }
            }

            if (!empty($machineNameFilters)) {
                $filters[] = '(' . implode(' or ', $machineNameFilters) . ')';
            }

            unset($machineNameFilters);
        }

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
