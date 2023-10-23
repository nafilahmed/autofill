<?php

namespace App\Listeners;

use LightSaml\ClaimTypes;
use LightSaml\Model\Assertion\Attribute;
use CodeGreenCreative\SamlIdp\Events\Assertion;

class SamlAssertionAttributes
{
    /**
     * Handle the event.
     */
    public function handle(Assertion $event)
    {
        $event->attribute_statement
        ->addAttribute(new Attribute(ClaimTypes::PPID, auth()->user()->id))
        ->addAttribute(new Attribute(ClaimTypes::NAME, auth()->user()->name));
    }
}
