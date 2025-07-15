<?php

/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolFile\src;

use FacturaScripts\Core\Base\MyFilesToken;
use FacturaScripts\Dinamic\Model;

/**
 * Description of Utils
 *
 * @author Nai
 */
class Utils {

    public static function generateFileName($patientName, $creationDate, $testName) {
        return $patientName . ' - ' . date('Y-m-d', strtotime($creationDate)) . ' - ' . $testName . '- ' . date('His');
    }

    public static function generateSecureUrl($path) {
        return $path . '?myft=' . MyFilesToken::get($path, true);
    }

    public static function saveFile($filePath, $idExpedient, $idTestype, $idTestRecord, $creationDate, $testName) {

        $file = new Model\FileAttachment();

        $expedient = new Model\Expedient();
        $expedient->loadFromCode($idExpedient);

        $patient = new Model\Patient();
        $patient->loadFromCode($expedient->idPatient);

        $file->fileName = self::generateFileName($patient->patientName, $creationDate, $testName);
        $file->filePath = $filePath;
        $file->fileType = "pdf";

        // PASAMOS LOS DATOS AL MODELO para que se cree el link automáticamente
        $file->idExpedient = $idExpedient;
        $file->idPatient = $patient->idPatient;
        $file->idTestType = $idTestype;
        $file->idTestRecord = $idTestRecord;

        return $file->save();
    }

    /**
     * Obtiene el nombre de la prueba de la tabla oft_tests basado en idTestType.
     * @return string El nombre de la prueba o una cadena vacía si no se encuentra.
     */
    public function getTestName(): string {
        // Usa DbQuery para buscar en la tabla 'oft_tests'
        // Filtra por la columna 'testType' usando el valor de $this->idTestType
        $testData = DbQuery::table('oft_tests') // Asegúrate que el nombre de la tabla sea 'oft_tests'
                ->whereEq('testType', $this->idTestType)
                ->first();

        if ($testData) {
            // Si se encontró el registro, extrae el valor de la columna 'testName'
            return $testData['testName'];
        }

        // Opcional: registrar una advertencia si no se encontró la prueba
        Tools::log()->warning('No se encontró el tipo de prueba con idTestType: ' . $this->idTestType);
        return ''; // Retorna una cadena vacía si no se encuentra
    }
}
