<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateClientGoalsToGoalModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-client-goals-to-goal-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate existing client goals from JSON field to Goal model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting migration of client goals to Goal model...');

        // Get all clients with goals
        $clients = \App\Models\ClientProfile::whereNotNull('goals')->get();

        if ($clients->isEmpty()) {
            $this->info('No client goals found to migrate.');
            return;
        }

        $this->info("Found {$clients->count()} clients with goals to migrate.");

        $bar = $this->output->createProgressBar($clients->count());
        $bar->start();

        $migratedCount = 0;
        $skippedCount = 0;

        foreach ($clients as $client) {
            try {
                $goals = json_decode($client->goals, true);

                if (is_array($goals) && !empty($goals)) {
                    foreach ($goals as $goalTitle) {
                        // Check if goal already exists to avoid duplicates
                        $existingGoal = \App\Models\Goal::where('client_id', $client->id)
                            ->where('title', $goalTitle)
                            ->where('type', 'client_set')
                            ->first();

                        if (!$existingGoal) {
                            \App\Models\Goal::create([
                                'client_id' => $client->id,
                                'trainer_id' => $client->trainer_id, // May be null for client-set goals
                                'title' => $goalTitle,
                                'category' => $this->mapGoalToCategory($goalTitle),
                                'type' => 'client_set',
                                'measurement_type' => 'custom', // Default for client goals
                                'status' => 'active',
                                'priority' => 3, // Medium priority
                                'is_active_for_matching' => true, // Used for program matching
                                'start_date' => $client->joined_date ?? now(),
                            ]);
                            $migratedCount++;
                        } else {
                            $skippedCount++;
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error migrating goals for client {$client->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Migration completed!");
        $this->info("Goals migrated: {$migratedCount}");
        $this->info("Goals skipped (already exist): {$skippedCount}");

        // Optional: Remove the old goals column after verification
        if ($this->confirm('Do you want to remove the old goals column from client_profiles table?')) {
            $this->call('migrate', [
                '--path' => 'database/migrations/remove_goals_from_client_profiles.php'
            ]);
        }
    }

    /**
     * Map goal title to category
     */
    private function mapGoalToCategory(string $goalTitle): string
    {
        $goalTitle = strtolower($goalTitle);

        if (str_contains($goalTitle, 'weight loss') || str_contains($goalTitle, 'lose weight')) {
            return 'weight_loss';
        }

        if (str_contains($goalTitle, 'weight gain') || str_contains($goalTitle, 'gain weight')) {
            return 'weight_gain';
        }

        if (str_contains($goalTitle, 'muscle') || str_contains($goalTitle, 'strength')) {
            return 'muscle_building';
        }

        if (str_contains($goalTitle, 'endurance') || str_contains($goalTitle, 'cardio')) {
            return 'endurance';
        }

        if (str_contains($goalTitle, 'flexibility') || str_contains($goalTitle, 'yoga')) {
            return 'flexibility';
        }

        return 'general_fitness'; // Default category
    }
}
