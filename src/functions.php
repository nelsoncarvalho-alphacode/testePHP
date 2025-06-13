<?php
    function dataBrl($data) {
        if (empty($data)) {
            return '';
        }
        $date = new DateTime($data);
        return $date->format('d/m/Y');
    }