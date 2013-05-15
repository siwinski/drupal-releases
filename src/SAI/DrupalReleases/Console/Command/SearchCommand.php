<?php

/**
 * This file is part of the Drupal Releases package.
 *
 * (c) Shawn Iwinski <shawn.iwinski@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace SAI\DrupalReleases\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SAI\DrupalReleases\Projects;
use SAI\DrupalReleases\Projects\ProjectOverview;

/**
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class SearchCommand extends Command
{

    /**
     *
     */
    protected function configure() {
        $this
            ->setName('search')
            ->setDescription('Search Drupal project overviews')
            ->addOption(
                'api',
                null,
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Drupal API version(s) ("8.x" or "8")'
            )
            ->addOption(
                'published',
                null,
                InputOption::VALUE_REQUIRED,
                'Published projects? value=yes|no|both',
                'yes'
            )
            ->addOption(
                'sandbox',
                null,
                InputOption::VALUE_REQUIRED,
                'Sandbox projects? value=yes|no|both',
                'no'
            )
        ;
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        $api       = $input->getOption('api');
        $published = $this->getOptionPublished($input);
        $sandbox   = $this->getOptionSandbox($input);

        $projects = new Projects($api, $published, $sandbox);

        $output->writeln(sprintf(' <info>%d projects found.</info>', count($projects)));

        foreach ($projects as $project) {
            $this->outputProject($output, $project);
        }
    }

    /**
     *
     * @param InputInterface $input
     * @throws \InvalidArgumentException
     */
    protected function getOptionPublished(InputInterface $input) {
        $published = strtolower(trim($input->getOption('published')));

        switch ($published) {
          case 'yes':
              return false;
          case 'no':
              return true;
          case null:
              return null;
          default:
            throw new \InvalidArgumentException('Published option must be "yes", "no", or "both".');
        }
    }

    /**
     *
     * @param InputInterface $input
     * @throws \InvalidArgumentException
     */
    protected function getOptionSandbox(InputInterface $input) {
        $sandbox = strtolower(trim($input->getOption('sandbox')));

        switch ($sandbox) {
          case 'yes':
              return true;
          case 'no':
              return false;
          case null:
              return null;
          default:
            throw new \InvalidArgumentException('Sandbox option must be "yes", "no", or "both".');
        }
    }

    protected function outputProject(OutputInterface $output, ProjectOverview $project) {
        $apiVersions = implode(', ', $project['api_versions']);

        $output->writeln(<<<PROJECT

 <info>       Title:</info> <comment>{$project['title']}</comment>
 <info>Machine Name:</info> <comment>{$project['short_name']}</comment>
 <info>         URL:</info> {$project['link']}
 <info>      Status:</info> {$project['project_status']}
 <info>API Versions:</info> {$apiVersions}
PROJECT
        );
    }

}
