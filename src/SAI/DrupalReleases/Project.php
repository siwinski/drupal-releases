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
        $this->request = self::getClient()->get(array(self::URL_PATH, array(
            'project'     => $project,
            'api_version' => intval($api_version),
        )));
        $this->response = $this->request->send();

        parent::__construct((array) $this->response->xml(), \ArrayObject::STD_PROP_LIST);
    }

}
