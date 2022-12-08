<?php

use App\Models\Role;
use App\Models\Boarder;
use App\Models\Building;
use App\Models\RolePermission;
use App\Models\PermissionContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
            1. update all 'The Grove' boarders to 'Bradbys'
            2. update building 'Bradbys' to 'Bradbys/The Grove' and member_year_group to 'Y4,Y5,Y6,Y7,Y8,Y9,10,11,12,13' <- '11,12,13'
            3. remove building 'The Grove'
            4. update permission content 'Bradbys' to 'Bradbys/The Grove'
            5. remove role_permissions 'The Grove' from all roles: SuperAdmin, BoardingStaff, TheGrove 
            6. remove permission content 'The Grove'
            7. remove role 'The Grove'
            8. update role 'Bradbys' to 'Bradbys/The Grove'
        */
        
        DB::beginTransaction();
        try {
            
            $building_to_remove = 'The Grove';
            $building_to_update = 'Bradbys';
            $building_to_be_new = 'Bradbys/The Grove';

            // 1. update all 'The Grove' boarders to 'Bradbys'
            $boarders           = Boarder::join(   'buildings', 'buildings.id', '=', 'boarders.building_id' )
                                         ->where(  'buildings.building_name', $building_to_remove)->get();
            $building           = Building::where( 'building_name', $building_to_update)->first();
            foreach( $boarders as $boarder )
            {
                $boarder->building_id = $building->id;
                $boarder->save();
            }

            // 2. update building 'Bradbys' to 'Bradbys/The Grove' and member_year_group to 'Y4,Y5,Y6,Y7,Y8,Y9,10,11,12,13' - '11,12,13'
            $building->building_name     = $building_to_be_new;
            $building->description       = $building_to_be_new;
            $building->member_year_group = 'Y4,Y5,Y6,Y7,Y8,Y9,10,11,12,13';
            $building->save();
            
            // 3. remove building 'The Grove'
            Building::where( 'building_name', $building_to_remove )->delete();

            // 4. update PermissionContent 'Bradbys' to 'Bradbys/The Grove'
            $permission_content = PermissionContent::where('permission_content_name', $building_to_update)->first();
            $permission_content->permission_content_name = $building_to_be_new;
            $permission_content->save();
            
            // 5. remove role_permissions 'The Grove' from all roles: 
            RolePermission::join( 'permission_contents', 'permission_contents.id', '=', 'role_permissions.permission_content_id' )
                          ->join( 'roles', 'roles.id', '=', 'role_permissions.role_id' )
                          ->where( 'permission_contents.permission_content_name', $building_to_remove )
                          ->delete();
            
            // 6. remove permission content 'The Grove'
            PermissionContent::where( 'permission_content_name', $building_to_remove)->delete();
            
            // 7. remove role 'The Grove'
            Role::where( 'role_name', $building_to_remove )->delete();


            // 8. update role 'Bradbys' to 'Bradbys/The Grove'
            $role               = Role::where( 'role_name', $building_to_update )->first();
            $role->role_name    = $building_to_be_new;
            $role->save();

            DB::commit();
        } 
        catch( Exception $e ) 
        {
            DB::rollBack();
            dd( $e );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
            1. add roles 'The Grove'
            2. add permission_contents 'The Grove'
            3. add role_permissions 'The Grove' to roles: SuperAdmin, BoardingStaff, TheGrove
            4. update permission content 'Bradbys/The Grove' to 'Bradbys'            
            5. update role 'Bradbys/The Grove' to 'Bradbys'
            6. add building 'The Grove' and member_year_group to '11,12,13'
            7. update building 'Bradbys/The Grove' to 'Bradbys' and member_year_group to 'Y4,Y5,Y6,Y7,Y8,Y9,10,11,12,13'
            8. update all 'Bradbys/The Grove' boarders to 'The Grove' with conditions year_group in '11,12,13' and gender='M'
        */

        DB::beginTransaction();
        try 
        {
            $building_to_insert = 'The Grove';
            $building_to_update = 'Bradbys/The Grove';
            $building_to_be_new = 'Bradbys';
            
            // 1. add roles 'The Grove'
            $attributes['role_name']  = $building_to_insert;   
            $attributes['created_by'] = 1;       
            $attributes['updated_by'] = 1;
            Role::create($attributes);

            // 2. add permission_contents 'The Grove'
            if( env('DB_CONNECTION')=='sqlsrv' ){
                DB::unprepared('SET IDENTITY_INSERT permission_contents ON');
            }
            $attributes                            = [];
            $attributes['id']                      = 3;
            $attributes['permission_content_name'] = $building_to_insert;    
            $permission_content = PermissionContent::create($attributes);
            if( env('DB_CONNECTION')=='sqlsrv' ){
                DB::unprepared('SET IDENTITY_INSERT permission_contents OFF');
            }

            // 3. add role_permissions 'The Grove' to roles: SuperAdmin, BoardingStaff, The Grove
            $roles = Role::whereIn('role_name',['SuperAdmin','BoardingStaff',$building_to_insert])->get();
            foreach( $roles as $role )
            {
                $attributes = [
                    'role_id'               => $role->id,
                    'permission_content_id' => $permission_content->id,
                    'permission'            => 'update'
                ];
                RolePermission::create($attributes);
            }
            
            // 4. update permission content 'Bradbys/The Grove' to 'Bradbys'   
            $permission_content = PermissionContent::where( 'permission_content_name', $building_to_update )->first(); 
            $permission_content->permission_content_name = $building_to_be_new;
            $permission_content->save();
            
            // 5. update role 'Bradbys/The Grove' to 'Bradbys'
            $role = Role::where( 'role_name', $building_to_update )->first(); 
            $role->role_name = $building_to_be_new;
            $role->save();

            // 6. add building 'The Grove' and member_year_group to '11,12,13'
            if( env('DB_CONNECTION')=='sqlsrv' ){
                DB::unprepared('SET IDENTITY_INSERT buildings ON');
            }
            $attributes                      = []; 
            $attributes['id']                = 3;       
            $attributes['building_name']     = $building_to_insert;       
            $attributes['description']       = $building_to_insert;   
            $attributes['member_gender']     = 'M';       
            $attributes['member_year_group'] = '11,12,13';
            Building::create($attributes);
            if( env('DB_CONNECTION')=='sqlsrv' ){
                DB::unprepared('SET IDENTITY_INSERT buildings OFF');
            }

            // 7. update building 'Bradbys/The Grove' to 'Bradbys' and member_year_group to 'Y4,Y5,Y6,Y7,Y8,Y9,10'
            $building = Building::where( 'building_name', $building_to_update )->first(); 
            $building->building_name         = $building_to_be_new;
            $building->description           = $building_to_be_new;
            $building->member_year_group     = 'Y4,Y5,Y6,Y7,Y8,Y9,10';
            $building->save();

            // 8. update all 'Bradbys/The Grove' boarders to 'The Grove' with conditions year_group in '11,12,13' and gender='M'
            $boarders           = Boarder::join(   'buildings', 'buildings.id', '=', 'boarders.building_id' )
                                         ->where(  'buildings.building_name', $building_to_be_new)
                                         ->whereIn('boarders.year_group', ['11','12','13'])
                                         ->where(  'boarders.gender', 'M')
                                         ->get();
            $building           = Building::where( 'building_name', $building_to_insert)->first();
            foreach( $boarders as $boarder )
            {
                $boarder->building_id = $building->id;
                $boarder->save();
            }
            DB::commit();
        } 
        catch ( Exception $e ) 
        {
            DB::rollBack();

            if( env('DB_CONNECTION')=='sqlsrv' ){
                DB::unprepared('SET IDENTITY_INSERT permission_contents OFF');
                DB::unprepared('SET IDENTITY_INSERT buildings OFF');
            }
            dd( $e );
        }
    }
};
