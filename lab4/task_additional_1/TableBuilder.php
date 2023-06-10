<?php

class TableBuilder {
    private array $columns = [];
    private array $rows = [];

    public function addColumn(string $name, string $header = ''): void {
        $this->columns[] = [
            'name' => $name,
            'header' => $header,
        ];
    }

    public function addRow(array $data): void {
        $this->rows[] = $data;
    }

    public function getTable(): string {
        $table = '<table>';

        // Table header
        if (!empty($this->columns)) {
            $table .= '<tr>';
            foreach ($this->columns as $column) {
                $table .= '<th>' . $column['header'] . '</th>';
            }
            $table .= '</tr>';
        }

        // Table body
        if (!empty($this->rows)) {
            foreach ($this->rows as $row) {
                $table .= '<tr>';
                foreach ($this->columns as $column) {
                    $columnName = $column['name'];
                    $table .= '<td>' . ($row[$columnName] ?? '') . '</td>';
                }
                $table .= '</tr>';
            }
        }

        $table .= '</table>';
        return $table;
    }
}
