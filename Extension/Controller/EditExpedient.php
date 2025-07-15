<?php

/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolFile\Extension\Controller;

use FacturaScripts\Plugins\OftalmolFile\src\Constants;
use FacturaScripts\Plugins\OftalmolFile\Model\FileType;
use Closure;

class EditExpedient {

    public function createViews(): Closure {

        return function (string $viewName = Constants::VIEW_EDIT_FILEATTACHMENT) {

            $column = $this->views[$viewName]->columnForName('fileTypeName');
            if ($column && $column->widget->getType() === 'select') {
                $fileTypesOptions = [];
                $results = FileType::all();
                foreach ($results as $row) {
                    $fileTypesOptions[] = [
                        'value' => $row->id, // Asumo que 'id' es la clave primaria de oft_filetypes
                        'title' => $row->typeName, // Este es el campo que quieres mostrar
                    ];
                }
                $column->widget->values = [];
                array_unshift($fileTypesOptions, ['value' => '', 'title' => '--- Seleccionar Tipo ---']);
                $column->widget->setValuesFromArray($fileTypesOptions);
            }
        };
    }
}
