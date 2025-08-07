<?php

namespace FacturaScripts\Plugins\OftalmolFile\Lib\Widget;

use FacturaScripts\Core\Lib\Widget\WidgetText;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;
use FacturaScripts\Core\Tools;
use FacturaScripts\Plugins\Oftalmol\Model\FileAttachment;
use FacturaScripts\Plugins\Oftalmol\Model\FileAttachmentLink;
use FacturaScripts\Plugins\Oftalmol\src\Utils;
use FacturaScripts\Core\Lib\AssetManager;

class WidgetFilesAttached extends WidgetText {

    /** @var string */
    public $match;
    protected $idTestRecord = 0; // Nueva propiedad para almacenar el ID de la prueba

    /** @param array $data */
    public function __construct($data) {
        parent::__construct($data);

        $this->match = $data['match'] ?? 'id';
    }

    protected function assets() {

        AssetManager::add('js', FS_ROUTE . '/Dinamic/Assets/JS/WidgetFilesAttached.js');
    }

    public function edit($model, $title = '', $description = '', $titleurl = '') {
        $this->setValue($model);
        // Asigna el ID de la prueba del modelo a la propiedad del widget.
        // Asegúrate de que $model->idtestrecord (o como se llame en tu modelo)
        // contenga el ID de la prueba que quieres usar para filtrar.
        if (isset($model->id)) {
            $this->idTestRecord = (int) $model->id;
        }

        // generamos un nuevo ID para el campo del widget
        $this->id = $this->getUniqueId();

        $descriptionHtml = empty($description) ?
                '' :
                '<small class="form-text text-muted">' . Tools::lang()->trans($description) . '</small>';
        $label = Tools::lang()->trans($title);
        $labelHtml = $this->onclickHtml($label, $titleurl);
        $icon = empty($this->icon) ? 'fas fa-file' : $this->icon;

        // obtenemos el archivo seleccionado (si hay uno)
        $fileAttachment = new FileAttachment();
        $fileName = Tools::lang()->trans('attachedFiles');

        if ($this->value && $fileAttachment->loadFromCode($this->value)) {
            $fileName = $fileAttachment->fileName;
        }

        // si es solo lectura
        if ($this->readonly()) {
            return '<div class="form-group mb-2">'
                    . '<input type="hidden" id="' . $this->id . '" name="' . $this->fieldname . '" value="' . $this->value . '">'
                    . $labelHtml
                    . '<a href="' . ($fileAttachment->filePath ?? '#') . '" class="btn btn-block btn-outline-secondary" target="_blank">'
                    . '<i class="' . $icon . ' fa-fw"></i> ' . $fileName
                    . '</a>'
                    . $descriptionHtml
                    . '</div>';
        }

        // edición normal
        return '<div class="form-group mb-2">'
                . '<input type="hidden" id="' . $this->id . '" name="' . $this->fieldname . '" value="' . $this->value . '">'
                . $labelHtml
                . '<a href="#" class="btn btn-block btn-outline-secondary" data-toggle="modal" data-target="#modal_' . $this->id . '">'
                . '<i class="' . $icon . ' fa-fw"></i> '
                . '<span id="modal_span_' . $this->id . '">' . $fileName . '</span>'
                . '</a>'
                . $descriptionHtml
                . '</div>'
                . $this->renderModal($icon, $label);
    }

    protected function renderModal(string $icon, string $label): string {
        return '<div class="modal fade" id="modal_' . $this->id . '" tabindex="-1" aria-labelledby="modal_'
                . $this->id . '_label" aria-hidden="true">'
                . '<div class="modal-dialog modal-xl">'
                . '<div class="modal-content">'
                . '<div class="modal-header">'
                . '<h5 class="modal-title" id="modal_' . $this->id . '_label">'
                . '<i class="' . $icon . ' mr-1"></i> ' . $label
                . '</h5>'
                . '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                . '<span aria-hidden="true">&times;</span>'
                . '</button>'
                . '</div>'
                . '<div class="modal-body">'
                . '<div class="form-row">'
                . '<div class="col">' . $this->renderQueryFilter() . '</div>'
                . '</div>'
                . '</div>'
                . $this->renderFileList()
                . '</div>'
                . '</div>'
                . '</div>';
    }

