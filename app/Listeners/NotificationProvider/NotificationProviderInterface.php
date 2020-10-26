<?php
/**
 * interface Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Listeners\NotificationProvider;

use App\Models\Transaction;
use App\Providers\Http\AdapterProviderInterface;

/**
 * Classe NotificationProviderInterface
 * @package App\Listeners\NotificationProvider
 */
interface NotificationProviderInterface
{
    /**
     * Method construct
     * @param AdapterProvider $adapter Adapter to connection
     */
    public function __construct (AdapterProviderInterface $adapter);

    /**
     * Send notification
     * @param  array $data Data notification
     * @return array
     */
    public function sendNotification(array $data) : array;

    /**
     * Settings configuration
     * @param array $settings Settings
     */
    public function setSettings(array $settings) : void;
}
