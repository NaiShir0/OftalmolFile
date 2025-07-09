<?php

/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolFile;

use FacturaScripts\Core\Base\InitClass;

class Init extends InitClass {

    #[\Override]
    public function init(): void {
        $this->loadExtension(new Extension\Model\OCTMacule());
        $this->loadExtension(new Extension\Model\OCTPapille());
        $this->loadExtension(new Extension\Model\Angiography());
        $this->loadExtension(new Extension\Model\Campimetry());
        $this->loadExtension(new Extension\Model\Topography());
        $this->loadExtension(new Extension\Model\EndothelialCount());
        $this->loadExtension(new Extension\Model\Biometry());
        $this->loadExtension(new Extension\Model\Retinography());
    }

    #[\Override]
    public function uninstall(): void {
        // se ejecuta cada vez que se desinstale el plugin. Primero desinstala y luego ejecuta el uninstall.
    }

    #[\Override]
    public function update(): void {
    }
}
