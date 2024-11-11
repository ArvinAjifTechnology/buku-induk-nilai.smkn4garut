<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Student;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'admin@gmail.com',
            'email' => 'admin@gmail.com',
            // 'password' => bcrypt('AkjL9OnM5G(j(k)/8/[/(;:*%EJn'),
            'password' => bcrypt('admin@gmail.com'),
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'staff@gmail.com',
            'email' => 'staff@gmail.com',
            // 'password' => bcrypt('AkjL9OnM5G(j(k)/8/[/(;:*%EJn'),
            'password' => bcrypt('staff@gmail.com'),
            'role' => 'student_affairs_staff',
        ]);
        $this->call(SemesterSeeder::class);
        $this->call(MajorSeeder::class);
        $this->call(SchoolClassSeeder::class);
        $this->call(EntryYearSeeder::class);
        $this->call(GraduationYearSeeder::class);
        $this->call(SubjectTypeSeeder::class);
        $this->call(SubjectSeeder::class);
        // Student::factory(8200)->create();
    }
}
