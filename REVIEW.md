# Branch review notes — feature/timeline-provider (OftalmolFile)

> Para Javi. Emite eventos de adjuntos del paciente para
> `PatientTimeline` (#128).

## TL;DR

- Nuevo `Lib/TimelineProviders/AttachmentsProvider` que recorre
  `oft_file_attachments_links` JOIN `oft_file_attachments`
  filtrando por paciente y emite un `TimelineEvent` por adjunto
  con icono según mimetype (PDF / imagen / vídeo / doc / xlsx /
  paperclip por defecto).
- `Init.php` registra el provider con `class_exists` guard.

## Cambios por archivo

| Archivo | Tipo | Notas |
|---|---|---|
| `Lib/TimelineProviders/AttachmentsProvider.php` | nuevo | JOIN con la tabla principal de adjuntos. Label = `fileTypeName` ("Consentimiento informado") si está, sino filename. Detail = filename cuando el typeName tomó el espacio. Icono por mimetype/extensión. |
| `Init.php` | modificado | `init()` registra el provider tras `loadModelExtensions()`. |

## Cómo probarlo

Requisitos: `OftalmolBase/feature/patient-timeline` activa.

1. Activar OftalmolFile + OftalmolBase + Oftalmol.
2. Subir un consentimiento (PDF) + una imagen (JPG) al paciente.
3. `PatientTimeline?idPatient=…`:
   - Adjunto PDF → icono file-pdf, label "Consentimiento informado".
   - Adjunto JPG → icono file-image.
4. Click → abre `EditFileAttachment`.
5. Filtro `?category=attachment` → solo adjuntos.

## Riesgo

- Cero schema (tablas ya existían en Base).
- Tolerante a deploy parcial.

## Dependencias

- Hermana de `OftalmolBase/feature/patient-timeline`,
  `OftalmolAgenda/feature/timeline-provider` y
  `ObelioTreatments/feature/timeline-provider`.

## Referencias

- Master Plan: `31-DASHBOARDS-DISENO-POR-PRUEBA.md` §4.
- Backlog: #128.
