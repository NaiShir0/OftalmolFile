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
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Plugins\OftalmolFile\Model\FileType; // ¡IMPORTANTE: Importa tu nuevo modelo!
use Closure;

class EditFileAttachment {

    public function createViews(): Closure {

        return function (string $viewName = Constants::VIEW_EDIT_FILEATTACHMENT) {

            $column = $this->views[$viewName]->columnForName('fileTypeName');
            if ($column && $column->widget->getType() === 'select') {

                $fileTypesOptions = [];

                // Obtenemos todos los registros de la tabla oft_filetypes
                // Recuerda que Tools::getAll() devuelve objetos, no arrays asociativos.
                $results = FileType::all();

                // Recorremos los resultados para formatearlos como el select espera
                foreach ($results as $row) {
                    // El 'value' será el ID del tipo de archivo y el 'title' será el typeName
                    $fileTypesOptions[] = [
                        'value' => $row->id, // Asumo que 'id' es la clave primaria de oft_filetypes
                        'title' => $row->typeName, // Este es el campo que quieres mostrar
                    ];
                }
                $column->widget->values = [];
                $column->widget->setValuesFromArray($fileTypesOptions);

                // Opcional: Si quieres añadir una opción inicial como "Seleccionar tipo...", puedes usar array_unshift
                // array_unshift($fileTypesOptions, ['value' => '', 'title' => '--- Seleccionar Tipo ---']);
                // $column->widget->setValuesFromArray($fileTypesOptions);
            }
        };
    }

    public function loadData(): Closure {
        return function ($viewName, $view) {
            $mainViewName = $this->getMainViewName();
            switch ($viewName) {
                case Constants::VIEW_LIST_FILEATTACHMENT:
                    $idPatient = $this->getViewModelValue($mainViewName, 'idPatient');
                    $where = [
                        new DataBaseWhere('idPatient', $idPatient)];
                    $view->loadData('', $where);
                    break;
                default:
                    parent::loadData($viewName, $view);
                    break;
            }
        };
    }
}
