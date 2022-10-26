<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Boarder;
use App\Models\Contact;
use App\Models\Building;
use App\Models\SchoolTerm;
use Illuminate\Support\Arr;
use App\Models\Registration;
use Illuminate\Http\Request;
use App\Models\RegisterColumn;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\BoarderController;

class SyncController extends Controller
{
    public function syncBoarders()
    {
        //boarders
        $sql_boarder = "
            SELECT A.*, PP.Photo
            FROM
                (
                SELECT
                    cast( CurrentPupil.PupilID AS VARCHAR(10) ) PupilID		 
                    ,'Current' StudentStatus
                    ,ec.CandidateNumber 'ExamNumber'
                    ,PupilPersonalDetails.AdmissionNo
                    ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                    ,PupilPersonalDetails.ForeName 'FirstName'
                    ,PupilPersonalDetails.MiddleName
                    ,PupilPersonalDetails.Surname
                    ,YearGroupLookup.Description YearGroup
                    ,CONVERT(VARCHAR,(PupilCurrentSchool.DateOfEntry),103)AS 'EntryDate'
                    ,SUBSTRING(CONVERT(VARCHAR,PupilPersonalDetails.BirthDate,103),1,10) AS 'DOB'
                    ,PupilPersonalDetails.Gender
                    ,NationalityLookup.Description AS 'Nationality'
                    ,PupilLanguageDetailsFirstLanguageLookupDetails.Description AS 'FirstLanguage'
                    ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                    ,HouseLookup.Description House
                    ,FormLookup.Description Form
                FROM CurrentPupil
                INNER JOIN PupilPersonalDetails ON CurrentPupil.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN Nationality ON PupilPersonalDetails.PupilID=Nationality.PupilID
                INNER JOIN PrPupilAdmissionDetails ON PupilPersonalDetails.PupilID=PrPupilAdmissionDetails.PupilID
                LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                LEFT JOIN SchoolLookupDetails FormLookup ON FormLookup.LookupDetailsID = PupilCurrentSchool.Form AND FormLookup.LookupID = '1002'
                LEFT JOIN SchoolLookupDetails HouseLookup ON HouseLookup.LookupDetailsID = PupilCurrentSchool.House AND HouseLookup.LookupID = '1001'
                LEFT JOIN LookupDetails AS NationalityLookup ON NationalityLookup.LookupDetailsID = Nationality.NationalityID AND NationalityLookup.LookupID = '2900'
                LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                left join PupilReligion PR on PR.PupilID=CurrentPupil.PupilID
                LEFT OUTER JOIN PupilLanguageDetails AS PupilLanguageDetails ON CurrentPupil.SchoolID = PupilLanguageDetails.SchoolID AND CurrentPupil.PupilID = PupilLanguageDetails.PupilID
                LEFT OUTER JOIN LookupDetails AS PupilLanguageDetailsFirstLanguageLookupDetails ON PupilLanguageDetailsFirstLanguageLookupDetails.LookupDetailsID = PupilLanguageDetails.FirstLanguage AND PupilLanguageDetailsFirstLanguageLookupDetails.LookupID = '2103'
                left join ExamCandidates ec on ec.PupilID = PupilPersonalDetails.PupilID
                LEFT JOIN PupilPhoto PP ON PP.PupilID=PupilPersonalDetails.PupilID
                union
                select
                    cast( Leaver.PupilID AS VARCHAR(10) ) PupilID
                    ,'Leaver' StudentStatus
                    ,ec.CandidateNumber 'ExamNumber'
                    ,PupilPersonalDetails.AdmissionNo
                    ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                    ,PupilPersonalDetails.ForeName 'FirstName'
                    ,PupilPersonalDetails.MiddleName
                    ,PupilPersonalDetails.Surname
                    ,YearGroupLookup.Description YearGroup
                    ,CONVERT(VARCHAR,(PupilCurrentSchool.DateOfEntry),103)AS 'EntryDate'
                    ,SUBSTRING(CONVERT(VARCHAR,PupilPersonalDetails.BirthDate,103),1,10) AS 'DOB'
                    ,PupilPersonalDetails.Gender
                    ,NationalityLookup.Description AS 'Nationality'
                    ,PupilLanguageDetailsFirstLanguageLookupDetails.Description AS 'FirstLanguage'
                    ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                    ,HouseLookup.Description House
                    ,FormLookup.Description Form
                FROM Leaver
                INNER JOIN PupilPersonalDetails ON Leaver.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN Nationality ON PupilPersonalDetails.PupilID=Nationality.PupilID
                INNER JOIN PrPupilAdmissionDetails ON PupilPersonalDetails.PupilID=PrPupilAdmissionDetails.PupilID
                LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                LEFT JOIN SchoolLookupDetails FormLookup ON FormLookup.LookupDetailsID = PupilCurrentSchool.Form AND FormLookup.LookupID = '1002'
                LEFT JOIN SchoolLookupDetails HouseLookup ON HouseLookup.LookupDetailsID = PupilCurrentSchool.House AND HouseLookup.LookupID = '1001'
                LEFT JOIN LookupDetails AS NationalityLookup ON NationalityLookup.LookupDetailsID = Nationality.NationalityID AND NationalityLookup.LookupID = '2900'
                LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                left join PupilReligion PR on PR.PupilID=Leaver.PupilID
                LEFT OUTER JOIN PupilLanguageDetails AS PupilLanguageDetails ON Leaver.SchoolID = PupilLanguageDetails.SchoolID AND Leaver.PupilID = PupilLanguageDetails.PupilID
                LEFT OUTER JOIN LookupDetails AS PupilLanguageDetailsFirstLanguageLookupDetails ON PupilLanguageDetailsFirstLanguageLookupDetails.LookupDetailsID = PupilLanguageDetails.FirstLanguage AND PupilLanguageDetailsFirstLanguageLookupDetails.LookupID = '2103'
                left join ExamCandidates ec on ec.PupilID = PupilPersonalDetails.PupilID
            ) A
                LEFT JOIN PupilPhoto PP ON PP.PupilID=A.PupilID
            WHERE
                BoarderStatus IN ('Weekly Boarder','Full Boarder')
            ORDER BY
                A.PupilID
        ";
        $boarders = DB::connection('mis')->select( $sql_boarder );
        $buildings = Building::all();
        $building = $buildings[0];
        foreach($boarders as $boarder)
        {
            $photo = '';
            if( env('DB_CONNECTION')=='sqlsrv' ){
                $photo = DB::raw('CONVERT(VARBINARY(MAX), 0x' . bin2hex($boarder->Photo) . ')'); //To get the value out of the database use hex2bin($attachment)
            }
            else{
                $photo = $boarder->Photo;
            }
            //find building_id -year_grup,gender,
            $current_boarder = Boarder::where('pupil_id',$boarder->PupilID);
            if( $current_boarder->count()==0 )
            {
                $building_id = 0;
                foreach( $buildings as $building )
                {
                    $year_groups = collect(explode(',',$building->member_year_group));
                    $genders     = collect(explode(',',$building->member_gender));
                    if( $year_groups->contains($boarder->YearGroup) && $genders->contains($boarder->Gender) )
                    {
                        $building_id = $building->id;
                        break;
                    }
                }
    
                //create
                $attributes = array(
                    'pupil_id'           => $boarder->PupilID,
                    'building_id'        => $building_id,
                    'offsite_permission' => '',
                    'telephone'          => '',
                    'admission_no'       => $boarder->AdmissionNo,
                    'prefered_forename'  => $boarder->PreferredName,
                    'forename'           => $boarder->FirstName,
                    'surname'            => $boarder->Surname,
                    'year_group'         => $boarder->YearGroup,        
                    'house'              => $boarder->House,
                    'form'               => $boarder->Form,
                    'gender'             => $boarder->Gender,
                    'boarder_type'       => $boarder->BoarderStatus,
                    'photo'              => $photo, 
                    'status'             => $boarder->StudentStatus,
                    'updated_by'         => isset(auth()->user()->id) ? auth()->user()->id : 1,
                );
                DB::beginTransaction ();
                try { 
                    Boarder::create($attributes);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack ();
                    dd($attributes,$e);
                }
            }
            else{
                //update
                $attributes = array(
                    'pupil_id'           => $boarder->PupilID,
                    'admission_no'       => $boarder->AdmissionNo,
                    'prefered_forename'  => $boarder->PreferredName,
                    'forename'           => $boarder->FirstName,
                    'surname'            => $boarder->Surname,
                    'year_group'         => $boarder->YearGroup,        
                    'house'              => $boarder->House,
                    'form'               => $boarder->Form,
                    'gender'             => $boarder->Gender,
                    'boarder_type'       => $boarder->BoarderStatus,
                    'photo'              => $photo,
                    'status'             => $boarder->StudentStatus,
                    'updated_by'         => isset(auth()->user()->id) ? auth()->user()->id : 1,
                );
                DB::beginTransaction ();
                try {
                    $current_boarder->update($attributes);
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollBack ();
                    dd($attributes,$e);
                }
            }
        }
    }

