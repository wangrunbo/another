<?php
namespace App\Exception;

use Cake\Core\Exception\Exception;

class BotException extends Exception
{
    public function __construct($message = null, $code = 500)
    {
        if (empty($message)) {
            $message = 'Bot端异常';
        }
        parent::__construct($message, $code);
    }
}