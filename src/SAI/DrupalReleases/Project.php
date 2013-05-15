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
class Project extends ClientAbstract
{

    const URL_PATH = '/release-history/{project}/{api_version}.x';

    /**
     *
     */
    public function __construct($project, $api_version)
    {
        $this->response = self::getClient()->get(array(self::URL_PATH, array(
            'project'     => $project,
            'api_version' => intval($api_version),
        )))->send();

        $array = (array) $this->response->xml();

        if (isset($array['supported_majors'])) {
            $array['supported_majors'] = explode(',', $array['supported_majors']);
        } else {
            $array['supported_majors'] = array();
        }

        if (isset($array['terms'])) {
            $array['terms'] = new Terms($array['terms']);
        } else {
            $array['terms'] = new Terms(new \SimpleXMLElement('<terms></terms>'));
        }

        if (isset($array['releases'])) {
            $array['releases'] = new Releases($array['releases'], $this);
        } else {
            $array['releases'] = new Releases(new \SimpleXMLElement('<releases></releases>'), $this);
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }

    /**
     *
     */
    public function isPublished()
    {
        return 'published' == $this['project_status'];
    }

    /**
     *
     */
    public function recommended()
    {
        return $this['releases']->recommended();
    }

    /**
     *
     */
    public function development()
    {
        return $this['releases']->development();
    }

    /**
     * Alias for {@link development()}.
     */
    public function dev()
    {
        return $this->development();
    }

    /**
     *
     */
    public function download()
    {
        $recommended = $this->recommended();

        if (isset($recommended)) {
            $recommended->download();
        }

        // TODO: Throw error if no recommended
    }

}