    public function syncContacts()
    {
        //boarders' contacts
        $sql_contact = "
            SELECT A.*
            FROM
                (
                SELECT
                    cast( CurrentPupil.PupilID AS VARCHAR(10) ) PupilID		 
                    ,'Current' StudentStatus
                    ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                    ,CM.ContactID
                    ,CM.ContactName
                    ,lRelationshipToPupil.Description RelationshipToPupil
                    ,CEI.EmailID
                    ,CTI.TelephoneNumber
                FROM CurrentPupil
                INNER JOIN PupilPersonalDetails ON CurrentPupil.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                LEFT JOIN PupilPhoto PP ON PP.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN PupilContacts PC ON PC.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN ContactMaster CM ON CM.ContactID=PC.ContactId
                LEFT JOIN ContactEmailInformation CEI ON CEI.ContactID=CM.ContactID AND CEI.EmailType='Main'
                LEFT JOIN ContactTelephoneInformation CTI ON CTI.ContactID=CM.ContactID AND CTI.TelephoneType='Main' 
                LEFT JOIN LookupDetails lRelationshipToPupil ON lRelationshipToPupil.LookupDetailsID=PC.RelationshipToPupil AND lRelationshipToPupil.LookupID='2100'
                union
                select
                    cast( Leaver.PupilID AS VARCHAR(10) ) PupilID
                    ,'Leaver' StudentStatus
                    ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                    ,CM.ContactID
                    ,CM.ContactName
                    ,lRelationshipToPupil.Description RelationshipToPupil
                    ,CEI.EmailID
                    ,CTI.TelephoneNumber
                FROM Leaver
                INNER JOIN PupilPersonalDetails ON Leaver.PupilID=PupilPersonalDetails.PupilID
                INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                LEFT JOIN PupilPhoto PP ON PP.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN PupilContacts PC ON PC.PupilID=PupilPersonalDetails.PupilID
                LEFT JOIN ContactMaster CM ON CM.ContactID=PC.ContactId
                LEFT JOIN ContactEmailInformation CEI ON CEI.ContactID=CM.ContactID AND CEI.EmailType='Main'
                LEFT JOIN ContactTelephoneInformation CTI ON CTI.ContactID=CM.ContactID AND CTI.TelephoneType='Main' 
                LEFT JOIN LookupDetails lRelationshipToPupil ON lRelationshipToPupil.LookupDetailsID=PC.RelationshipToPupil AND lRelationshipToPupil.LookupID='2100'
            ) A
            WHERE
                BoarderStatus IN ('Weekly Boarder','Full Boarder') AND ContactID IS NOT NULL
            ORDER BY
                A.PupilID
        ";
        $contacts = DB::connection('mis')->select( $sql_contact );
        
        foreach($contacts as $contact)
        {
            //find contact
            $current_contact = Contact::where('contact_id',$contact->ContactID);
            $attributes = array(
                'contact_id'   => $contact->ContactID,
                'pupil_id'     => $contact->PupilID,
                'relationship' => $contact->RelationshipToPupil,
                'contact_name' => $contact->ContactName,
                'email'        => $contact->EmailID,
                'contact_no'   => $contact->TelephoneNumber,
            );          
            if( $current_contact->count()==0 )
            {
                //create
                DB::beginTransaction();
                try {
                    Contact::create($attributes);
                    DB::commit ();
                } catch (Exception $e) {
                    DB::rollBack ();
                    dd($attributes,$e);
                }
            }
            else{
                //update
                DB::beginTransaction ();
                try {
                    $current_contact->update($attributes);
                    DB::commit ();
                } catch (Exception $e) {
                    DB::rollBack ();
                    dd($attributes,$e);
                }
            }
        }
    }

