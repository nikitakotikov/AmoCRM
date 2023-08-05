<?php

namespace App;

class LeadDataBuilder 
{
    private $leadData = [];

    public function addLead($name, $price) {
        $this->leadData[] = [
            "name" => $name,
            "price" => $price,
            "custom_fields_values" => []
        ];
    }

    public function addField($fieldId, $value) {
        if (!empty($this->leadData)) {
            $this->leadData[count($this->leadData) - 1]["custom_fields_values"][] = [
                "field_id" => $fieldId,
                "values" => [
                    [
                        "value" => $value
                    ]
                ]
            ];
        }
    }

    public function build() {
        return $this->leadData;
    }
}
