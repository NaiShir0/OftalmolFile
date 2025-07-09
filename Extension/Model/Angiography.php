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

class Angiography {

    public function save(): Closure {
        return function () {
            if (!empty($this->file)) {
                $file = new Model\FileAttachment();

                $expedient = new Model\Expedient();
                $expedient->loadFromCode($this->idExpedient);

                $patient = new Model\Patient();
                $patient->loadFromCode($expedient->idPatient);

                $file->fileName = src\Utils::generateFileName($patient->patientName, $this->creationDate, $this->getTestName());
                $file->filePath = $this->file;
                $file->fileType = "pdf";

                // PASAMOS LOS DATOS AL MODELO para que se cree el link automáticamente
                $file->idExpedient = $this->idExpedient;
                $file->idPatient = $patient->idPatient;
                //$file->idtestType = $this->tableName();
                $file->idTestRecord = $this->id;

                return $file->save();
            }

            return true;
        };
    }
}