    public function syncSchoolTerms()
    {
        //School Terms
        SchoolTerm::truncate();
        $sql = "
            SELECT 
                SchoolYear, 
                Name Term, 
                StartDate,
                EndDate	
            FROM 
                SchoolTerms
        ";
        $school_terms = DB::connection('mis')->select( $sql );
        
        foreach($school_terms as $school_term)
        {
            //find school_term
            $attributes = array(
                'academic_year' => $school_term->SchoolYear,
                'term'          => 'Term '.(int)$school_term->Term,
                'start_date'    => $school_term->StartDate,
                'end_date'      => $school_term->EndDate,
            );  

            //create
            DB::beginTransaction();
            try {
                SchoolTerm::create($attributes);
                DB::commit ();
            } catch (Exception $e) {
                DB::rollBack ();
                dd($attributes,$e);
            }
        }

        // Term Breaks
        $sql = "
            SELECT 
                SchoolYear, 
                Name Term, 
                StartDate,
                EndDate	
            FROM 
                TermBreaks
        ";
        $school_terms = DB::connection('mis')->select( $sql );
        
        foreach($school_terms as $school_term)
        {
            //find school_term
            $attributes = array(
                'academic_year' => $school_term->SchoolYear,
                'term'          => $school_term->Term,
                'start_date'    => $school_term->StartDate,
                'end_date'      => $school_term->EndDate,
            );  

            //create
            DB::beginTransaction();
            try {
                SchoolTerm::create($attributes);
                DB::commit ();
            } catch (Exception $e) {
                DB::rollBack ();
                dd($attributes,$e);
            }
        }
    }

