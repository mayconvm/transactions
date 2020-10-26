<?php
/**
 * interface Authorization Provider
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Providers\Http;

use App\Models\Transaction;

/**
 * Classe AdapterProviderInterface
 * @package App\Providers\Http
 */
interface AdapterProviderInterface
{
    /**
     * Method construct
     * @param array $settings Settings
     */
    public function __construct (array $settings = []);

    /**
     * Send notification
     * @param  array $data Data to send
     * @return bool
     */
    public function send(array $data) : string;

    /**
     * Get settings
     * @param  string $key Key to settings
     * @return mixed
     */
    public function getSettings(string $key);
}
