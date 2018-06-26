# BLT Twig bridge

Twig is such a powerful templating language and the built in [replace](https://robo.li/tasks/File/#replace) command in robo completely inadiquate. Tasks such as building a default settings.php for Drupal where you take many different variables from the blt config yaml file can very challenging.

```
$this->taskReplaceInFile('box/robo.txt')
 ->from(
 [
    '##dbname##',
    '##dbhost##'
 ])
 ->to(
 [
    $this->getConfigValue('drupal.db.database'),
    $this->getConfigValue('drupal.db.host')
 ])
 ->run();
```

Compared to twig

```
$this->taskTwig($this)
     ->setTemplatesDirectory($this->getConfigValue('repo.root') . '/blt/Templates')
     ->applyTemplate('settings.php.twig', $this->getConfigValue('drupal.settings_file'))
     ->applyTemplate('sites.php.twig', $this->getConfigValue('docroot') . '/sites')
     ->run();
```

Using the template which is provided.

```
$databases['default']['default'] = array (
  'database' => '{{ config.drupal.db.database }}',
  'username' => '{{ config.drupal.db.username }}',
  'password' => '{{ config.drupal.db.password }}',
  'prefix' => '',
  'host' => '{{ config.drupal.db.host }}',
  'port' => '{{ config.drupal.db.port }}',
  'namespace' => 'Drupal\\Core\\Database\\Driver\\mysql',
  'driver' => 'mysql',
);
```

The task and config variables are automatically exposed during the ::twigTask(), so your templates have full access to every config variable while it is being generated.