    public function syncSchoolAttendance( $star_date='' )
    {
        $this->syncSchoolSessionAttendance( $star_date );
        $this->syncSchoolClassAttendance(   $star_date );
    }

    public function syncSchoolSessionAttendance( $star_date='' )
    {
        set_time_limit( 3000 );

        $sql = "
            SELECT 
                psa.PupilID
                , case when pca.SchoolYear = 0 or pca.SchoolYear is null  then (select max(schoolYear) from SchoolTerms where StartDate <= psa.AttendanceDate) else pca.SchoolYear end as SchoolYear
                , YLUD.Description as YearGroup
                , format( psa.AttendanceDate, 'yyyy-MM-dd' ) AttendanceDate
                , case when psa.AttendanceSession='0001' then N'AM'
                when psa.AttendanceSession='0002' then N'PM'
                when psa.AttendanceSession='003' then N'Evening'
                when psa.AttendanceSession='004' then N'Night'
                else N'' end as SessionID
                , AT.AbsenceType as AbsenceType
                , AT.DisplaySymbol 'AbsenceTypeSymbol'
                , AT.AbsenceTypeID
            FROM     dbo.PupilSessionAttendance AS psa 
                INNER JOIN dbo.LookupDetails AS YLUD ON psa.YearGroup = YLUD.LookupDetailsID AND YLUD.LookupID = 3004
                LEFT OUTER JOIN (select distinct cast(AttendanceDate as date) as AttendanceDate,SchoolYear FROM dbo.PupilClassAttendance where SchoolYear >1900 ) pca ON psa.AttendanceDate = pca.AttendanceDate
                INNER JOIN ClusterMaster CM ON CM.CurrentAcademicYear=pca.SchoolYear --ADDED
                LEFT JOIN AbsenceTypes AT ON AT.AbsenceTypeID=psa.AbsenceTypeID
                INNER JOIN 
                (
                    SELECT A.*
                    FROM
                        (
                        SELECT
                            cast( CurrentPupil.PupilID AS VARCHAR(10) ) PupilID		 
                            ,'Current' StudentStatus
                            ,PupilPersonalDetails.AdmissionNo
                            ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                            ,PupilPersonalDetails.ForeName 'FirstName'
                            ,PupilPersonalDetails.MiddleName
                            ,PupilPersonalDetails.Surname
                            ,YearGroupLookup.Description YearGroup
                            ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                        FROM CurrentPupil
                        INNER JOIN PupilPersonalDetails ON CurrentPupil.PupilID=PupilPersonalDetails.PupilID
                        INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                        LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                        LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                        union
                        select
                            cast( Leaver.PupilID AS VARCHAR(10) ) PupilID
                            ,'Leaver' StudentStatus
                            ,PupilPersonalDetails.AdmissionNo
                            ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                            ,PupilPersonalDetails.ForeName 'FirstName'
                            ,PupilPersonalDetails.MiddleName
                            ,PupilPersonalDetails.Surname
                            ,YearGroupLookup.Description YearGroup
                            ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                        FROM Leaver
                        INNER JOIN PupilPersonalDetails ON Leaver.PupilID=PupilPersonalDetails.PupilID
                        INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                        LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                        LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                    ) A
                    WHERE
                        BoarderStatus IN ('Weekly Boarder','Full Boarder')
                ) Boarders ON Boarders.PupilID=psa.PupilID
            WHERE 
                format( psa.AttendanceDate, 'yyyy-MM-dd' ) >= '$star_date'
            ORDER BY PupilID, AttendanceDate
        ";
        $session_attendances = DB::connection( 'mis' )->select( $sql );

        /*
            Registration
            --------------
            id
            pupil_id
            attendance_id
            register_column_id**
            date
            created_by
            updated_by
            year_group
            academic_year
            notes

            RegisterColumn
            --------------
            +"PupilID": "2279"
            +"SchoolYear": "2022"
            +"YearGroup": "12"
            +"AttendanceDate": "2022-08-18"
            +"SessionID": "AM"
            +"AbsenceType": "Present(AM)"
            +"AbsenceTypeSymbol": "/"
            +"AbsenceTypeID": "CL1-1"

            RegisterColumn
            --------------
            "id" => 3
            "day_of_week" => 1
            "display_order" => 3
            "column_name" => "Morning"
            "academic_year" => 2021
            "width" => 25
            "created_at" => "2022-10-19 08:03:58"
            "updated_at" => "2022-10-19 08:03:58"
        */

        $cols  = RegisterColumn::all();
        foreach( $session_attendances as $attendance ){
            $c_date = ''; 
            $c_col  = '';

            //get days of the week by seed_date
            $dates = (new BoarderController)->generate_dates( $attendance->AttendanceDate );

            //filter date - array
            $temp  = Arr::where( $dates, function($date) use ($attendance){
                return $date["formatted"]==$attendance->AttendanceDate ? true : false;
            });
            foreach( $temp as $value ){
                $c_date = $value;
            }

            //filter column - collection
            $temp  = $cols->filter( function( $col ) use( $c_date, $attendance ){
                return ((strtolower($col->column_name)=='morning'&&strtolower($attendance->SessionID)=='am') || 
                        (strtolower($col->column_name)=='afternoon'&&strtolower($attendance->SessionID)=='pm')) && 
                       ($col->day_of_week==($c_date['order']+1) ) ? true : false;
            });
            foreach( $temp as $value ){
                $c_col  = $value;
            }
            
            //morning || afternoon
            $register = Registration::updateOrCreate(
                [   //where
                    'pupil_id'           => $attendance->PupilID,   
                    'date'               => $attendance->AttendanceDate,
                    'register_column_id' => $c_col->id,    //**
                ],
                [   //what to update
                    'pupil_id'           => $attendance->PupilID,   
                    'date'               => $attendance->AttendanceDate,
                    'register_column_id' => $c_col->id,    //**
                    'attendance_id'      => 0,
                    'created_by'         => auth()->user()->id,
                    'updated_by'         => auth()->user()->id,
                    'year_group'         => $attendance->YearGroup, 
                    'academic_year'      => $attendance->SchoolYear,  
                    'notes'              => $attendance->AbsenceTypeSymbol,
                ] 
            );
            // if($key==10)
            //     dd($c_date,$c_col,$attendance,$register,$key );
        }
    }

