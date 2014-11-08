<?php  namespace Dugan\Captain;

use ReflectionClass;

abstract class Command
{
    /**
     * Map an array of input to a command's properties.
     *
     * Adapted from laracasts/commander's CommanderTrait
     *
     * @param  array $input
     * @throws InvalidArgumentException
     * @author Taylor Otwell
     *
     * @return mixed
     */
    public static function fromInput(array $input)
    {
        $dependencies = [];
        $class = new ReflectionClass(self::class);
        foreach ($class->getConstructor()->getParameters() as $parameter) {
            $name = $parameter->getName();
            if (array_key_exists($name, $input)) {
                $dependencies[] = $input[$name];
            } elseif ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                throw new InvalidArgumentException("Unable to map input to command: {$name}");
            }
        }

        return $class->newInstanceArgs($dependencies);
    }

    public function toArray($exclude = [])
    {
        $ret = [];
        foreach ($this as $k => $v) {
            if(! in_array($k, $exclude)) {
                $ret[$k] = $v;
            }
        }

        return $ret;
    }
}
