<?php


namespace Tobexkee\Deployer\Actions;


use Spatie\Ssh\Ssh;
use Tobexkee\Deployer\YamlParser;

abstract class BaseDeployer
{
    /**
     * @var YamlParser
     */
    protected YamlParser $yaml;
    /**
     * @var Ssh
     */
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

    public function run()
    {
        return  $this->ssh->execute($this->rules());
    }

    public function afterDeployRules()
    {
        return $this->yaml['after_deploy']['action'];
    }

    public function runAfterDeploy()
    {
        return $this->ssh->execute($this->afterDeployRules());
    }

    abstract function rules(): array;
}