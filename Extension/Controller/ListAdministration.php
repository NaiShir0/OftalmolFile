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

use FacturaScripts\Core\Lib\ExtendedController\ListController;
use FacturaScripts\Plugins\Oftalmol\src\Constants;

/**
 * Master table set.
 *
 * @author Clinica Castillo <info@clinicastillo.es>
 * @author Jose Antonio Cuello Principal <yopli2000@gmail.com>
 */
class ListAdministration {

    use Closure;

    public function createViews(): Closure {
        return function (string $viewName = Constants::VIEW_LIST_FILEATTACHMENT) {
            $this->addView($viewName, 'FileAttachment', 'fileAttachment');
        };
    }
}
