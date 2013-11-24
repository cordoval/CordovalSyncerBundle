<?php

namespace Cordoval\SyncerBundle\Adapter;

use Vespolina\Sync\ServiceAdapter\AbstractServiceAdapter;
use Vespolina\Sync\Entity\EntityData;

class CIMAuthorizeNetAdapter extends AbstractServiceAdapter
{
    protected $remoteCustomers;
    protected $remoteProfiles;
    protected $size;
    protected $lastValue;

    public function fetchEntity($entityName, $remoteId)
    {
        switch ($entityName) {
            case 'customer':
                if (array_key_exists($remoteId, $this->remoteCustomers)) {
                    return new EntityData($entityName, $remoteId, '<xml>...blablabla...</xml>');
                }
                break;
            case 'profile':
                if (array_key_exists($remoteId, $this->remoteProfiles)) {
                    return new EntityData($entityName, $remoteId, '<xml>...blablabla...</xml>');
                }
                break;
            default:
                throw new \Exception('this should never be reached');
        }
    }

    public function fetchEntities($entityName, $lastValue, $size)
    {
        $out = array();

        switch ($entityName) {
            case 'customer':
                // Simple naive implementation comparing the entity id
                foreach ($this->remoteCustomers as $remoteCustomer) {
                    if (null != $size && count($out) == $size) {
                        return $out;
                    }

                    if ($remoteCustomer->id > $lastValue || null == $lastValue) {
                        $ed = new EntityData($entityName, $remoteCustomer->id);

                        // Indicate to the sync manager that we need the profile dependency
                        $ed->addDependency('profile', 'profile' . $remoteCustomer->id);
                        $out[] = $ed;
                    }
                }
                break;

            case 'profile':
                // Even more naive
                foreach ($this->remoteProfiles as $remoteProfile) {
                    if (null != $size && count($out) == $size) {
                        return $out;
                    }

                    $out[] = new EntityData($entityName, $remoteProfile->name);
                }
                break;
        }

        return $out;
    }

    public function transformEntityData(EntityData $entityData)
    {
        switch ($entityData->getEntityName()) {
            case 'customer':
                $customer = new LocalCustomer();
                // In reality the local persistence gateway would generate the local id
                $customer->id = 'local' . $entityData->getEntityId();

                $customer->profile = $entityData->getDependencyReference('profile');

                return $customer;

            case 'profile':
                $profile = new LocalCustomerProfile();
                // In reality the local persistence gateway would generate the local id
                $profile->name = $entityData->getEntityId();

                return $profile;
            default:
                throw new \Exception('this should never be reached');
        }
    }
}
