CordovalSyncerBundle
====================

Symfony2 Bundle for the Vespolina Syncer Library

##Install

Plug into your composer.json require section:

```json
    "cordoval/syncer-bundle": "dev-master@dev",
```

Run:
```cli
composer update cordoval/syncer-bundle
```

Activate bundle into your kernel:

```php
    new Cordoval\SyncerBundle\CordovalSyncerBundle();
```

Finally add your configuration like in the usage section below.

##Usage

```yml
cordoval_syncer:
    adapter:
        config: ~
        entities:
            customerProfile: ~
    manager:
      direction: download
      delay_dependency_processing: false
      use_id_mapping: true
      entities:
          product:
              strategy: incremental_id
      remotes:
          demo_system_1:
              adapter: Vespolina\Sync\Adapter\RemoteAdapter

parameters:
  cordoval.customer_profile_repo.class: Acme\DemoBundle\Entity\CustomerProfileRepository
  cordoval.customer_profile.class: Acme\DemoBundle\Entity\CustomerProfile
```

PR's welcome!

your friend the grace consumer,

@cordoval