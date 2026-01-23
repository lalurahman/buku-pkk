<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\CashFlow;
use App\Models\FunctionalPosition;
use App\Models\GuestBook;
use App\Models\IncomingLetter;
use App\Models\Inventory;
use App\Models\LetterDisposition;
use App\Models\Member;
use App\Models\MemberRole;
use App\Models\MeetingMinute;
use App\Models\OutgoingLetter;
use App\Models\OutgoingLetterCc;
use App\Models\SourceFund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 3 Member Roles
        $memberRoles = [
            ['name' => 'Ketua'],
            ['name' => 'Sekretaris'],
            ['name' => 'Bendahara'],
            ['name' => 'Anggota'],
        ];

        $functionalPositions = [
            ['name' => 'TP PKK'],
            ['name' => 'Kader Umum'],
            ['name' => 'Kader Khusus'],
        ];

        foreach ($memberRoles as $role) {
            MemberRole::create($role);
        }

        foreach ($functionalPositions as $position) {
            FunctionalPosition::create($position);
        }
        // Create 3 Source Funds
        $sourceFunds = [
            ['name' => 'APBD'],
            ['name' => 'Swadaya Masyarakat'],
            ['name' => 'Donasi'],
        ];

        foreach ($sourceFunds as $fund) {
            SourceFund::create($fund);
        }

        // Create 50 Members
        Member::factory(50)->create();

        // Create 100 Cash Flows (70% income, 30% expense)
        CashFlow::factory(100)->create();

        // Create 50 Incoming Letters
        IncomingLetter::factory(86)->create();

        // Create 50 Outgoing Letters
        OutgoingLetter::factory(50)->create();

        // Create 70 Inventories
        Inventory::factory(70)->create();

        // Create 50 Activities
        Activity::factory(68)->create();

        // Create 50 Guest Books
        GuestBook::factory(45)->create();

        // Create 50 Meeting Minutes
        MeetingMinute::factory(50)->create();

        // Create 50 Letter Dispositions
        LetterDisposition::factory(50)->create();

        // Create 50 Outgoing Letter CCs
        OutgoingLetterCc::factory(50)->create();
    }
}
