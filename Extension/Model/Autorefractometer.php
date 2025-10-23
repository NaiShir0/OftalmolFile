<?php

/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolFile\Extension\Model;

use FacturaScripts\Plugins\OftalmolFile\src;
use FacturaScripts\Dinamic\Model;
use Closure;

class Autorefractometer {

 public function save(): Closure {
        return function () {
            $saved = true;

            if (!empty($this->ODfile)) {
                $saved = src\Utils::saveFile(
                                filePath: $this->ODfile,
                                idExpedient: $this->idExpedient,
                                idTestype: $this->idTestType,
                                idTestRecord: $this->id,
                                creationDate: $this->creationDate,
                                testName: $this->getTestName() . ' SC',
                                fileTypeName: $this->getTestName(),
                        ) || $saved;
            }

            if (!empty($this->OSfile)) {
                $saved = src\Utils::saveFile(
                                filePath: $this->OSfile,
                                idExpedient: $this->idExpedient,
                                idTestype: $this->idTestType,
                                idTestRecord: $this->id,
                                creationDate: $this->creationDate,
                                testName: $this->getTestName() . ' CC',
                                fileTypeName: $this->getTestName(),
                        ) || $saved;
            }

            return $saved;
        };
    }
}
