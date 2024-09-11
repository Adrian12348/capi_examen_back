<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;
use App\Models\Phone;
use App\Models\Email;
use App\Models\Address;
use Faker\Factory as Faker;

class ContactSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 5000) as $index) {
            // Crear un contacto
            $contact = Contact::create([
                'name' => $faker->name,
                'notes' => $faker->sentence,
                'birthday' => $faker->date,
                'website' => $faker->url,
                'company' => $faker->company,
            ]);

            // Crear entre 1 y 3 teléfonos para el contacto
            foreach (range(1, $faker->numberBetween(1, 3)) as $i) {
                Phone::create([
                    'contact_id' => $contact->id,
                    'phone' => $faker->phoneNumber,
                ]);
            }

            // Crear entre 1 y 2 emails para el contacto
            foreach (range(1, $faker->numberBetween(1, 2)) as $i) {
                Email::create([
                    'contact_id' => $contact->id,
                    'email' => $faker->email,
                ]);
            }

            // Crear entre 1 y 2 direcciones para el contacto
            foreach (range(1, $faker->numberBetween(1, 2)) as $i) {
                Address::create([
                    'contact_id' => $contact->id,
                    'address' => $faker->address,
                ]);
            }
        }
    }
}
