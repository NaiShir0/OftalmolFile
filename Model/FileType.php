<?php
/**
 * This file is part of Oftalmologia plugin for FacturaScripts.
 * FacturaScripts Copyright (C) 2015-2025 Carlos Garcia Gomez <carlos@facturascripts.com>
 * Oftalmologia   Copyright (C) 2024-2025 Clinica Castillo <info@clinicastillo.es>
 *                Copyright (C) 2024-2025 Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */
namespace FacturaScripts\Plugins\OftalmolFile\Model;

use FacturaScripts\Core\Model\Base;
use FacturaScripts\Core\Session;
use FacturaScripts\Plugins\Oftalmol\src\Constants;

class FileType extends Base\ModelClass {

    use Base\ModelTrait;

    public $id;
    public $idSpeciality;
    public $typeName;
    public $creationDate;

    public function clear() {
        parent::clear();
        $this->idSpeciality = Constants::SPECIALITE_OPHTALMOLOGY;
        $this->creationDate = date(self::DATETIME_STYLE);
        $this->nick = Session::user()->nick;
    }

    /*
     * Returns the name of the column that is the model's primary key.
     *
     * @Return string
     */

    #[\Override]
    public static function primaryColumn(): string {
        return 'id';
    }

    /**
     * Returns the name of the table that uses this model.
     *
     * @return string
     */
    #[\Override]
    public static function tableName(): string {
        return 'oft_filetypes';
    }

    /**
     * Returns the url where to see / modify the data.
     *
     * @param string $type
     * @param string $list
     * @return string
     */
    public function url(string $type = 'auto', string $list = 'List'): string {
        return parent::url($type, 'ListAdministration?activetab=' . $list);
    }
}
