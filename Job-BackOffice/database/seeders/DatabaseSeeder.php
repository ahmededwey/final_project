<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Faker\Guesser\Name;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
     
 User::firstOrCreate(
         ['email' => 'ahmed2@gmail.com'],
    [
        'name' => 'ahmed',
        'role' => 'admin',
        'password' => Hash::make('12345678'),
        'email_verified_at' => now(),
    ]
    
);
        $jobData = json_decode(file_get_contents(base_path('data\job_data.json')), true);
        $jobApplication = json_decode(file_get_contents(base_path('data\job_applications.json')), true);
        foreach($jobData['jobCategories']as $category){
            JobCategory::firstOrCreate([
                'name'=> $category,

            ]);
        }
        foreach ($jobData['companies'] as $company)
            {
                  $user= User::firstOrCreate(
         ['email' => fake()->unique()->safeEmail()],
         [
        'name' => fake()->Name(),
        'role' => 'company-owner',
        'password' => Hash::make('12345678'),
        'email_verified_at' => now(),
        ]);
            Company::firstOrCreate(['name'=> $company['name'],],
            [
                'address'=> $company['address'],
                'industry'=> $company['industry'],
                'website'=> $company['website'],
                'description'=> $company['description'],
                'ownerId'=> $user->id,
            ]);
        }


        foreach ($jobData['jobVacancies'] as $Vacancy) {
            $company=Company::where('name', $Vacancy['company'])->firstOrFail();
             $category=JobCategory::where('name', $Vacancy['category'])->firstOrFail();
            JobVacancy::firstOrCreate([
                'title'=> $Vacancy['title']
            ],
            
            [ 'description'=> $Vacancy['description'],
                  'location'=> $Vacancy['location'],
                   'type'=> $Vacancy['type'],
                    'salary'=> $Vacancy['salary'],
                     'companyId'=> $company->id,
                     'categoryId'=> $category->id,]);
        }

      foreach ($jobApplication['jobApplications'] as $app) {

    // Get a random job vacancy
    $jobVacancy = JobVacancy::inRandomOrder()->first();

    // Create job seeker
    $user = User::firstOrCreate(
        [
            'email' => fake()->unique()->safeEmail(),
        ],
        [
            'name' => fake()->name(),
            'role' => 'job-seeker',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]
    );

    // Create resume
    $resume = Resume::firstOrCreate(
        [
            'userId' => $user->id,
        ],
        [
            'filename' => $app['resume']['filename'],
            'fileUrl' => $app['resume']['fileUri'],
            'contactDetails' => $app['resume']['contactDetails'],
            'summary' => $app['resume']['summary'],
            'skills' => $app['resume']['skills'],
            'experience' => $app['resume']['experience'],
            'education' => $app['resume']['education'],
        ]
    );

    // Create job application
    JobApplication::firstOrCreate(
        [
            'userId' => $user->id,
            'resumeId' => $resume->id,
            'jobVacancyId' => $jobVacancy->id,
        ],
        [
            'status' => $app['status'],
            'aiGeneratedScore' => $app['aiGeneratedScore'],
            'aiGeneratedFeedback' => $app['aiGeneratedFeedback'],
        ]
    );
}
    }
}
