```sh
FORKATE LA REPO
```

- UTILIZZATE LA STRUTTURA PRESENTE NELLA REPO

- ALL'INTERNO DI assets > db TROVERETE IL FILE DI MIGRAZIONE DEL DB 'Migrations.sql' CON IL NECESSARIO PER CREARE LA TABELLA utenti E eventi E PER MIGRARE I DATI DEGLI EVENTI

---------------------------------------------------------------------------------------------------------------------

INSTALLAZIONE

- lanciare composer install;
- aggiungere la colonna 'token' alla tabella 'utenti' in quanto non presente nella tabella di base nel file 'Migration.sql';
- modificare i parametri di connessione al database in db_conn.php (righe 9-12) e al SMPT in reset.php (righe 40-44);
