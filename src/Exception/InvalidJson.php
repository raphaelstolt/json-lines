<?php

namespace Rs\JsonLines\Exception;

class InvalidJson extends \Exception
{
    private string $jsonFunctionErrorMessage;
    private string $invalidJson;

    /**
     * @param string $message
     * @param string $invalidJson
     */
    public function __construct(string $message, string $jsonFunctionErrorMessage, string $invalidJson)
    {
        parent::__construct($message);
        $this->jsonFunctionErrorMessage = $jsonFunctionErrorMessage;
        $this->invalidJson = $invalidJson;
    }

    /**
     * @return string
     */
    public function getJsonFunctionErrorMessage(): string
    {
        return $this->jsonFunctionErrorMessage;
    }

    /**
     * @return string
     */
    public function getInvalidJson(): string
    {
        return $this->invalidJson;
    }
}
