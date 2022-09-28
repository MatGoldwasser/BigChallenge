<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [ //all permissions
            'fill_forms_personal_information_and_symptoms',
            'view_patients_submissions_doctor_view',
            'view_patients_submissions_patient_view',
            'patient_submission_detail_view',
            'list_pending_submissions',
            'accept_submission',
            'view_task_history',
            'upload_file',
            'finish_submission',
            'list_submissions_by_that_doctor',
            'download_prescription'
        ];

        foreach ($permissions as $permission){
            Permission::create([
                'name' => $permission
            ]);
        }

        $doctor = Role::create(['name' => 'Doctor']);
       $patient = Role::create(['name' => 'Patient']);

       $doctorPermissions = [
           'view_patients_submissions_doctor_view',
           'patient_submission_detail_view',
           'list_pending_submissions',
           'accept_submission',
           'view_task_history',
           'upload_file',
           'finish_submission',
           'list_submissions_by_that_doctor'
       ];

       foreach ($doctorPermissions as $permission){
           $doctor->givePermissionTo($permission);
       }

       $patientPermissions = [
           'fill_forms_personal_information_and_symptoms',
           'view_patients_submissions_doctor_view',
           'download_prescription'
       ];

        foreach ($patientPermissions as $permission){
            $patient->givePermissionTo($permission);
        }

    }
}
