<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GoverningBody;

class GoverningBodySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GoverningBody::truncate();

        $members = [
            [
                'name' => 'Suvo Debnath',
                'post' => 'Founder & President',
                'description' => 'SUVO DEBNATH is the Founder & President of the organization SUVABANI FOUNDATION, professionally working as a Businessman (Online Business) and holds a B.Com Degree in Accountancy from Calcutta University. Driven by a strong sense of social responsibility, he plays a key role in advancing our mission of SUVABANI FOUNDATION. He believes in the power of community-driven change and works tirelessly to support and uplift underprivileged sections of society. Through his efforts, he aims to build a more inclusive and sustainable future.',
                'image' => 'governing_bodies/founder.webp',
                'order' => 1,
            ],
            [
                'name' => 'Mihir Debnath',
                'post' => 'Secretary',
                'description' => 'MIHIR DEBNATH is the Secretary of the organization, responsible for administrative management, documentation, and communication. He ensures that the NGO operates efficiently and in compliance with all necessary guidelines.',
                'image' => 'governing_bodies/Secretary.png',
                'order' => 2,
            ],
            [
                'name' => 'Suroj Halder',
                'post' => 'Cashier',
                'description' => 'SUROJ HALDER serves as the Cashier of the organization SUVABANI FOUNDATION and is responsible for managing financial transactions, maintaining accounts, and ensuring proper utilization of funds. He works at a Finance Company and holds a B.Com Degree in Accountancy from Calcutta University. With a strong understanding of financial management and accountability, Suroj Halder ensures transparency and accuracy in all financial matters of the organization.',
                'image' => 'governing_bodies/casher.jpeg',
                'order' => 3,
            ],
            [
                'name' => 'Smita Chakraborty',
                'post' => 'Communicating Officer',
                'description' => 'SMITA CHAKRABORTY is the Communicating Officer of SUVABANI FOUNDATION and by profession she works as a Customs Sircar Executive at a CHA company. She holds a Post Graduate degree from Rabindra Bharati University & studying Astgrology at IIA. She manages communication strategies, media relations, and digital outreach. Her expertise helps the organization strengthen its public presence and effectively engage with the community.',
                'image' => 'governing_bodies/co1.jpeg',
                'order' => 4,
            ],
            [
                'name' => 'Pulak Bhunre',
                'post' => 'Communicating Officer',
                'description' => 'As the Communicating Officer, PULAK BHUNRE manages the organization’s communication strategy, including public relations, digital outreach, and stakeholder engagement. He works as a Businessman and has completed Graduation Degree. He plays a vital role in ensuring clear messaging and strengthening the organization’s visibility and impact.',
                'image' => 'governing_bodies/co2.jpeg',
                'order' => 5,
            ]
        ];

        foreach ($members as $member) {
            GoverningBody::create($member);
        }
    }
}
