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
 * <terms>
 *     <term>
 *         <name>Projects</name>
 *         <value>Drupal core</value>
 *     </term>
 *     <term>
 *         <name>Development status</name>
 *         <value>Under active development</value>
 *     </term>
 *     <term>
 *         <name>Maintenance status</name>
 *         <value>Actively maintained</value>
 *     </term>
 * </terms>
 *
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class Terms extends \ArrayObject
{
    /**
     * @todo Document
     */
    public function __construct(\SimpleXMLElement $terms)
    {
        $array = array();

        foreach ($terms as $term) {
            $termName = (string) $term->name;

            if (!isset($array[$termName])) {
                $array[$termName] = array();
            }

            $array[$termName][] = (string) $term->value;
        }

        parent::__construct($array, \ArrayObject::STD_PROP_LIST);
    }
}
