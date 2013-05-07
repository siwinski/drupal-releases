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
class Projects extends ClientAbstract
{
    const URL_PATH = '/release-history/project-list/all';

    protected $xpath = '/projects/project';

    /**
     *
     */
    public function __construct($apiVersion = null, $unpublished = false, $sandbox = false)
    {
        $this->request  = self::getClient()->get(self::URL_PATH);
        $this->response = $this->request->send();
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

        parent::__construct($this->response->xml()->xpath($this->xpath), \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function xpath()
    {
        return $this->xpath;
    }

}
