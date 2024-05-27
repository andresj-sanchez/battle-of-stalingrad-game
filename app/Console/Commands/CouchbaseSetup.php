<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Couchbase\ClusterOptions;
use Couchbase\Cluster;
use Illuminate\Support\Str;
use App\Enums\GridState;

class CouchbaseSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'couchbase:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up Couchbase collections';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Couchbase connection settings
        $connectionString = sprintf('couchbase://%s', config('database.connections.couchbase.host'));

        $options = new ClusterOptions();
        $options->credentials(
            config('database.connections.couchbase.username'), 
            config('database.connections.couchbase.password')
        );

        $cluster = new Cluster($connectionString, $options);

        // Bucket and scope
        $bucketName = config("database.connections.couchbase.bucket");
        $bucket = $cluster->bucket($bucketName);
        // Create a scope named "game"
        $collectionManager = $bucket->collections();
        $scopeName = "game";
        $collectionManager->createScope($scopeName);

        // Create collections (similar to tables in SQL)
        $collections = [
            'tanks',
            'maps',
            'players',
            'scores',
            'gameSessions'
        ];

        foreach ($collections as $collectionName) {
            try {
                $collectionManager->createCollection($scopeName, $collectionName);
                $this->info("Collection '$collectionName' created successfully.");
            } catch (\Exception $e) {
                $this->error("Error creating collection '$collectionName': " . $e->getMessage());
            }
        }

        $this->generateDummyTanks($bucket, $scopeName, 'tanks');
        $this->generateDummyPlayersAndScores($bucket, $scopeName, 'players');
        $this->generateDummyMaps($bucket, $scopeName, 'maps');

        return 0;
    }

    /**
     * Generate dummy data for the 'tanks' collection.
     */
    private function generateDummyTanks($bucket, $scopeName, $collectionName)
    {
        $created_at = now()->toISOString();
        $updated_at = $created_at;
        $tanks = [
            [
                'type' => 'Panzer IV',
                'speed' => 6,
                'turret_range' => 8,
                'health_points' => 90,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'T-34',
                'speed' => 7,
                'turret_range' => 7,
                'health_points' => 85,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'Tiger I',
                'speed' => 5,
                'turret_range' => 9,
                'health_points' => 100,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'Sherman',
                'speed' => 6,
                'turret_range' => 7,
                'health_points' => 80,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'Panther',
                'speed' => 7,
                'turret_range' => 8,
                'health_points' => 95,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'KV-1',
                'speed' => 4,
                'turret_range' => 6,
                'health_points' => 110,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'M4A3E8',
                'speed' => 6,
                'turret_range' => 8,
                'health_points' => 75,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'IS-2',
                'speed' => 5,
                'turret_range' => 9,
                'health_points' => 105,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'Cromwell',
                'speed' => 8,
                'turret_range' => 7,
                'health_points' => 70,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            [
                'type' => 'Churchill',
                'speed' => 3,
                'turret_range' => 6,
                'health_points' => 120,
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ],
            // Add more dummy tank data as needed
        ];

        $this->insertDocuments($bucket, $scopeName, $collectionName, $tanks, 'Tank');
    }

    /**
     * Generate dummy data for the 'players' collection.
     */
    private function generateDummyPlayersAndScores($bucket, $scopeName, $collectionName)
    {
        $players = [];
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        for ($i = 1; $i <= 10; $i++) {
            $players[] = [
                'name' => "Player_$i",
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
        }

        $playerIds = $this->insertDocuments($bucket, $scopeName, $collectionName, $players, 'Player');

        // Generate dummy scores associated with players
        $scores = [];
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        foreach ($playerIds as $playerId) {
            $scores[] = [
                'player_id' => $playerId,
                'score' => rand(100, 1000),
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
        }

        $this->insertDocuments($bucket, $scopeName, 'scores', $scores, 'Score');
    }

    /**
     * Generate dummy data for the 'maps' collection.
     */
    private function generateDummyMaps($bucket, $scopeName, $collectionName)
    {
        $maps = [];
        $created_at = now()->toISOString();
        $updated_at = $created_at;

        // $rows = 20; // Random number of rows between 50 and 100
        // $cols = 20; // Random number of columns between 50 and 100
        // $mapGrid = $this->generateRandomMapGrid($rows, $cols);
        // $maps[] = [
        //     'grid' => $mapGrid,
        //     'name' => 'map_1',
        //     'created_at' => $created_at,
        //     'updated_at' => $updated_at,
        // ];

        for ($i = 1; $i <= 10; $i++) {
            $rows = rand(50, 100); // Random number of rows between 50 and 100
            $cols = rand(50, 100); // Random number of columns between 50 and 100
            $mapGrid = $this->generateRandomMapGrid($rows, $cols);
            $maps[] = [
                'grid' => $mapGrid,
                'name' => "map_$i",
                'created_at' => $created_at,
                'updated_at' => $updated_at,
            ];
        }

        $this->insertDocuments($bucket, $scopeName, $collectionName, $maps, 'Map');
    }

    /**
     * Generate a random map grid.
     */
    private function generateRandomMapGrid($rows, $cols)
    {
        $grid = [];

        for ($i = 0; $i < $rows; $i++) {
            $row = [];
            for ($j = 0; $j < $cols; $j++) {
                $cellState = $this->getRandomCellState();
                $row[] = $cellState;
            }
            $grid[] = $row;
        }

        return $grid;
    }

    /**
     * Get a random cell state using the GridState enum.
     */
    private function getRandomCellState()
    {
        // $states = [GridState::Empty]; // Only using Empty state
        // $states = [GridState::Empty, GridState::Obstacle]; // Only using Empty and Obstacle states
        // return $states[array_rand($states)];

        // 80% chance of being empty, 20% chance of being an obstacle
        return (rand(1, 100) <= 80) ? GridState::Empty : GridState::Obstacle;
    }

    /**
     * Insert documents into the collection and return their IDs.
     */
    private function insertDocuments($bucket, $scopeName, $collectionName, $documents, $documentType)
    {
        $ids = [];

        foreach ($documents as $document) {
            $documentId = Str::uuid();
            $ids[] = $documentId;
            $collection = $bucket->scope($scopeName)->collection($collectionName);
            $collection->upsert($documentId, $document);
            $this->info("Dummy $documentType data created: $documentId");
        }

        return $ids;
    }
}
