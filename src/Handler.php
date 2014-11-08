<?php  namespace Dugan\Captain;

use Dugan\Captain\Contracts\CommandHandler;
use Dugan\Captain\Contracts\CommandResponse;

abstract class Handler implements CommandHandler
{
    /**
     * @var \Dugan\Captain\Response
     */
    protected $response;

    public function __construct(CommandResponse $response = null)
    {
        $this->response = $response ?: new Response();
    }

    abstract public function handle($command);
}
