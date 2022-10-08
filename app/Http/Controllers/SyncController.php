<?php

namespace App\Http\Controllers;

use App\Models\Boarder;
use App\Models\Building;
use App\Models\Contact;
use App\Models\SchoolTerm;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
}
