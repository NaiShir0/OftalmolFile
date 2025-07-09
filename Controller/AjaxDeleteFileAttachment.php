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

use FacturaScripts\Core\Base\Controller;
use FacturaScripts\Plugins\Oftalmol\Model\FileAttachment;
use FacturaScripts\Plugins\Oftalmol\Model\FileAttachmentLink;

class AjaxDeleteFileAttachment extends Controller {

    public function privateCore(&$response, $user, $permissions) {
        $action = $this->request->get('action');
        $id = (int) $this->request->get('id');

        if ($action === 'delete') {
            $link = new \FacturaScripts\Plugins\Oftalmol\Model\FileAttachmentLink();
            if ($link->loadFromCode($id)) {
                if ($link->delete()) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No se pudo eliminar.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Archivo no encontrado.']);
            }

            exit;
        }
    }

    #[\Override]
    public function getPageData(): array {
        $data = parent::getPageData();
        $data['menu'] = 'ophthalmology';
        $data['title'] = 'ajax';
        $data['showonmenu'] = false;
        /* TODO: aquí sería bueno que apareciera el grupo de pruebas en el que estamos y el nombre del cliente */
        return $data;
    }

    public function deleteAction() {
        $id = (int) ($_GET['id'] ?? 0);

        $file = new FileAttachment();
        if (!$file->loadFromCode($id)) {
            return $this->responseJSON(['success' => false, 'message' => 'Archivo no encontrado.']);
        }

        // Borrar todos los enlaces
        $links = (new FileAttachmentLink())->all(['idFile' => $id]);
        foreach ($links as $link) {
            $link->delete();
        }

        // Eliminar archivo físico
        if (file_exists($file->filePath)) {
            if (!unlink($file->filePath)) {
                return $this->responseJSON(['success' => false, 'message' => 'No se pudo borrar el archivo físico.']);
            }
        }

        // Eliminar registro principal
        if ($file->delete()) {
            return $this->responseJSON(['success' => true]);
        }

        return $this->responseJSON(['success' => false, 'message' => 'No se pudo eliminar de la base de datos.']);
    }
}
