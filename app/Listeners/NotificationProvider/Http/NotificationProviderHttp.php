<?php
/**
 * Classe Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Listeners\NotificationProvider\Http;

use App\Models\Transaction;
use App\Providers\Http\AdapterProviderInterface;
use App\Listeners\NotificationProvider\NotificationProviderInterface;

/**
 * Classe NotificationProviderHttp
 * @package App\Listeners\NotificationProvider\Http
 */
class NotificationProviderHttp implements NotificationProviderInterface
{
    /**
     * Array with settings to connection
     * @var array
     */
    private $settings;

    /**
     * Adapter
     * @var AdapterProvider
     */
    private $adapter;

    /**
     * Method construct
     * @param AdapterProvider $adapter Adapter to connection
     */
    public function __construct (AdapterProviderInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Settings configuration
     * @param array $settings Settings
     */
    public function setSettings(array $settings) : void
    {
        $this->settings = $settings;
    }

    /**
     * Send notification
     * @param  array $data Data notification
     * @return array
     */
    public function sendNotification(array $data) : array
    {
        $result = json_decode($this->adapter->send($data), true);

        if (empty($result)) {
            return [];
        }

        return $result;
    }
}
