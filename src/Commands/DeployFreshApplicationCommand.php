<?php


namespace Tobexkee\Deployer\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tobexkee\Deployer\Actions\DeployFreshApplication;

class DeployFreshApplicationCommand extends Command
{
    protected static $defaultName = 'deploy:fresh';

    private DeployFreshApplication $deployer;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->deployer = new DeployFreshApplication;
    }

    protected function configure(): void
    {
        $this
            ->setDescription("Deploy a fresh application to cpanel")
            ->setHelp("The command deploys a fresh command to cpanel");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Running Fresh Application Command");

        if($this->deployer->run()->isSuccessful()) {

            $output->writeln("Running after deploy commands");

            if($this->deployer->runAfterDeploy()->isSuccessful()) {

                $output->writeln("Deployment complete");
            }

            return Command::SUCCESS;
        }

        $output->writeln("Deployment failed");

        return Command::FAILURE;
    }

}