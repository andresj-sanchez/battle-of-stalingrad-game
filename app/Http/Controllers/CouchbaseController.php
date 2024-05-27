<?php

namespace App\Http\Controllers;

use Couchbase\Cluster;
use Couchbase\ClusterOptions;
use Couchbase\Bucket;
use Couchbase\QueryOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CouchbaseController extends Controller
{
    private $cluster;
    private $bucket;
    private $scope;
    protected $bucketName;
    protected $scopeName;

    public function __construct()
    {
        $connectionString = sprintf('couchbase://%s', config('database.connections.couchbase.host'));

        $options = new ClusterOptions();
        $options->credentials(
            config('database.connections.couchbase.username'), 
            config('database.connections.couchbase.password')
        );

        $this->cluster = new Cluster($connectionString, $options);
        $this->bucketName = config('database.connections.couchbase.bucket');
        $this->bucket = $this->cluster->bucket($this->bucketName);
        $this->scopeName = 'game';
        $this->scope = $this->bucket->scope($this->scopeName);
    }

    public function createCollection(string $collectionName)
    {
        $collectionManager = $this->bucket->collections();
        try {
            $collectionManager->createCollection("game", $collectionName);
            return response()->json(["message" => "Collection '$collectionName' created successfully."]);
        } catch (\Exception $e) {
            Log::error("Error creating collection '$collectionName': " . $e->getMessage());
            return response()->json(["error" => "Error creating collection '$collectionName': " . $e->getMessage()], 500);
        }
    }

    public function getCollection(string $collectionName)
    {
        try {
            return $this->scope->collection($collectionName);
        } catch (\Exception $e) {
            Log::error("Error getting collection '$collectionName': " . $e->getMessage());
            return response()->json(["error" => "Error getting collection '$collectionName': " . $e->getMessage()], 500);
        }
    }

    public function insertDocument(string $collectionName, array $data)
    {
        try {
            $documentId = Str::uuid();
            $collection = $this->scope->collection($collectionName);
            $collection->upsert($documentId, $data);
            return response()->json(["message" => "Document inserted successfully.", "documentId" => $documentId]);
        } catch (\Exception $e) {
            Log::error("Error inserting document into '$collectionName': " . $e->getMessage());
            return response()->json(["error" => "Error inserting document into '$collectionName': " . $e->getMessage()], 500);
        }
    }

    public function getDocumentById(string $collectionName, string $documentId)
    {
        try {
            $collection = $this->scope->collection($collectionName);
            $result = $collection->get($documentId);
            $document = $result->content();
            $document['id'] = $documentId;
            return response()->json($document);
        } catch (\Exception $e) {
            Log::error("Error getting document from '$collectionName': " . $e->getMessage());
            return response()->json(["error" => "Error getting document from '$collectionName': " . $e->getMessage()], 500);
        }
    }

    public function getAllDocuments(string $collectionName)
    {
        $query = sprintf(
            'SELECT META().id AS id, * FROM `%s`.`%s`.`%s`',
            $this->bucketName,
            $this->scopeName,
            $collectionName
        );
        try {
            $result = $this->cluster->query($query);
            $rows = [];
            foreach ($result->rows() as $row) {
                $document = $row[$collectionName];
                $document['id'] = $row['id'];
                // $rows[] = $row;
                $rows[] = $document;
            }
            return response()->json($rows);
        } catch (\Exception $e) {
            Log::error("Error querying documents: " . $e->getMessage());
            return response()->json(["error" => "Error querying documents: " . $e->getMessage()], 500);
        }
    }

    public function updateDocument(string $collectionName, string $documentId, array $data)
    {
        return $this->insertDocument($collectionName, $documentId, $data);
    }

    public function deleteDocument(string $collectionName, string $documentId)
    {
        try {
            $collection = $this->scope->collection($collectionName);
            $collection->remove($documentId);
            return response()->json(["message" => "Document deleted successfully."]);
        } catch (\Exception $e) {
            Log::error("Error deleting document from '$collectionName': " . $e->getMessage());
            return response()->json(["error" => "Error deleting document from '$collectionName': " . $e->getMessage()], 500);
        }
    }

    public function queryDocuments(string $query, array $params = [])
    {
        try {
            $result = $this->cluster->query($query, QueryOptions::build()->positionalParameters($params));
            $rows = [];
            foreach ($result->rows() as $row) {
                $rows[] = $row;
            }
            return response()->json($rows);
        } catch (\Exception $e) {
            Log::error("Error querying documents: " . $e->getMessage());
            return response()->json(["error" => "Error querying documents: " . $e->getMessage()], 500);
        }
    }

    public function searchDocument(string $collectionName, string $indexName, string $query)
    {
        try {
            $searchResult = $this->cluster->searchQuery($indexName, $query);
            $rows = [];
            foreach ($searchResult->rows() as $row) {
                $rows[] = $row;
            }
            return response()->json($rows);
        } catch (\Exception $e) {
            Log::error("Error searching documents: " . $e->getMessage());
            return response()->json(["error" => "Error searching documents: " . $e->getMessage()], 500);
        }
    }
}
