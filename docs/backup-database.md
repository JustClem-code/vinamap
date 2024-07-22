## Backup

docker exec -t your-db-container pg_dumpall -c -U your-db-user > dump_$(date +%Y-%m-%d_%H_%M_%S).sql

## Restore

cat your_dump.sql | docker exec -i your-db-container psql -U your-db-user -d your-db-name
