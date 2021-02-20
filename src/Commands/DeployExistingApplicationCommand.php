<?php


namespace Tobexkee\Deployer\Commands;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Tobexkee\Deployer\Actions\DeployToExistingApplication;

class DeployExistingApplicationCommand extends Command
{
    protected static $defaultName = 'deploy';
    /**
     * @var DeployToExistingApplication
     *
     */
    private DeployToExistingApplication $deployer;

    public function __construct(string $name = null)
    {
        parent::__construct($name);
        $this->deployer = new DeployToExistingApplication;
    }

    protected function configure()
    {
        $this
            ->setDescription("Deploy a fresh application to cpanel")
            ->setHelp("The command deploys a fresh command to cpanel");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Running Deploy Commands");

        if($this->deployer->run()) {
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