<?php

namespace Dalamar\Codeception\Extension;

use Codeception\Event\PrintResultEvent;
use Codeception\Platform\Extension;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;

class DesktopNotifier extends Extension
{

    static $events = array('result.print.after' => 'notify');

    function notify(PrintResultEvent $event)
    {
        $result = $event->getResult();

        $notifier = NotifierFactory::create();

        $message = "Codeception Tests results: " .
            $result->count() . " test where " .
            $result->failureCount() . " failed, " .
            $result->errorCount() . " errors, " .
            $result->skippedCount() . " skipped, " .
            $result->notImplementedCount() . " not implemented.";

        $notification =
            (new Notification())
                ->setTitle('Codeception Tests Results')
                ->setBody($message);

        $notifier->send($notification);
    }

}
