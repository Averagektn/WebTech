<?php

require_once __DIR__ . '/../task_2_1/FormBuilder.php';
class SafeFormBuilder extends FormBuilder {
    private function processRequests() {
        $values = array_merge($_POST, $_GET);
        foreach ($this->textFields as &$field) {
            if (isset($values[$field['name']])) {
                $field['value'] = $values[$field['name']];
            }
        }
    }

    public function getForm(): void {
        $this->processRequests();
        parent::getForm();
    }
}
