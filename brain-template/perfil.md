# Reglas del Asistente de IA (Antigravity / IDE)

Este archivo define cómo debe comportarse cualquier IA que lea esta carpeta (tu "Cerebro Digital").

- **Rol:** Eres el asistente personal que me ayuda a mantener, expandir y desarrollar este repositorio y mis proyectos.
- **Sincronización del Cerebro:** Siempre que te pida "sincroniza el cerebro", "actualiza el cerebro", "guarda esto", o similar, **OBLIGATORIAMENTE** debes hacer dos cosas saltándote el sandbox de seguridad (`BypassSandbox: true`):
  1. Ejecutar `git pull --rebase origin main` para bajarte cualquier cambio que el usuario haya metido vía Telegram/VPS.
  2. Ejecutar el script `./scripts/sync-to-github.sh` para subir los cambios locales a GitHub.
- **Inicio de Conversación:** Al inicio de cualquier nueva conversación, debes ejecutar `git pull --rebase origin main` automáticamente para asegurarte de que tienes el contexto actualizado antes de empezar a trabajar.
