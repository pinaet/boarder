<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaperformController extends Controller
{
    public function paperform( $form_name, $boarder )
    {
        $data = $this->leave_quest( $form_name, $boarder );

        return $data;
    }

    public function leave_quest( $form_name, $boarder )
    {
        $user = auth()->user();

        //cc email to notify relevant people
        $admin_email = '';
        $year_group  = strtolower($boarder->year_group);
        if( $year_group=='y6' || $year_group=='y7' || $year_group=='y8' || $year_group=='y9' || 
            $year_group=='10' || $year_group=='11' || $year_group=='12' || $year_group=='13'  )
        {
            $admin_email = env( 'US_ATTENDANCE', 'harrowipad002@harrowschool.ac.th' );
        }
        else{
            $admin_email = env( 'LS_ATTENDANCE', 'harrowipad001@harrowschool.ac.th' );
        }
        
        $temp = $this->getHoHEmail( $boarder->year_group, $boarder->house );
        if( $temp ){
            $admin_email .= ','.$temp;
        }
        $config_path = "paperform.$form_name.";
        $params      = array(
            config( $config_path.'pupil_id'     ) => $boarder->pupil_id,  
            config( $config_path.'admission_no' ) => $boarder->admission_no,  
            config( $config_path.'student_name' ) => $boarder->forename . ' ('.$boarder->prefered_forename. ') '. $boarder->surname, 
            config( $config_path.'year_group'   ) => $boarder->year_group,//'reception',//$boarder->YearGroup,
            config( $config_path.'form'         ) => $boarder->form,
            config( $config_path.'boarder'      ) => 'Yes',
            config( $config_path.'boarder_house') => $boarder->building_name,
            config( $config_path.'nickname'     ) => $boarder->prefered_forename,
            config( $config_path.'parent_name'  ) => $user->name,  
            config( $config_path.'parent_email' ) => $user->email,
            config( $config_path.'parent_number') => '', 
            config( $config_path.'admin_email'  ) => $admin_email,
        );
        
        return config($config_path.'paperform_url').'?'.http_build_query($params);
    }

    public function getHoHEmail( $year_group, $house )
    {        
        $year_group  = strtolower( $year_group );
        $house       = strtolower( $house );
        $admin_email = '';
        if( $year_group=='y6' || $year_group=='y7' || $year_group=='y8' )
        {
            if( $house=='byron'     ) $admin_email = env( 'US_PH_BY' , 'harrowipad011@harrowschool.ac.th' ) ;
            if( $house=='churchill' ) $admin_email = env( 'US_PH_CH' , 'harrowipad012@harrowschool.ac.th' ) ;
            if( $house=='keller'    ) $admin_email = env( 'US_PH_KE' , 'harrowipad013@harrowschool.ac.th' ) ;
            if( $house=='nehru'     ) $admin_email = env( 'US_PH_NE' , 'harrowipad014@harrowschool.ac.th' ) ;
            if( $house=='sonakul'   ) $admin_email = env( 'US_PH_SO' , 'harrowipad015@harrowschool.ac.th' ) ;
            if( $house=='suriyothai') $admin_email = env( 'US_PH_SU' , 'harrowipad016@harrowschool.ac.th' ) ;
        }
        else if( $year_group=='y9' || $year_group=='10' || $year_group=='11' || $year_group=='12' || $year_group=='13' )
        {
            if( $house=='byron'     ) $admin_email = env( 'US_HOH_BY', 'harrowipad021@harrowschool.ac.th' ) ;
            if( $house=='churchill' ) $admin_email = env( 'US_HOH_CH', 'harrowipad022@harrowschool.ac.th' ) ;
            if( $house=='keller'    ) $admin_email = env( 'US_HOH_KE', 'harrowipad023@harrowschool.ac.th' ) ;
            if( $house=='nehru'     ) $admin_email = env( 'US_HOH_NE', 'harrowipad024@harrowschool.ac.th' ) ;
            if( $house=='sonakul'   ) $admin_email = env( 'US_HOH_SO', 'harrowipad025@harrowschool.ac.th' ) ;
            if( $house=='suriyothai') $admin_email = env( 'US_HOH_SU', 'harrowipad026@harrowschool.ac.th' ) ;
        }

        return $admin_email;
    }
}
