<?php

/**
 * This file is part of OftalmolFile plugin for FacturaScripts.
 * Obeliomed Copyright (C) 2024-2026 José Joaquín García González <jquingarcia@gmail.com>
 *                                     Javier Navarro García <jnavgar69@gmail.com>
 *
 * This program and its files are under the terms of the license specified in the LICENSE file.
 */

namespace FacturaScripts\Plugins\OftalmolFile\Lib\TimelineProviders;

use FacturaScripts\Core\Base\DataBase;
use FacturaScripts\Plugins\OftalmolBase\Lib\TimelineEvent;
use FacturaScripts\Plugins\OftalmolBase\Lib\TimelineProvider;

/**
 * Emits a timeline event per file attachment linked to the patient
 * (`oft_file_attachments_links` JOIN `oft_file_attachments`).
 *
 * The label uses the friendly file type name when known
 * ("Consentimiento informado"), otherwise the raw filename.
 */
final class AttachmentsProvider implements TimelineProvider
{
    public function key(): string
    {
        return 'files.attachments';
    }

    public function label(): string
    {
        return 'Adjuntos';
    }

    public function getEvents(int $idPatient, ?string $fromIsoDate = null, ?string $toIsoDate = null): array
    {
        $db = new DataBase();
        $sql = "
            SELECT l.idFile, l.idExpedient, l.fileTypeName,
                   f.fileName, f.fileType, f.uploadDate, f.nick, f.generalNote
            FROM oft_file_attachments_links l
            INNER JOIN oft_file_attachments f ON f.id = l.idFile
            WHERE l.idPatient = " . (int) $idPatient . "
        ";
        if ($fromIsoDate !== null) {
            $sql .= " AND f.uploadDate >= '" . $db->escapeString($fromIsoDate) . "'";
        }
        if ($toIsoDate !== null) {
            $sql .= " AND f.uploadDate <= '" . $db->escapeString($toIsoDate) . "'";
        }
        $sql .= " ORDER BY f.uploadDate DESC";

        $rows = $db->select($sql) ?: [];

        $events = [];
        foreach ($rows as $row) {
            $label = $row['fileTypeName'] ?: ($row['fileName'] ?: 'Adjunto');
            $detail = $row['fileName'] && $row['fileTypeName']
                ? $row['fileName']
                : ($row['generalNote'] ?: null);

            $events[] = new TimelineEvent(
                date: substr((string) ($row['uploadDate'] ?? ''), 0, 10),
                category: 'attachment',
                label: $label,
                color: 'secondary',
                icon: self::iconForType((string) ($row['fileType'] ?? '')),
                detail: $detail,
                url: 'EditFileAttachment?code=' . $row['idFile'],
                time: null,
                archetype: '',
                idExpedient: $row['idExpedient'] !== null ? (int) $row['idExpedient'] : null,
                meta: ['idFile' => $row['idFile'], 'fileType' => $row['fileType']]
            );
        }
        return $events;
    }

    private static function iconForType(string $fileType): string
    {
        $low = strtolower($fileType);
        return match (true) {
            str_contains($low, 'pdf')   => 'fa-solid fa-file-pdf',
            str_contains($low, 'image') || str_contains($low, 'jpg') || str_contains($low, 'png') || str_contains($low, 'jpeg') => 'fa-solid fa-file-image',
            str_contains($low, 'video') || str_contains($low, 'mp4') => 'fa-solid fa-file-video',
            str_contains($low, 'doc')   => 'fa-solid fa-file-word',
            str_contains($low, 'xls') || str_contains($low, 'sheet') => 'fa-solid fa-file-excel',
            default                     => 'fa-solid fa-paperclip',
        };
    }
}
