#!/bin/bash
set -m

# Function to check if Couchbase is ready
wait_for_couchbase() {
  echo "Waiting for Couchbase to be ready..."
  until $(curl --output /dev/null --silent --head --fail http://127.0.0.1:8091); do
    printf '.'
    sleep 2
  done
  echo "Couchbase is ready!"
}

/entrypoint.sh couchbase-server &

# Wait for Couchbase to be ready
wait_for_couchbase

# Setup cluster
couchbase-cli cluster-init -c 127.0.0.1:8091 \
    --cluster-name battleofstalingrad \
    --cluster-username Administrator \
    --cluster-password password \
    --services data,index,query \
    --cluster-ramsize 1024 \
    --cluster-index-ramsize 512

# Create bucket
couchbase-cli bucket-create -c 127.0.0.1:8091 \
    --bucket battleofstalingrad \
    --username Administrator \
    --password password \
    --bucket-type couchbase \
    --bucket-ramsize 256

fg 1