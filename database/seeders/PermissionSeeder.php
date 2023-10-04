<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{

    protected $permissions = array(

       

        //Dashboards
        array('name' => '/dashboards/analytic', 'guard_name' => 'api', "module_name" => "dashboards", "description" => ' {"english_name": "Analytics Dashboard","dari_name": "ایجاد",
            "pashto_name": "جوړول","english_description": "This allows User to see analytics dashboard of system","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را ایجاد نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي یو حساب جوړ کړي"

        }'),

        //users
        array('name' => 'users', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "users","dari_name":"کارمندان","pashto_name":"کارونکي",
            "english_description": "This allows User to show details of  a field in a created form","dari_description": "این بخش برای کارمند اجازه میدهد تا تمام صلاحیت های کارمند را داشته باشد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی  تر څود کارکونکی ټول صلاحیتونه ولری "

        }'), array('name' => '/users/create', 'guard_name' => 'api', "module_name" => "users", "description" => ' {"english_name": "Create","dari_name": "ایجاد",
            "pashto_name": "جوړول","english_description": "This allows User to create a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را ایجاد نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي یو حساب جوړ کړي"

        }'), array('name' => '/users/update', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "Update","dari_name": "اصلاح",
            "pashto_name": "نوی کول","english_description": "This allows User to update a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را اصلاح سازد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو حساب نوی کړی"

        }'), array('name' => '/users/delete', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "delete","dari_name": "حذف",
            "pashto_name": "ړنګول","english_description": "This allows User to delete a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کابر را حذف نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو حساب ړنګ کړی"

        }'), array('name' => '/users/show', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "show","dari_name": "نشان دادن",
            "pashto_name": "ښودل","english_description": "This allows User to show details of a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا معلومات جزئیات یک حساب کارمند را نشان دهد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی د یو کارکونکي د حساب معلومات وګوری "

        }'),
        array('name' => '/users/change-password', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "Change Password","dari_name": "تغیر پاسورد",
            "pashto_name": "د پاسور تبدیل","english_description": "This allows User to change password",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا معلومات جزئیات یک حساب کارمند را نشان دهد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی د یو کارکونکي د حساب معلومات وګوری "

        }'),

        //roles
        array('name' => 'roles', 'guard_name' => 'api', "module_name" => "roles", "description" => '{"english_name": "roles","dari_name": "نقش ها  ",
            "pashto_name": "رولونه","english_description": "This allows User to create a user role","dari_description": "این بخش برای کارمند اجازه میدهد تا صلاحیت نقش های کارمند را داشته باشد ",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي د رولونو صلاحیت ولری  "

        }'), array('name' => '/roles/create', 'guard_name' => 'api', "module_name" => "roles", "description" => '{
            "english_name": "Create","dari_name": "ایجاد","pashto_name": "جوړول","english_description": "This allows User to create a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا یک  نقش را ایجاد نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي یو رول جوړ کړي"

        }'), array('name' => '/roles/update', 'guard_name' => 'api', "module_name" => "roles", "description" => '{
            "english_name": "Update","dari_name": "اصلاح","pashto_name": "نوی کول",
            "english_description": "This allows User to update a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا یک نقش را اصلاح سازد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو رول نوی کړی"

        }'), array('name' => '/roles/delete', 'guard_name' => 'api', "module_name" => "roles", "description" => '{
            "english_name": "delete","dari_name": "حذف",
            "pashto_name": "ړنګول","english_description": "This allows User to delete a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا یک نقش را حذف نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو رول ړنګ کړی"

        }'), array('name' => '/roles/show', 'guard_name' => 'api', "module_name" => "roles", "description" => '{
            "english_name": "show","dari_name": "نشان دادن",
            "pashto_name": "ښودل","english_description": "This allows User to show details of a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا معلومات جزئیات یک نقش را نشان دهد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی د یو کارکونکي د یو رول معلومات وګوری "

        }'),

        // User Requirements
        array('name' => 'draft', 'guard_name' => 'api', "module_name" => "all", "description" => '{"english_name": "users","dari_name":"کارمندان","pashto_name":"کارونکي",
            "english_description": "This allows User to show details of  a field in a created form","dari_description": "این بخش برای کارمند اجازه میدهد تا تمام صلاحیت های کارمند را داشته باشد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی  تر څود کارکونکی ټول صلاحیتونه ولری "

        }'), array('name' => 'approve', 'guard_name' => 'api', "module_name" => "all", "description" => ' {"english_name": "Create","dari_name": "ایجاد",
            "pashto_name": "جوړول","english_description": "This allows User to create a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را ایجاد نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي یو حساب جوړ کړي"

        }'), array('name' => 'review', 'guard_name' => 'api', "module_name" => "all", "description" => '{"english_name": "Update","dari_name": "اصلاح",
            "pashto_name": "نوی کول","english_description": "This allows User to update a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را اصلاح سازد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو حساب نوی کړی"

        }'),

        // letters | Applications
        array('name' => 'letters', 'guard_name' => 'api', "module_name" => "letters", "description" => '{"english_name": "users","dari_name":"کارمندان","pashto_name":"کارونکي",
            "english_description": "This allows User to show details of  a field in a created form","dari_description": "این بخش برای کارمند اجازه میدهد تا تمام صلاحیت های کارمند را داشته باشد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی  تر څود کارکونکی ټول صلاحیتونه ولری "

        }'), array('name' => '/letters/create', 'guard_name' => 'api', "module_name" => "letters", "description" => ' {"english_name": "Create","dari_name": "ایجاد",
            "pashto_name": "جوړول","english_description": "This allows User to create a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را ایجاد نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی تر څو د کارکونکي یو حساب جوړ کړي"

        }'), array('name' => '/letters/update', 'guard_name' => 'api', "module_name" => "letters", "description" => '{"english_name": "Update","dari_name": "اصلاح",
            "pashto_name": "نوی کول","english_description": "This allows User to update a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کارمند را اصلاح سازد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو حساب نوی کړی"

        }'), array('name' => '/letters/delete', 'guard_name' => 'api', "module_name" => "letters", "description" => '{"english_name": "delete","dari_name": "حذف",
            "pashto_name": "ړنګول","english_description": "This allows User to delete a user account","dari_description": "این بخش برای کارمند اجازه میدهد تا یک حساب کابر را حذف نماید",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی تر څو د کارکونکي یو حساب ړنګ کړی"

        }'), array('name' => '/letters/show', 'guard_name' => 'api', "module_name" => "letters", "description" => '{"english_name": "show","dari_name": "نشان دادن",
            "pashto_name": "ښودل","english_description": "This allows User to show details of a user account",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا معلومات جزئیات یک حساب کارمند را نشان دهد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی د یو کارکونکي د حساب معلومات وګوری "

        }'),

        array('name' => '/users/change-password', 'guard_name' => 'api', "module_name" => "users", "description" => '{"english_name": "Change Password","dari_name": "تغیر پاسورد",
            "pashto_name": "د پاسور تبدیل","english_description": "This allows User to change password",
            "dari_description": "این بخش برای کارمند اجازه میدهد تا معلومات جزئیات یک حساب کارمند را نشان دهد",
            "pastho_description": "دغه برخه یو کارکونکي ته اجازه ورکوی چی د یو کارکونکي د حساب  معلومات وګوری "

        }'),

    );

    public function run()
    {
        foreach ($this->permissions as $per) :
            $permission = \App\Models\Permission::where('name', $per['name'])->first();
            if (!$permission) :
                DB::table('permissions')->insert($per);
            endif;
        endforeach;
    }
}
