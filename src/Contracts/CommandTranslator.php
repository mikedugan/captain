<?php namespace Dugan\Captain\Contracts;

interface CommandTranslator
{
    /**
     * Parses a command object to a command handler
     *
     * @param $command
     * @throws \Exception
     * @return string
     */
    public function toCommandHandler($command);
}
