<?php

/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolMYAH;

use FacturaScripts\Core\Base\InitClass;
use FacturaScripts\Plugins\Oftalmol\Model;

class Init extends InitClass {

    #[\Override]
    public function init(): void {
        $this->loadExtension(new Extension\Controller\EditExpedient());
        $this->loadExtension(new Extension\Controller\EditTestRefraction());
        $this->loadExtension(new Extension\Controller\EditTestTearDuct());
        //$this->createModels();
    }

    #[\Override]
    public function uninstall(): void {
        // se ejecuta cada vez que se desinstale el plugin. Primero desinstala y luego ejecuta el uninstall.
    }

    #[\Override]
    public function update(): void {
        $this->loadExtension(new Extension\Controller\EditExpedient());
        //$this->createModels();
        //AddWidget::addWidget('filesattached', 'FacturaScripts\\Plugins\\TuPlugin\\Widget\\FilesAttachedWidget');
    }
}