    public function syncSchoolClassAttendance( $star_date='' )
    {
        $sql = "
            SELECT 
                pca.PupilID, pca.SchoolYear, YLUD.Description as YearGroup
                , format( pca.AttendanceDate, 'yyyy-MM-dd' ) AttendanceDate --pca.AttendanceDate
                ,cast(pca.SubjectID as nvarchar) SubjectID
                , dbo.SubjectMaster.Name AS [Subject]
                , pca.PeriodNumber as PeriodID
                ,AT.AbsenceType as AbsenceType
                ,AT.DisplaySymbol 'AbsenceTypeSymbol'
                ,AT.AbsenceTypeID
            FROM     dbo.PupilClassAttendance pca 
                INNER JOIN dbo.SubjectMaster ON pca.SubjectID = dbo.SubjectMaster.SubjectID  
                INNER JOIN dbo.LookupDetails AS YLUD ON pca.YearGroupID = YLUD.LookupDetailsID AND YLUD.LookupID = 3004
                INNER JOIN ClusterMaster CM ON CM.CurrentAcademicYear=pca.SchoolYear --ADDED
                LEFT JOIN AbsenceTypes AT ON AT.AbsenceTypeID=pca.AbsenceTypeID
                INNER JOIN 
                (
                    SELECT A.*
                    FROM
                        (
                        SELECT
                            cast( CurrentPupil.PupilID AS VARCHAR(10) ) PupilID		 
                            ,'Current' StudentStatus
                            ,PupilPersonalDetails.AdmissionNo
                            ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                            ,PupilPersonalDetails.ForeName 'FirstName'
                            ,PupilPersonalDetails.MiddleName
                            ,PupilPersonalDetails.Surname
                            ,YearGroupLookup.Description YearGroup
                            ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                        FROM CurrentPupil
                        INNER JOIN PupilPersonalDetails ON CurrentPupil.PupilID=PupilPersonalDetails.PupilID
                        INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                        LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                        LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                        union
                        select
                            cast( Leaver.PupilID AS VARCHAR(10) ) PupilID
                            ,'Leaver' StudentStatus
                            ,PupilPersonalDetails.AdmissionNo
                            ,PupilPersonalDetails.PreferredForeName 'PreferredName'
                            ,PupilPersonalDetails.ForeName 'FirstName'
                            ,PupilPersonalDetails.MiddleName
                            ,PupilPersonalDetails.Surname
                            ,YearGroupLookup.Description YearGroup
                            ,BoarderStatus.BoarderStatusDescription 'BoarderStatus'
                        FROM Leaver
                        INNER JOIN PupilPersonalDetails ON Leaver.PupilID=PupilPersonalDetails.PupilID
                        INNER JOIN PupilCurrentSchool ON PupilCurrentSchool.PupilID=PupilPersonalDetails.PupilID
                        LEFT JOIN LookupDetails YearGroupLookup ON YearGroupLookup.LookupDetailsID = PupilCurrentSchool.YearGroup AND YearGroupLookup.LookupID = '3004'
                        LEFT JOIN BoarderStatus ON BoarderStatus.BoarderStatusCode = PupilCurrentSchool.BoarderStatus
                    ) A
                WHERE
                    BoarderStatus IN ('Weekly Boarder','Full Boarder')
            ) Boarders ON Boarders.PupilID=pca.PupilID
            WHERE 
                pca.PeriodNumber<=6 AND format( pca.AttendanceDate, 'yyyy-MM-dd' ) >= '$star_date'
            ORDER BY 
                PupilID, AttendanceDate, PeriodID
        ";
        $class_attendances = DB::connection( 'mis' )->select( $sql );

        $cols  = RegisterColumn::all();
        foreach ($class_attendances as $key => $attendance) {
            $c_date = '';
            $c_col  = '';

            //get days of the week by seed_date
            $dates = (new BoarderController())->generate_dates($attendance->AttendanceDate);

            //filter date - array
            $temp  = Arr::where($dates, function ($date) use ($attendance) {
                return $date["formatted"]==$attendance->AttendanceDate ? true : false;
            });
            foreach ($temp as $value) {
                $c_date = $value;
            }

            //filter column - collection
            $temp  = $cols->filter(function ($col) use ($c_date, $attendance) {
                /*
                    1     = Reg
                    2 - 6 = Lesson 1 - 5
                */
                return (
                    (strtolower($col->column_name)=='reg'      && strtolower($attendance->PeriodID)==1) ||
                    (strtolower($col->column_name)=='lesson 1' && strtolower($attendance->PeriodID)==2) ||
                    (strtolower($col->column_name)=='lesson 2' && strtolower($attendance->PeriodID)==3) ||
                    (strtolower($col->column_name)=='lesson 3' && strtolower($attendance->PeriodID)==4) ||
                    (strtolower($col->column_name)=='lesson 4' && strtolower($attendance->PeriodID)==5) ||
                    (strtolower($col->column_name)=='lesson 5' && strtolower($attendance->PeriodID)==6))&&
                    ($col->day_of_week==($c_date['order']+1)
                ) ? true : false;
            });
            foreach ($temp as $value) {
                $c_col  = $value;
            }

            //morning || afternoon
            $register = Registration::updateOrCreate(
                [   //where
                    'pupil_id'           => $attendance->PupilID,
                    'date'               => $attendance->AttendanceDate,
                    'register_column_id' => $c_col->id,    //**
                ],
                [   //what to update
                    'pupil_id'           => $attendance->PupilID,
                    'date'               => $attendance->AttendanceDate,
                    'register_column_id' => $c_col->id,    //**
                    'attendance_id'      => 0,
                    'created_by'         => auth()->user()->id,
                    'updated_by'         => auth()->user()->id,
                    'year_group'         => $attendance->YearGroup,
                    'academic_year'      => $attendance->SchoolYear,
                    'notes'              => $attendance->AbsenceTypeSymbol,
                ]
            );
            // if($key==6)
            //     dd($c_date,$c_col,$attendance,$register,$key );
        }
    }
}
