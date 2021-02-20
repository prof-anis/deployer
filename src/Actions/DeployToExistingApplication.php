<?php


namespace Tobexkee\Deployer\Actions;


class DeployToExistingApplication extends BaseDeployer
{

    public function rules(): array
    {
        return $this->yaml['regular']['action'];
    }
}