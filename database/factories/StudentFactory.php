<?php

namespace Database\Factories;

use App\Models\EntryYear;
use App\Models\SchoolClass;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Ambil semua school_classes
        $schoolClasses = SchoolClass::all();

        // Pilih random school_class
        $schoolClass = $schoolClasses->random();

        // Ambil major yang terkait dengan school_class yang dipilih
        $majorIds = $schoolClass->major->id;
        return [
            'school_class_id' => $schoolClass->id,
            'major_id' => $majorIds,
            // 'entry_year_id' => EntryYear::inRandomOrder()->first()->id,
            // 'entry_year_id' => $this->faker->randomElement([55,56,57]),
            'entry_year_id' => $this->faker->randomElement([51,52,53]),
            'student_statuses' => $this->faker->randomElement(['active']),
            'full_name' => $this->faker->firstName . ' ' . $this->faker->lastName,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'nisn' => $this->faker->unique()->numerify('##########'),
            'nik' => $this->faker->unique()->numerify('#########'),
            'nis' => $this->faker->unique()->numerify('########'),
            'birth_date' => $this->faker->date('Y-m-d'),
            'birth_place' => $this->faker->city,
            'religion' => $this->faker->randomElement(['Islam']),
            'nationality' => $this->faker->country,
            'special_needs' => $this->faker->boolean,
            'address' => $this->faker->address,
            'rt' => $this->faker->optional()->numerify('##'),
            'rw' => $this->faker->optional()->numerify('##'),
            'village' => $this->faker->word,
            'district' => $this->faker->word,
            'postal_code' => $this->faker->optional()->postcode,
            'residence' => $this->faker->word,
            'height' => $this->faker->optional()->numberBetween(100, 200),
            'weight' => $this->faker->optional()->numberBetween(30, 100),
            'siblings' => $this->faker->optional()->numberBetween(1, 10),
            'phone' => $this->faker->optional()->phoneNumber,
            'email' => $this->faker->optional()->safeEmail,
            'father_name' => $this->faker->optional()->name,
            'father_birth_year' => $this->faker->optional()->year,
            'father_education' => $this->faker->optional()->word,
            'father_job' => $this->faker->optional()->word,
            'father_nik' => $this->faker->optional()->numerify('#########'),
            'father_special_needs' => $this->faker->boolean,
            'mother_name' => $this->faker->optional()->name,
            'mother_birth_year' => $this->faker->optional()->year,
            'mother_education' => $this->faker->optional()->word,
            'mother_job' => $this->faker->optional()->word,
            'mother_nik' => $this->faker->optional()->numerify('#########'),
            'mother_special_needs' => $this->faker->boolean,
            'guardian_name' => $this->faker->optional()->name,
            'guardian_birth_year' => $this->faker->optional()->year,
            'guardian_education' => $this->faker->optional()->word,
            'guardian_job' => $this->faker->optional()->word,
            'exam_number' => $this->faker->optional()->numerify('########'),
            'smp_certificate_number' => $this->faker->optional()->numerify('########'),
            'smp_skhun_number' => $this->faker->optional()->numerify('########'),
            'school_origin' => $this->faker->optional()->word,
            'entry_date' => $this->faker->optional()->date('Y-m-d'),
            'smk_certificate_number' => $this->faker->optional()->numerify('########'),
            'smk_skhun_number' => $this->faker->optional()->numerify('########'),
            'exit_date' => $this->faker->optional()->date('Y-m-d'),
            'exit_reason' => $this->faker->optional()->word,
        ];
    }
}
