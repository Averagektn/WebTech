<?php

class FormBuilder
{
    public const METHOD_POST = 'post';
    public const METHOD_GET = 'get';
    protected string $method;
    protected string $action;
    protected string $submitValue;
    protected array $textFields;
    protected array $radioButtons;

    function __construct($method, $action, $submitValue)
    {
        $this->method = $method;
        $this->action = $action;
        $this->submitValue = $submitValue;
        $this->textFields = [];
        $this->radioButtons = [];
    }

    public function addTextField($name, $value): void
    {
        $this->textFields[] = array(
            'name' => $name,
            'value' => $value
        );
    }

    public function addRadioGroup($name, $values): void
    {
        foreach ($values as $value) {
            $this->radioButtons[] = array(
                'name' => $name,
                'value' => $value
            );
        }
    }

    public function getForm(): void
    {
        echo "<form method=\"" . $this->method . "\" action=\"" . $this->action . "\">";

        foreach ($this->textFields as $textField) {
            echo "<input type=\"text\" name=\"" . $textField['name'] . "\" value=\"" . $textField['value'] . "\" />";
        }

        foreach ($this->radioButtons as $radioButton) {
            echo "<input type=\"radio\" name=\"" . $radioButton['name'] . "\" value=\"" . $radioButton['value'] . "\" />";
        }

        echo "<input type=\"submit\" value=\"" . $this->submitValue . "\" />";
        echo "</form>";
    }
}