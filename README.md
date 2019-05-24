Wordpress to Drupal 8 Migration
===============================
To do the Wordpress to Drupal 8 migration, you should have Wordpress site
database and Drupal 8 site.

##Wordpress database settings
Add Wordpress database connection details in settings.php. E.g.,
```
$databases['migrate']['default'] = [
  'database' => 'wordpress',
  'username' => 'drupaluser',
  'password' => '',
  'host' => '127.0.0.1',
  'port' => '33067',
  'driver' => 'mysql',
  'prefix' => 'wp_',
];
```

##8.x-2.x
This branch is using default migration api - sqlbase and not dependent on migrate_manifest module.
You can run following drush commands to migrate Wordpress data into drupal 8.

```
drush ms
drush mim wp_users
drush mim wp_vocabulary
drush mim wp_terms
drush mim wp_posts
drush mim wp_comments
```

##8.x-1.x
This branch is using migrate_manifest module based approach.

You can use the following 'migrate-manifest' drush command from Drupal 8 root to
do the migration.

```bash
drush migrate-manifest modules/contrib/wp_migrate/manifest_wordpress.yml --legacy-db-url=mysql://{dbuser}:{dbpass}@localhost/{dbname} --legacy-db-prefix=wp_
```

The manifest_wordpress.yml file contains IDs of each migration Entity. Here is
the one used for migration,

```
- wp_users
- wp_vocabulary
- wp_terms
- wp_posts
- wp_comments
```
