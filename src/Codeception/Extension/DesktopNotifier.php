<?php

namespace Codeception\Extension;

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
                ->setTitle('Codeception Tests results:')
                ->setBody($message)
                ->addOption('sound', 'Blow') // Only works on macOS (AppleScriptNotifier)
//                ->setIcon(__DIR__ . '/path/to/your/icon.png')
//                ->addOption('subtitle', 'Result type')// Only works on macOS (AppleScriptNotifier)
        ;

        $notifier->send($notification);
    }

}
