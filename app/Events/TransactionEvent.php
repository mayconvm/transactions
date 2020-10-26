<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Events;

use App\Models\Transaction;

/**
 * Classe TransactionEvent
 * @package App\Listeners
 */
class TransactionEvent extends Event
{
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }
}
