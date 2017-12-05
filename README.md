Wordpress to Drupal 8 Migration
===============================
To do the Wordpress to Drupal 8 migration, you should have Wordpress site database, Drush 7 and Drupal 8 site.

You can use the following 'migrate-manifest' drush command from Drupal 8 root to do the migration.

```bash
drush migrate-manifest modules/contrib/wp_migrate/manifest_wordpress.yml --legacy-db-url=mysql://{dbuser}:{dbpass}@localhost/{dbname} --legacy-db-prefix=wp_
```


The manifest_wordpress.yml file contains IDs of each migration Entity. Here is the one used for migration,

```
- wp_users
- wp_vocabulary
- wp_terms
- wp_posts
- wp_comments
```
