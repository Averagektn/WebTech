<?php

class Template
{
    private string $template;
    private array $placeholders = array();
    private array $labels = array();

    public function setMainTemplate(string $mainTemplateFilename): void
    {
        if (!is_file($mainTemplateFilename)) {
            throw new Exception('Main template [' . $mainTemplateFilename . '] not found.');
        }

        $this->template = file_get_contents($mainTemplateFilename);
    }

    public function setPlaceholderDirect(string $name, string $value): void
    {
        $this->template = str_replace($name, $value, $this->template);
    }

    public function setPlaceholder(string $name, string $value): void
    {
        $this->placeholders[$name] = $value;
    }

    public function setLabels(array $labels_array): void
    {
        $this->labels = $labels_array;
    }

    private function processDynamicVariables(array $dynamicVariableDataFromRegExp): string
    {
        $placeholderName = $dynamicVariableDataFromRegExp[1];
        if (isset($this->placeholders[$placeholderName])) {
            return $this->placeholders[$placeholderName];
        } else {
            throw new Exception('Placeholder [' . $placeholderName . '] not found.');
        }
    }

    private function processLabels(array $labelDataFromRegExp): string
    {
        $labelName = $labelDataFromRegExp[1];
        if (isset($this->labels[$labelName])) {
            return $this->labels[$labelName];
        } else {
            throw new Exception('Label [' . $labelName . '] not found.');
        }
    }

    private function processSubTemplates(array $subTemplateDataFromRegExp): string
    {
        $subtemplateName = 'templates/' . $subTemplateDataFromRegExp[1];
        if (is_file($subtemplateName)) {
            return file_get_contents($subtemplateName);
        } else {
            throw new Exception('SubTemplate [' . $subtemplateName . '] not found.');
        }
    }

    public function processTemplate()
    {
        while (preg_match("/{FILE=\"(.*)\"}|{DV=\"(.*)\"}|{LABEL=\"(.*)\"}/Ui", $this->template)) {
            $this->template = preg_replace_callback("/{DV=\"(.*)\"}/Ui", array($this, 'processDynamicVariables'), $this->template);
            $this->template = preg_replace_callback("/{LABEL=\"(.*)\"}/Ui", array($this, 'processLabels'), $this->template);
            $this->template = preg_replace_callback("/{FILE=\"(.*)\"}/Ui", array($this, 'processSubTemplates'), $this->template);
        }
    }

    public function getFinalPage(bool $removeComments = true, bool $compress = true): string
    {
        $temp = $this->template;
        if ($removeComments) {
            $temp = preg_replace("/<!--.*-->/sU", "", $temp);
        }

        if ($compress) {
            while (strpos($temp, '  ') !== false) {
                $temp = str_replace('  ', ' ', $temp);
            }

            while (strpos($temp, "\r\r") !== false) {
                $temp = str_replace("\r\r", "\r", $temp);
            }

            while (strpos($temp, "\n\n") !== false) {
                $temp = str_replace("\n\n", "\n", $temp);
            }

            while (strpos($temp, "\r\n\r\n") !== false) {
                $temp = str_replace("\r\n\r\n", "\r\n", $temp);
            }
        }

        return $temp;
    }

}