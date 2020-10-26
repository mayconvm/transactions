<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Listeners;

use App\Events\TransactionEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Listeners\NotificationProvider\NotificationProviderInterface;

/**
 * Classe NotificationListener
 * @package App\Listeners
 */
class NotificationListener
{
    /**
     * Provider to notify
     * @var NotificationProviderInterface
     */
    private $notify;

    /**
     * Method constructor
     * @param NotificationProviderInterface $notify Provider to notify
     */
    public function __construct(NotificationProviderInterface $notify)
    {
        $this->notify = $notify;
    }

    /**
     * Handle the event.
     *
     * @param  App\Events\TransactionEvent  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {
        $dataToSend = [
            'message' => 'Transaction success.',
            'status' => true,
        ];
        // status ok
        if ($event->transaction->getStatus()) {
            $dataToSend['message'] = 'Transaction unsuccess.';
        }

        $result = $this->notify->sendNotification($dataToSend);
    }
}
