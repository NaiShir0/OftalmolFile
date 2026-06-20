<?php
/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\OftalmolFile\Controller;

use FacturaScripts\Core\Lib\ExtendedController\EditController;

/**
 * Class for edit the tests consultation.
 *
 * @author Clinica Castillo <info@clinicastillo.es>
 */
class EditFileType extends EditController
{

    /**
     * Returns the class name of the model to use in the editView.
     */
    public function getModelClassName(): string {
        return 'FileType';
    }

    /**
     * Return the basic data for this page.
     *
     * @return array
     */
    public function getPageData(): array {
        $data = parent::getPageData();
        $data['menu'] = 'ophthalmology';
        $data['title'] = 'fileType';
        $data['icon'] = 'fas fa-bezier-curve';
        return $data;
    }
}