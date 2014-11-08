<?php namespace Dugan\Captain\Contracts;

interface CommandHandler
{
    public function handle($command);
}
