# Branch review notes — hotfix/fase-1 (OftalmolFile)

> Para Javi. Rama Fase 1 (declaración de dependencia + metadata).

## TL;DR

- `facturascripts.ini`: `require = 'OftalmolBase,Oftalmol'` (antes solo
  Base). El plugin carga 40+ extensiones sobre modelos que viven en
  Oftalmol; sin Oftalmol instalado, el deploy revienta (R1).
- `min_version` → 2025.71 (R3).
- `.gitignore` ignora Windows metadata.

## Notas

Esto es solo el **parche corto**. El plan definitivo (Fase 5 del plan
de reubicación) es **disolver OftalmolFile**: el widget + ajax + list
se mueven a OftalmolBase y los 40 save() de los Extension/Model se
fusionan en `BaseTestOftalmol::save()` en Oftalmol. Mientras tanto este
require evita el deploy roto.

## Smoke test

1. Intentar activar OftalmolFile sin Oftalmol → FS debe rechazar la
   activación con error de dependencia.
2. Activar con los tres (Base + Oftalmol + File) → carga limpia.
3. Subir un adjunto en un test oftalmológico → guardado funciona como
   siempre.

## Riesgo

Maser **usa OftalmolFile en producción** → riesgo medio. Pasar por
staging.

## Referencias

- `PLAN_REUBICACION_PLUGINS.md`, hallazgos R1, R3.
- Plan Fase 5 (disolución completa).