    protected function renderQueryFilter(): string {
        return '<div class="input-group mb-2">'
                . '<input type="text" id="modal_' . $this->id . '_q" class="form-control" placeholder="'
                . Tools::lang()->trans('search') . '" onkeydown="widgetVarianteSearchKp(\'' . $this->id . '\', event);" autofocus>'
                . '<div class="input-group-append">'
                . '<button type="button" class="btn btn-primary" onclick="widgetVarianteSearch(\'' . $this->id . '\');">'
                . '<i class="fas fa-search"></i>'
                . '</button>'
                . '</div>'
                . '</div>';
    }

    protected function renderFileList(): string {
        $items = [];

        foreach ($this->files($this->idTestRecord) as $file) {
            $secureUrl = Utils::generateSecureUrl($file->filePath);

            $items[] = '<tr data-file-id="' . $file->id . '">'
                    . '<td>' . htmlspecialchars($file->fileName) . '</td>'
                    . '<td>' . htmlspecialchars($file->fileType) . '</td>'
                    . '<td class="text-nowrap">' . date('d/m/Y H:i', strtotime($file->uploadDate)) . '</td>'
                    . '<td class="text-right">'
                    . '<a href="' . $secureUrl . '" target="_blank" type="button" class="btn btn-sm btn-outline-primary mr-1">'
                    . '<i class="fas fa-download"></i>'
                    . '</a>'
                    . '<button type="button" class="btn btn-sm btn-outline-danger" onclick="deleteAttachedFile(' . $file->id . ', \'' . $this->id . '\')">'
                    . '<i class="fas fa-trash-alt"></i>'
                    . '</button>'
                    . '</td>'
                    . '</tr>';
        }

        return '<div class="table-responsive">'
                . '<table class="table table-hover mb-0">'
                . '<thead>'
                . '<tr>'
                . '<th>' . Tools::lang()->trans('fileName') . '</th>'
                . '<th>' . Tools::lang()->trans('fileType') . '</th>'
                . '<th>' . Tools::lang()->trans('uploadDate') . '</th>'
                . '<th>' . Tools::lang()->trans('actions') . '</th>'
                . '</tr>'
                . '</thead>'
                . '<tbody id="list_' . $this->id . '">' . implode('', $items) . '</tbody>'
                . '</table>'
                . '</div>';
    }

    public function files(int $idTestRecord = 0, string $query = '', int $idExpedient = 0, int $idPatient = 0, string $sort = 'date-desc', int $idTestType = 0): array {
        $list = [];
        $where = [];

        // Filtrar por idTestRecord
        if ($idTestRecord > 0) {
            $where[] = new DataBaseWhere('idTestRecord', $idTestRecord);
        }

        // Filtrar por expediente
        if ($idExpedient > 0) {
            $where[] = new DataBaseWhere('idExpedient', $idExpedient);
        }

        // Filtrar por paciente
        if ($idPatient > 0) {
            $where[] = new DataBaseWhere('idPatient', $idPatient);
        }

        // Filtrar por tipo de prueba
        if ($idTestType > 0) {
            $where[] = new DataBaseWhere('idTestType', $idTestType);
        }

        // Filtro por texto (en nombre de archivo o notas)
        if (!empty($query)) {
            $where[] = new DataBaseWhere('fileName|generalNote|profesionalNote', '%' . $query . '%', 'LIKE');
        }

        // Buscar archivos relacionados
        $linksModel = new FileAttachmentLink();
        foreach ($linksModel->all($where) as $link) {
            $file = new FileAttachment();
            if ($file->loadFromCode($link->idFile)) {
                $list[] = $file;
            }
        }

        return $list;
    }
}
