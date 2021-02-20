<?php


namespace Tobexkee\Deployer\Actions;


class DeployFreshApplication extends BaseDeployer
{

    public function rules(): array
    {
        return $this->yaml['fresh_installation']['action'];
    }
}