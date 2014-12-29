d8_migrate_wordpress
====================
To do the Wordpress to Drupal 8 migration, you should have Wordpress site database, Drush 7 and Drupal 8 site.

You can use the following 'migrate-manifest' drush command from Drupal 8 root to do the migration.

drush migrate-manifest manifest_wordpress.yml --legacy-db-url=mysql://{dbuser}:{dbpass}@localhost/{dbname}


The manifest_wordpress.yml file contains IDs of each migration Entity. Here is the one used for migration,

# A Wordpress posts/users/comments migration, with dependencies.
- posts
- users
- comments

