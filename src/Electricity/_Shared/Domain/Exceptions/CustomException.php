<?php

namespace Src\Electricity\_Shared\Domain\Exceptions;

final class CustomException extends \Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        //
    }

    public function render($request)
    {
        $temporallyClass = new \ReflectionClass(get_class($this));
        $class = explode('\\', $temporallyClass->getName());

        return response([
            'status' => $this->getCode(),
            'error' => true,
            'class' => end($class),
            'message' => $this->getMessage(),
        ]);
    }
}
