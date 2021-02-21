<?php


namespace Tobexkee\Deployer\Actions;


use Spatie\Ssh\Ssh;
use Symfony\Component\Process\Process;
use Tobexkee\Deployer\YamlParser;

abstract class BaseDeployer
{

    protected YamlParser $yaml;

    protected Ssh $ssh;

    public function __construct()
    {
        $this->yaml = YamlParser::getInstance();

        $this->ssh =  Ssh::create(
            $this->yaml['setup']['host_user'],
            $this->yaml['setup']['host_ip'],
            $this->yaml['setup']['host_port']
        )->usePrivateKey($this->yaml['setup']['ssh_private_key_path'])
         ->onOutput(function ($type, $line) {
                echo $line;
         });
    }

    abstract function rules(): array;

    public function run(): Process
    {
        return $this->ssh->execute($this->rules());
    }

    public function afterDeployRules(): array
    {
        return $this->yaml['after_deploy']['action'];
    }

    public function runAfterDeploy(): Process
    {
        return $this->ssh->execute($this->afterDeployRules());
    }

}