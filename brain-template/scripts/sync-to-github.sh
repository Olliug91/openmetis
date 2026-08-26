#!/bin/bash

echo "Sincronizando Cerebro Digital a GitHub..."

# Comprobamos si hay cambios
if [[ -n $(git status -s) ]]; then
    git add .
    git commit -m "Actualización del cerebro: $(date +'%Y-%m-%d %H:%M:%S')"
    
    # Nos traemos primero los posibles cambios del VPS (bot de Telegram)
    git pull --rebase origin main
    
    # Y subimos todo mezclado
    git push origin main
    
    echo "¡Cambios subidos a GitHub con éxito!"
    
    # Opcional: Descomentar la siguiente línea si quieres que el VPS haga pull instantáneo
    # curl -s -X POST -H "User-Agent: Mozilla/5.0" -H "Content-Type: application/json" -H "Content-Length: 0" https://tu-dominio-vps.com/api/deploy
else
    echo "No hay cambios nuevos para sincronizar."
fi
