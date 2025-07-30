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
use FacturaScripts\Plugins\Oftalmol\Model\FileType; // ¡IMPORTANTE: Importa tu nuevo modelo!
use Closure;

class EditFileAttachment {

    
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
