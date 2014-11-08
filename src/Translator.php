<?php  namespace Dugan\Captain;

use Dugan\Captain\Contracts\CommandTranslator;

/**
 *  This class provides translation of CommandRequest objects to their associated validator and handler classes
 *  The CommandRequest doesn't bind any methods, so any class can implement it
 */
class Translator implements CommandTranslator
{

    /**
     * Parses a command object to a command handler
     *
     * @param $command
     * @throws \Exception
     * @return string
     */
    public function toCommandHandler($command)
    {
        $handler = $this->assembleNamespace(get_class($command), 'Handler');
        if (! class_exists($handler)) {
            $message = "Command handler [$handler] does not exist.";
            throw new \Exception($message);
        }
        return $handler;
    }

    /**
     * Converts a command object class string to string for Validators and Handlers
     * ie: Users\Commands\RegisterUser -> Users\Handlers\RegisterUser
     *
     * @param $str
     * @return string
     */
    private function assembleNamespace($str, $type)
    {
        $parts = explode('\\', $str);
        //the actual class name
        $class = array_pop($parts);
        //the class's namespace
        $ns = str_replace('Commands', $type . 's', array_pop($parts));

        //reassemble and return
        return implode('\\', $parts) . '\\' . $ns . '\\' . $class;
    }
}
