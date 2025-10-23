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

use FacturaScripts\Core\Template\InitClass;

class Init extends InitClass {

    #[\Override]
    public function init(): void {

        $this->loadExtension(new Extension\Controller\EditPatient());
        $this->loadExtension(new Extension\Controller\ListAdministration());
        $this->loadExtension(new Extension\Controller\EditFileAttachment());

        $this->loadModelExtensions();
    }

    #[\Override]
    public function uninstall(): void {
        // se ejecuta cada vez que se desinstale el plugin. Primero desinstala y luego ejecuta el uninstall.
    }

    #[\Override]
    public function update(): void {
        $this->loadModelExtensions();
    }

    private function loadModelExtensions() {
        $this->loadExtension(new Extension\Model\AmslerTest());
        $this->loadExtension(new Extension\Model\Angiography());
        $this->loadExtension(new Extension\Model\Autorefractometer());
        $this->loadExtension(new Extension\Model\Bielschoswsky());
        $this->loadExtension(new Extension\Model\Biometry());
        $this->loadExtension(new Extension\Model\Biomicroscopy());
        $this->loadExtension(new Extension\Model\Campimetry());
        $this->loadExtension(new Extension\Model\CoverTest());
        $this->loadExtension(new Extension\Model\EndothelialCount());
        $this->loadExtension(new Extension\Model\Exophthalmometry());
        $this->loadExtension(new Extension\Model\EyeFundus());
        $this->loadExtension(new Extension\Model\EyelidFunction());
        $this->loadExtension(new Extension\Model\FlyTest());
        $this->loadExtension(new Extension\Model\FrisbyTest());
        $this->loadExtension(new Extension\Model\Frontofocometer());
        $this->loadExtension(new Extension\Model\Gonioscopy());
        $this->loadExtension(new Extension\Model\IshiharaTest());
        $this->loadExtension(new Extension\Model\JonesTest());
        $this->loadExtension(new Extension\Model\Keratometry());
        $this->loadExtension(new Extension\Model\OCTMacule());
        $this->loadExtension(new Extension\Model\OCTPapille());
        $this->loadExtension(new Extension\Model\OcularMotility());
        $this->loadExtension(new Extension\Model\Pachymetry());
        $this->loadExtension(new Extension\Model\PointOfConvergence());
        $this->loadExtension(new Extension\Model\RandotTest());
        $this->loadExtension(new Extension\Model\Retinography());
        $this->loadExtension(new Extension\Model\SchirmerTest());
        $this->loadExtension(new Extension\Model\Shiascopy());
        $this->loadExtension(new Extension\Model\SmileTest());
        $this->loadExtension(new Extension\Model\StereopsisFar());
        $this->loadExtension(new Extension\Model\SubjetiveRefraction());
        $this->loadExtension(new Extension\Model\TearDuctProbing());
        $this->loadExtension(new Extension\Model\TitmusTest());
        $this->loadExtension(new Extension\Model\TnoTest());
        $this->loadExtension(new Extension\Model\Tonometry());
        $this->loadExtension(new Extension\Model\TonometryBraley());
        $this->loadExtension(new Extension\Model\Topography());
        $this->loadExtension(new Extension\Model\VisualAcuity());
        $this->loadExtension(new Extension\Model\WorthLight());
    }
}
