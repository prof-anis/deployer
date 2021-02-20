<?php


namespace Tobexkee\Deployer\Console;

use Symfony\Component\Console\Application;
use Tobexkee\Deployer\Commands\DeployExistingApplicationCommand;
use Tobexkee\Deployer\Commands\DeployFreshApplicationCommand;

class Console extends Application
{
    protected array $commands = [
      DeployFreshApplicationCommand::class,
      DeployExistingApplicationCommand::class
    ];

    public function __construct()
    {
        parent::__construct();
        $this->loadCommands();
        $this->run();
    }

    protected function loadCommands(): void
    {
       foreach ($this->commands as $command) {
           $this->add(new $command);
       }
    }



}