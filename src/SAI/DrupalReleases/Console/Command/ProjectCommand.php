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
use Symfony\Component\Console\Output\OutputInterface;

use SAI\DrupalReleases\Project;

/**
 * @author Shawn Iwinski <shawn.iwinski@gmail.com>
 */
class ProjectCommand extends Command
{

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('project')
            ->setDescription('Displays project details')
            ->addArgument(
                'machine_name',
                InputArgument::REQUIRED,
                'Project machine name'
            )
            ->addArgument(
                'api',
                InputArgument::REQUIRED,
                'Project API version ("8.x" or "8")'
            )
        ;
    }

    /**
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $project = new Project(
            $input->getArgument('machine_name'),
            $input->getArgument('api')
        );

        $this->labelWriteln($output, 'Title',        $project['title'], true);
        $this->labelWriteln($output, 'Machine Name', $project['short_name'], true);
        $this->labelWriteln($output, 'URL',          $project['link']);
        $this->labelWriteln($output, 'Status',       $project['project_status']);
        $this->labelWriteln($output, 'API Version',  $project['api_version']);

        foreach ($project['terms'] as $term => $values) {
          $this->labelWriteln($output, $term, implode(', ', $values));
        }

        $recommended      = $project['releases']->recommended();
        $recommendedIsDev = $recommended->isDevelopment();

        if (!$recommendedIsDev) {
            $this->labelWriteln($output, 'Recommended release', $recommended['version'], true);
        }

        $development = $project['releases']->development();
        $developmentRelease = sprintf('%s (%s)',
            $development['version'],
            date('Y-M-d', $development['date'])
        );
        $this->labelWriteln($output, 'Development release', $developmentRelease, $recommendedIsDev);
    }

    protected function labelWriteln(OutputInterface $output, $label, $value, $valueIsComment=false)
    {
        $output->writeln(sprintf(' <info>%s</info>: %s',
            sprintf('%20s', $label),
            $valueIsComment ? "<comment>$value</comment>" : $value
        ));
    }

}
