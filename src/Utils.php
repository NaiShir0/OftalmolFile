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


/**
 * Description of Utils
 *
 * @author Nai
 */
class Utils {

    public static function generateFileName($patientName, $creationDate, $testName) {
        return $patientName . ' - ' . date('Y-m-d', strtotime($creationDate)) . ' - ' . '(' . $testName . ')- ' . date('His');
    }

    public static function generateSecureUrl($path) {
        return $path . '?myft=' . MyFilesToken::get($path, true);
    }


  
}
