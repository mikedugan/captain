<?php namespace Dugan\Captain;

interface CommandResponse
{
    public function fail($message);

    public function success($message);
}
