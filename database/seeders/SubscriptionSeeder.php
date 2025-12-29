<?php

namespace Database\Seeders;

use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{
    /**
     * NOTE: Seeder untuk membuat subscription trial untuk demo owner
     */
    public function run(): void
    {
        $owner = User::where('role', 'owner')->first();
        $trialPackage = SubscriptionPackage::where('type', 'trial')->first();

        if ($owner && $trialPackage) {
            Subscription::create([
                'owner_id' => $owner->id,
                'package_id' => $trialPackage->id,
                'status' => 'active',
                'start_date' => now(),
                'end_date' => now()->addDays($trialPackage->duration_days),
                'auto_renew' => false,
            ]);
        }
    }
}
