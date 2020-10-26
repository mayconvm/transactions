<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Providers\Http;

/**
 * Classe AdapterProviderInterface
 * @package App\Providers\Http
 */
class AdapterProviderHttp implements AdapterProviderInterface
{
    /**
     * Setting
     * @var array
     */
    private $settings;

    /**
     * Connection curl
     * @var stream
     */
    private $ch;

    /**
     * Method construct
     * @param array $settings Settings
     */
    public function __construct (array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * Send notification
     * @param  array $data Data to send
     * @return bool
     */
    public function send(array $data) : string
    {
        $this->prepareRequest($data);

        return $this->execute($data);
    }

    /**
     * Get settings
     * @param  string $key Key to settings
     * @return mixed
     */
    public function getSettings(string $key)
    {
        if (isset($this->settings[$key])) {
            return $this->settings[$key];
        }

        return null;
    }

    /**
     * Prepare request
     * @param  array  $data Data send
     * @return void
     */
    protected function prepareRequest(array $data)
    {
        $url = $this->getSettings('url');
        $headers = $this->getHeaders();

        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);
    }

    /**
     * Get headers
     * @return array
     */
    protected function getHeaders() : array
    {
        $headers = $this->getSettings('headers');

        if (empty($headers)) {
            return [
                'Content-Type: application/json',
                'Accept: application/json'
            ];
        }

        return $headers;
    }

    /**
     * Execute request
     * @param  array  $data Data to sendo
     * @return string
     */
    protected function execute(array $data) : string
    {
        $result = curl_exec($this->ch);
        curl_close($this->ch);

        return $result;
    }
}
