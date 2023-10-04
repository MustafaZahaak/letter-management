<?php

namespace App\Console\Commands;

use App\Http\Controllers\GroupController;
use App\Http\Requests\UpdateEmployeeGroupRequest;
use Illuminate\Console\Command;

class UpdateEmployeesGroup extends Command
{

    protected $signature = 'group:updateEmployeesGroup';

    protected $description = 'Update Employees Group for all Organizations';

    protected $organizationContainGroup = ["Etisalat Security"];

    protected $groups = ["All Employees", "International Employees", "National Employees"];

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        foreach ($this->organizationContainGroup as $org):
            foreach ($this->groups as $group) {
                $request = new UpdateEmployeeGroupRequest(
                    [
                        "organization_name" => $org,
                        "group_name" => $group
                    ]
                );
                $groupController = new GroupController();

                switch ($group):
                    case "All Employees":
                        $groupController->updateAllEmployeeGroup($request);
                        break;
                    case "International Employees":
                        $groupController->updateInternationalEmployeeGroup($request);
                        break;
                    case "National Employees":
                        $groupController->updateNationalEmployeeGroup($request);
                        break;
                endswitch;
            }
        endforeach;
    }
}
