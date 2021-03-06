#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" <<-EOSQL
    CREATE USER $ADOPTION_DB_USER WITH PASSWORD '$ADOPTION_DB_PASS';
    CREATE DATABASE $ADOPTION_DB_NAME;
    GRANT ALL PRIVILEGES ON DATABASE $ADOPTION_DB_NAME TO $ADOPTION_DB_NAME;
EOSQL
