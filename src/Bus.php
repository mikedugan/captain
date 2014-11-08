<?php namespace Dugan\Captain;

use Dugan\Captain\Contracts\CommandTranslator;

/**
 * Command bus that handles the execution of a command
 */
class Bus
{
    public function __construct(CommandTranslator $translator)
    {
        $this->translator = $translator ?: new Translator();
    }

    public function execute($command)
    {
        $handler = $this->translator->toCommandHandler($command);

        return (new $handler())->handle($command);
    }
}
